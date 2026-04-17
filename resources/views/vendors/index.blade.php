@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
                @if (request()->is('vendors/approved'))
                    @php $type = 'approved'; @endphp
                    {{ trans('lang.approved_vendors') }}
                @elseif(request()->is('vendors/pending'))
                    @php $type = 'pending'; @endphp
                    {{ trans('lang.approval_pending_vendors') }}
                @else
                    @php $type = 'all'; @endphp
                    {{ trans('lang.all_vendors') }}
                @endif
            </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.vendor_list')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="admin-top-section"> 
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/vendor.png') }}"></span>
                        <h3 class="mb-0">{{trans('lang.vendor_list')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>  
                    <div class="d-flex top-title-right align-self-center">
                            <div class="select-box pl-3">
                                <select class="form-control status_selector filteredRecords">
                                    <option value="">{{trans("lang.status")}}</option>
                                    <option value="active">{{trans("lang.active")}}</option>
                                    <option value="inactive">{{trans("lang.in_active")}}</option>
                                </select>
                            </div>
                    </div>                  
                </div>
            </div>
        </div> 
       </div>
       <div class="table-list">
       <div class="row">
           <div class="col-12">
               <div class="card border">
                 <div class="card-header d-flex justify-content-between align-items-center border-0">
                   <div class="card-header-title">
                        <h3 class="text-dark-2 mb-2 h4">{{trans('lang.vendor_list')}}</h3>
                        <p class="mb-0 text-dark-2">{{trans('lang.vendor_table_text')}}</p>
                   </div>

                    <div class="card-header-right d-flex align-items-center">
                        <div class="card-header-btn mr-3">                   
                            <a class="btn-primary btn rounded-full" href="{!! route('vendors.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.createe_vendor')}}</a>
                        </div>
                    </div>     
                                  
                 </div>
                 <div class="card-body">
                         <div class="table-responsive m-t-10">
                            <table id="userTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    @php
                                        $type = $type ?? 'all';
                                        $permissions = json_decode(@session('user_permissions'), true) ?? [];
                                        $canDelete = ($type == "approved" && in_array('approve.vendors.delete', $permissions)) 
                                                  || ($type == "pending" && in_array('pending.vendors.delete', $permissions)) 
                                                  || ($type == "all" && in_array('vendors.delete', $permissions));
                                    @endphp

                                    @if($canDelete)
                                    <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll"
                                    class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label></th>
                                    @endif
                                    <th>{{trans('lang.vendor_info')}}</th>
                                    <th>{{trans('lang.vendor_phone')}}</th>
                                    <th>{{trans('lang.current_plan')}}</th>
                                    <th>{{trans('lang.expiry_date')}}</th>
                                    <th>{{trans('lang.date')}}</th>
                                    <th>{{trans('lang.active')}}</th>
                                    <th>{{trans('lang.actions')}}</th>
                                </tr>
                                </thead>  
                                <tbody id="append_list1">
                                </tbody>                             
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    var section_id = getCookie('section_id') || '';
    var database = firebase.firestore();
    var type = "{{ $type }}";
    var user_permissions = '<?php echo @session('user_permissions')?>';
    user_permissions = JSON.parse(user_permissions || '[]');
    var checkDeletePermission = {{ $canDelete ? 'true' : 'false' }};

    var placeholderImage = '';
    database.collection('settings').doc('placeHolderImage').get().then(function (snapshotsimage) {
        if (snapshotsimage.exists) {
            placeholderImage = snapshotsimage.data().image;
        }
    });

    $(document).ready(function () {
        console.log("Initializing userTable (Vendors) DataTable...");
        
        const table = $('#userTable').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: async function (data, callback, settings) {
                try {
                    const start = data.start;
                    const length = data.length;
                    const searchValue = data.search.value.toLowerCase();
                    const page = Math.floor(start / length) + 1;

                    let url = `vendors/?page=${page}&page_size=${length}`;
                    if (searchValue) url += `&search=${searchValue}`;
                    if (section_id) url += `&section=${section_id}`;
                    if (type === 'pending') url += `&is_document_verify=false`;
                    else if (type === 'approved') url += `&is_document_verify=true`;

                    const response = await syncToDjango(url, 'GET');

                    const responseData = (response && response.status && response.data)
                        ? response.data
                        : (response && response.results !== undefined ? response : null);

                    if (!responseData) {
                        callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                        return;
                    }

                    const totalRecords = responseData.total_items || responseData.count || 0;
                    $('.total_count').text(totalRecords);

                    let records = [];
                    if (responseData.results) {
                        for (const vendor of responseData.results) {
                            vendor.firestoreId = vendor.firestore_id || '';
                            vendor.storeName = vendor.title || '';
                            vendor.photo = vendor.photo || vendor.photo_url || '';
                            vendor.phone = vendor.phone || '';
                            vendor.active = vendor.is_active;
                            vendor.createdAt = vendor.created_at || null;

                            var htmlRows = await buildHTML(vendor);
                            records.push(htmlRows);
                        }
                    }

                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords,
                        recordsFiltered: totalRecords,
                        data: records
                    });
                } catch (e) {
                    console.error("Vendors DataTable Ajax Error:", e);
                    callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                }
            },
            order: (checkDeletePermission) ? [5, 'desc'] : [4, 'desc'],
            columnDefs: [
                { orderable: false, targets: (checkDeletePermission) ? [0, 6, 7] : [5, 6] }
            ],
            language: {
                zeroRecords: "{{trans('lang.no_record_found')}}",
                emptyTable: "{{trans('lang.no_record_found')}}",
                processing: ""
            },
            dom: 'lfrtipB',
            buttons: []
        });

        $('.status_selector').change(function() {
            table.ajax.reload();
        });
    });

    async function buildHTML(val) {
        var html = [];
        var djangoId = val.id;
        var firestoreId = val.firestoreId || '';
        var routeEdit = firestoreId ? '{{route("vendors.edit", ":id")}}'.replace(':id', firestoreId) : '#';
        var routeView = firestoreId ? '{{ route('stores.view', ':id') }}'.replace(':id', firestoreId) : '#';
        var routeDoc = firestoreId ? '{{ route('vendors.document', ':id') }}'.replace(':id', firestoreId) : '#';

        if (checkDeletePermission) {
            html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + djangoId + '" class="is_open" dataId="' + djangoId + '" data-firestore-id="' + firestoreId + '"><label class="col-3 control-label" for="is_open_' + djangoId + '"></label></td>');
        }

        let photo = val.photo || placeholderImage;
        html.push('<td><img class="rounded" style="width:50px;height:50px;object-fit:cover" src="' + photo + '" alt="image" onerror="this.src=\'' + placeholderImage + '\'"> <a href="' + routeView + '">' + val.storeName + '</a></td>');

        html.push('<td>' + (val.phone || '') + '</td>');
        html.push('<td>' + (val.subscription_plan_name || '') + '</td>');
        html.push('<td>' + (val.subscription_expiry_date || '{{trans("lang.unlimited")}}') + '</td>');

        let date = val.createdAt ? new Date(val.createdAt).toDateString() : '';
        let time = val.createdAt ? new Date(val.createdAt).toLocaleTimeString() : '';
        html.push('<td class="dt-time"><span class="wrap-word">' + date + '<br>' + time + '</span></td>');

        let checked = val.active ? 'checked' : '';
        html.push('<td><label class="switch"><input type="checkbox" ' + checked + ' id="active_' + djangoId + '" data-id="' + djangoId + '" name="isActive"><span class="slider round"></span></label></td>');

        var action = '<td class="action-btn"><span>';
        action += '<a href="' + routeDoc + '" title="{{ trans('lang.document') }}"><i class="fa fa-file"></i></a>';
        action += '<a href="' + routeEdit + '" title="{{ trans('lang.edit') }}"><i class="mdi mdi-lead-pencil"></i></a>';
        if (checkDeletePermission) {
            action += '<a id="' + djangoId + '" data-firestore-id="' + firestoreId + '" class="delete-btn" name="user-delete" href="javascript:void(0)" title="{{ trans('lang.delete') }}"><i class="mdi mdi-delete"></i></a>';
        }
        action += '</span></td>';
        html.push(action);

        return html;
    }

    $(document).on("click", "input[name='isActive']", async function (e) {
        var ischeck = $(this).is(':checked');
        var djangoId = $(this).data('id');
        const result = await syncToDjango(`vendors/${djangoId}/`, 'PATCH', { 'is_active': ischeck });
        if (!result || !result.status) {
            $(this).prop('checked', !ischeck);
            alert('Error updating status');
        }
    });

    $(document).on("click", "a[name='user-delete']", async function (e) {
        var djangoId = this.id;
        var firestoreId = $(this).data('firestore-id');
        if (confirm("{{trans('lang.delete_alert')}}")) {
            const result = await syncToDjango(`vendors/${djangoId}/`, 'DELETE');
            if (result && (result.status || result.status === undefined)) {
                if (firestoreId) {
                    await database.collection('vendors').doc(firestoreId).delete().catch(e => {});
                }
                window.location.reload();
            } else {
                alert('Error deleting vendor');
            }
        }
    });

</script>

@endsection
