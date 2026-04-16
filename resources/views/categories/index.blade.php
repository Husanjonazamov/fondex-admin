@extends('layouts.app')
@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.category_plural')}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.category_table')}}</li>
                </ol>
            </div>
            <div>
            </div>
        </div>
        <div class="container-fluid">

            <div class="admin-top-section">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex top-title-section pb-4 justify-content-between">
                            <div class="d-flex top-title-left align-self-center">
                                <span class="icon mr-3"><img src="{{ asset('images/category.png') }}"></span>
                                <h3 class="mb-0">{{trans('lang.category_plural')}}</h3>
                                <span class="counter ml-3 total_count"></span>
                            </div>
                            <div class="d-flex top-title-right align-self-center">

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
                                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.category_table')}}</h3>
                                    <p class="mb-0 text-dark-2">{{trans('lang.category_table_text')}}</p>
                                </div>
                                <div class="card-header-right d-flex align-items-center">
                                    <div class="card-header-btn mr-3">
                                        <a class="btn-primary btn rounded-full" href="{!! route('categories.create') !!}"><i
                                                class="mdi mdi-plus mr-2"></i>{{trans('lang.category_create')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive m-t-10">
                                    <table id="categoryTable"
                                        class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (in_array('categories.delete', json_decode(@session('user_permissions'), true))) { ?>
                                                <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                        class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                            class="do_not_delete" href="javascript:void(0)"><i
                                                                class="mdi mdi-delete"></i>
                                                            {{trans('lang.all')}}</a></label></th>
                                                <?php } ?>
                                                <th>{{trans('lang.category_info')}}</th>

                                                <th>{{trans('lang.item')}}</th>
                                                <th> {{trans('lang.item_publish')}}</th>
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
        var user_permissions = '<?php echo @session('user_permissions') ?>';
        user_permissions = JSON.parse(user_permissions);

        var checkDeletePermission = false;
        if ($.inArray('categories.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

        var database = firebase.firestore();
        var offest = 1;
        var pagesize = 10;
        var end = null;
        var endarray = [];
        var start = null;
        var user_number = [];
        var ref = database.collection('vendor_categories');

        if (section_id) {
            ref = ref.where('section_id', '==', section_id);
        }

        var append_list = '';
        var placeholderImage = '';
        var ref_sections = database.collection('sections');
        let selected_gender = "";

        $(document).ready(function () {
            var inx = parseInt(offest) * parseInt(pagesize);
            jQuery("#data-table_processing").show();

            var placeholder = database.collection('settings').doc('placeHolderImage');

            placeholder.get().then(async function (snapshotsimage) {
                var placeholderImageData = snapshotsimage.data();
                placeholderImage = placeholderImageData.image;

            })

            $('.sections').select2({
                placeholder: "{{trans('lang.select')}} {{trans('lang.section_plural')}}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });

            $('select').on("select2:unselecting", function (e) {
                var self = $(this);
                setTimeout(function () {
                    self.select2('close');
                }, 0);
            });


            //start

            const table = $('#categoryTable').DataTable({
                pageLength: 10,
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: async function (data, callback, settings) {
                    const start = data.start;
                    const length = data.length;
                    const searchValue = data.search.value.toLowerCase();
                    const orderColumnIndex = data.order[0].column;
                    const orderDirection = data.order[0].dir;
                    const page = (start / length) + 1;

                    if (searchValue.length >= 3 || searchValue.length === 0) {
                        $('#data-table_processing').show();
                    }

                    // Fetch from REST API
                    let url = `categories/?page=${page}&page_size=${length}`;
                    if (searchValue) {
                        url += `&search=${searchValue}`;
                    }
                    if (section_id) {
                        url += `&section=${section_id}`;
                    }

                    const response = await syncToDjango(url, 'GET');

                    if (!response || !response.status || !response.data) {
                        $('.total_count').text(0);
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: []
                        });
                        return;
                    }

                    const totalRecords = response.data.total_items || response.data.count || 0;
                    $('.total_count').text(totalRecords);

                    let records = [];
                    await Promise.all(response.data.results.map(async (childData) => {
                        // Map API fields to Firestore-like fields for buildHTML compatibility
                        childData.publish = childData.is_publish;
                        childData.totalProducts = childData.product_count || 0; // Assuming backend might provide this or we use 0
                        
                        var getData = await buildHTML(childData);
                        records.push(getData);
                    }));

                    $('#data-table_processing').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords,
                        recordsFiltered: totalRecords,
                        data: records
                    });
                },

                order: (checkDeletePermission) ? [1, 'asc'] : [0, 'asc'],

                columnDefs: [
                    {
                        orderable: false,
                        targets: (checkDeletePermission == true) ? [0, 3, 4] : [2, 3]
                    },
                ],

                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}",
                    "processing": "" // Remove default loader
                },

            });

            table.columns.adjust().draw();

            function debounce(func, wait) {

                let timeout;

                const context = this;

                return function (...args) {
                    clearTimeout(timeout);

                    timeout = setTimeout(() => func.apply(context, args), wait);

                };
            }

            $('#search-input').on('input', debounce(function () {

                const searchValue = $(this).val();

                if (searchValue.length >= 3) {

                    $('#data-table_processing').show();

                    table.search(searchValue).draw();

                } else if (searchValue.length === 0) {

                    $('#data-table_processing').show();

                    table.search('').draw();

                }

            }, 300));





        });



        async function buildHTML(val) {

            var html = [];
            newdate = '';
            var id = val.id;

            var route1 = '{{route("categories.edit", ":id")}}';

            route1 = route1.replace(':id', id);

            if (checkDeletePermission) {

                html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' + 'for="is_open_' + id + '" ></label></td>  ');

            }

            var itemsUrl = '{{url("items?categoryID=id")}}';
            itemsUrl = itemsUrl.replace("id", id);

            if (val.photo == '') {
                html.push('<td><a href="' + itemsUrl + '"><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></a> <a href="' + itemsUrl + '" class="left_space">' + val.title + '</a>');

            } else {

                html.push('<td><a href="' + itemsUrl + '"><img class="rounded" style="width:50px" src="' + val.photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></a> <a href="' + itemsUrl + '" class="left_space">' + val.title + '</a>');

            }



            var categoryId = val.id;

            var url = '{{url("items?categoryID=id")}}';

            url = url.replace("id", categoryId);

            html.push('<td ><a href="' + url + '">' + val.totalProducts + '</a></td>');

            if (val.publish) {

                html.push('<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isSwitch"><span class="slider round"></span></label></td>');

            } else {

                html.push('<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isSwitch"><span class="slider round"></span></label></td>');

            }

            var action = '';

            action = action + '<span class="action-btn"><a href="' + route1 + '" data-toggle="tooltip" title="{{trans("lang.edit")}}"><i class="mdi mdi-lead-pencil"></i></a>';

            if (checkDeletePermission) {

                action = action + '<a id="' + val.id + '" name="category-delete" class="delete-btn" href="javascript:void(0)" data-toggle="tooltip" title="{{trans("lang.delete")}}"><i class="mdi mdi-delete"></i></a>';

            }

            action = action + '</span>';

            html.push(action)

            return html;

        }



        /* toggal publish action code start*/

        $(document).on("click", "input[name='isSwitch']", async function (e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            
            jQuery("#data-table_processing").show();
            const result = await syncToDjango(`categories/${id}/`, 'PATCH', { 'is_publish': ischeck });
            jQuery("#data-table_processing").hide();
            
            if (!result || !result.status) {
                $(this).prop('checked', !ischeck);
                alert(result ? result.message : 'Error updating status');
            }
        });

        $(document).on("click", "a[name='category-delete']", async function (e) {
            var id = this.id;
            if (confirm("{{trans('lang.delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                const result = await syncToDjango(`categories/${id}/`, 'DELETE');
                jQuery("#data-table_processing").hide();
                if (result && result.status) {
                    window.location.reload();
                } else {
                    alert(result ? result.message : 'Error deleting category');
                }
            }
        });

        $("#deleteAll").click(function () {
            if ($('#categoryTable .is_open:checked').length) {
                if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                    jQuery("#data-table_processing").show();
                    var promises = [];
                    $('#categoryTable .is_open:checked').each(function () {
                        var dataId = $(this).attr('dataId');
                        promises.push(syncToDjango(`categories/${dataId}/`, 'DELETE'));
                    });
                    
                    Promise.all(promises).then(() => {
                        window.location.reload();
                    }).catch(err => {
                        jQuery("#data-table_processing").hide();
                        alert('Some categories could not be deleted');
                    });
                }
            } else {
                alert("{{trans('lang.select_delete_alert')}}");
            }
        });

    </script>



@endsection