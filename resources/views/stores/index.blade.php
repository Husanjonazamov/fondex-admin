@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ trans('lang.store_plural') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('lang.vendor_table') }}</li>
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
                                <span class="icon mr-3"><img src="{{ asset('images/store_list.png') }}"></span>
                                <h3 class="mb-0">{{ trans('lang.store_plural') }}</h3>
                                <span class="counter ml-3 total_count"></span>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="select-box pl-3">
                                    <select class="form-control cuisine_selector filteredRecords">
                                        <option value="" disabled selected>{{ trans('lang.select_categoty') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--1">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">
                                                        {{ trans('lang.dashboard_total_stores') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img
                                                        src="{{ asset('images/restaurant_icon.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--5">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_active_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">{{ trans('lang.active_restaurants') }}
                                                    </p>
                                                </div>
                                                <span class="box-icon ab"><img
                                                        src="{{ asset('images/active_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--8">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_inactive_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">
                                                        {{ trans('lang.inactive_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img
                                                        src="{{ asset('images/inactive_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--6">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 new_joined_rest">00</h4>
                                                    <p class="mb-0 small text-dark-2">
                                                        {{ trans('lang.new_joined_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img
                                                        src="{{ asset('images/new_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
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
                                    <h3 class="text-dark-2 mb-2 h4">{{ trans('lang.vendor_table') }}</h3>
                                    <p class="mb-0 text-dark-2">{{ trans('lang.store_table_text') }}</p>
                                </div>
                                <div class="card-header-right d-flex align-items-center">
                                    <div class="card-header-btn mr-3">
                                        <a class="btn-primary btn rounded-full" href="{!! route('stores.create') !!}"><i
                                                class="mdi mdi-plus mr-2"></i>{{ trans('lang.create_vendor') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive m-t-10">
                                    <table id="storeTable"
                                        class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (in_array('stores.delete', json_decode(@session('user_permissions'), true))) { ?>
                                                <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                        class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                            class="do_not_delete" href="javascript:void(0)"><i
                                                                class="mdi mdi-delete"></i>
                                                            {{ trans('lang.all') }}</a></label></th>
                                                <?php } ?>
                                                <th>{{ trans('lang.actions') }}</th>
                                                <th>{{ trans('lang.store_info') }}</th>
                                                <th>{{ trans('lang.vendor_phone') }}</th>
                                                <th>{{ trans('lang.date') }}</th>
                                                <th>{{ trans('lang.item') }}</th>
                                                <th>{{ trans('lang.order_plural') }}</th>
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
    <div class="modal fade" id="create_vendor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered notification-main" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{trans('lang.copy_vendor')}}
                        <span id="vendor_title_lable"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="data-table_processing2" class="dataTables_processing panel panel-default"
                        style="display: none;">{{trans('lang.processing')}}
                    </div>
                    <div class="error_top"></div>
                    <!-- Form -->
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <label class="form-label">{{trans('lang.first_name')}}</label>
                            <div class="input-group">
                                <input placeholder="Name" type="text" id="user_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="form-label">{{trans('lang.last_name')}}</label>
                            <div class="input-group">
                                <input placeholder="Name" type="text" id="user_last_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="form-label">{{trans('lang.vendor_title')}}</label>
                            <div class="input-group">
                                <input placeholder="Vendor Title" type="text" id="vendor_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 form-group"><label class="form-label">{{trans('lang.email')}}</label><input
                                placeholder="Email" value="" id="user_email" type="text" class="form-control"></div>
                        <div class="col-md-12 form-group"><label class="form-label">{{trans('lang.password')}}</label><input
                                placeholder="Password" id="user_password" type="password" class="form-control">
                        </div>
                    </div>
                    <!-- Form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="create_vendor_submit">{{trans('lang.create')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        var active_id = getCookie('section_id') || '';
        var user_permissions = '<?php echo @session('user_permissions'); ?>';
        user_permissions = JSON.parse(user_permissions || '[]');
        var checkDeletePermission = false;
        var checkCopyPermission = false;

        if ($.inArray('stores.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }
        if ($.inArray('stores.copy', user_permissions) >= 0) {
            checkCopyPermission = true;
        }

        var placeholderImage = '';
        database.collection('settings').doc('placeHolderImage').get().then(function (snapshotsimage) {
            if (snapshotsimage.exists) {
                placeholderImage = snapshotsimage.data().image;
            }
        });

        // Initialize categories dropdown
        (async function() {
            let catUrl = `categories/?page=1&page_size=300`;
            if (active_id) catUrl += `&section=${active_id}`;
            const catResponse = await syncToDjango(catUrl, 'GET');
            const catData = (catResponse && catResponse.status && catResponse.data)
                ? catResponse.data
                : (catResponse && catResponse.results !== undefined ? catResponse : null);
            if (catData && catData.results) {
                $('.cuisine_selector').html('<option value="" selected>{{ trans("lang.select_categoty") }}</option>');
                catData.results.forEach(function(cat) {
                    $('.cuisine_selector').append($("<option></option>").attr("value", cat.id).text(cat.title || cat.name));
                });
            }
        })();

        var fieldConfig = {
            columns: [
                { key: 'title', header: "{{ trans('lang.store_info') }}" },
                { key: 'exportPhone', header: "{{ trans('lang.phone') }}" },
                { key: 'createdAt', header: "{{ trans('lang.date') }}" },
                { key: 'items', header: "{{ trans('lang.item') }}" },
                { key: 'orders', header: "{{ trans('lang.order_plural') }}" },
            ],
            fileName: "{{ trans('lang.vendor_table') }}",
        };

        $(document).ready(function () {
            $('.cuisine_selector').select2({
                placeholder: "{{ trans('lang.select_categoty') }}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });

            $('.cuisine_selector').change(function () {
                $('#storeTable').DataTable().ajax.reload();
            });

            $('select').on("select2:unselecting", function (e) {
                var self = $(this);
                setTimeout(function () {
                    self.select2('close');
                }, 0);
            });
            jQuery("#data-table_processing").show();
            const table = $('#storeTable').DataTable({
                pageLength: 10, // Number of rows per page
                processing: false, // Show processing indicator
                serverSide: true, // Enable server-side processing
                responsive: true,
                ajax: async function (data, callback, settings) {
                    try {
                        const start = data.start;
                        const length = data.length;
                        const searchValue = data.search.value.toLowerCase();

                        let refData = active_id
                            ? database.collection('vendors').where('section_id', '==', active_id)
                            : database.collection('vendors');

                        await refData.get().then(async function(querySnapshot) {
                            if (querySnapshot.empty) {
                                $('.total_count').text(0);
                                jQuery('#data-table_processing').hide();
                                callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                                return;
                            }

                            let filteredRecords = [];
                            querySnapshot.docs.forEach((doc) => {
                                let childData = doc.data();
                                childData.id = doc.id;
                                childData.title = childData.title || '';
                                childData.phonenumber = childData.phonenumber || childData.phone_number || '';
                                childData.photo = childData.photo || childData.photoURL || '';
                                childData.items = childData.products_count || 0;
                                childData.orders = childData.orders_count || 0;
                                childData.author = childData.author || doc.id;
                                childData.firestoreId = doc.id;

                                if (searchValue) {
                                    if (
                                        (childData.title && childData.title.toLowerCase().includes(searchValue)) ||
                                        (childData.phonenumber && childData.phonenumber.toString().toLowerCase().includes(searchValue))
                                    ) {
                                        filteredRecords.push(childData);
                                    }
                                } else {
                                    filteredRecords.push(childData);
                                }
                            });

                            filteredRecords.sort((a, b) => {
                                const aTime = a.createdAt ? a.createdAt.toDate().getTime() : 0;
                                const bTime = b.createdAt ? b.createdAt.toDate().getTime() : 0;
                                return bTime - aTime;
                            });

                            const totalRecords = filteredRecords.length;
                            const activeCount = filteredRecords.filter(v => v.isActive === true || v.active === true).length;
                            $('.total_count').text(totalRecords);
                            $('.rest_count').text(totalRecords);
                            $('.rest_active_count').text(activeCount);
                            $('.rest_inactive_count').text(totalRecords - activeCount);

                            const paginatedRecords = filteredRecords.slice(start, start + length);
                            let records = [];
                            for (const childData of paginatedRecords) {
                                var htmlRows = await buildHTML(childData);
                                records.push(htmlRows);
                            }

                            jQuery('#data-table_processing').hide();
                            callback({
                                draw: data.draw,
                                recordsTotal: totalRecords,
                                recordsFiltered: totalRecords,
                                data: records
                            });
                        }).catch(function(error) {
                            console.error('Firestore error:', error);
                            jQuery('#data-table_processing').hide();
                            callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                        });
                    } catch (e) {
                        console.error('AJAX error:', e);
                        jQuery('#data-table_processing').hide();
                        callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                    }
                },
                order: (checkDeletePermission) ? [
                    [4, 'desc']
                ] : [
                    [3, 'desc']
                ],
                columnDefs: [
                    {
                        targets: (checkDeletePermission) ? 4 : 3,
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission) ? [0, 1] : [0]
                    },
                ],
                "language": {
                    "zeroRecords": "{{ trans('lang.no_record_found') }}",
                    "emptyTable": "{{ trans('lang.no_record_found') }}",
                    "processing": "" // Remove default loader
                },
                dom: 'lfrtipB',
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="mdi mdi-cloud-download"></i> {{ trans('lang.export_as') }}',
                        className: 'btn btn-info',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '{{ trans('lang.export_excel') }}',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'excel', fieldConfig);
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '{{ trans('lang.export_pdf') }}',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'pdf', fieldConfig);
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                text: '{{ trans('lang.export_csv') }}',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'csv', fieldConfig);
                                }
                            }
                        ]
                    }
                ],
                initComplete: function () {
                    $(".dataTables_filter").append($(".dt-buttons").detach());
                    $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete', 'new-password').val('');
                    $('.dataTables_filter label').contents().filter(function () {
                        return this.nodeType === 3;
                    }).remove();
                }
            });
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
            var route1 = '{{ route('stores.edit', ':id') }}';
            route1 = route1.replace(':id', id);
            var route_view = '{{ route('stores.view', ':id') }}';
            route_view = route_view.replace(':id', id);
            if (checkDeletePermission) {
                html.push('<span class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '" author="' + val.author + '"><label class="col-3 control-label" for="is_open_' + id + '"></label></span>');
            }
            var actionHtml = '';
            actionHtml = actionHtml + '<span class="action-btn">';
            var payoutRequests = '{{ route('users.walletstransaction', ':id') }}';
            payoutRequests = payoutRequests.replace(':id', 'storeID=' + val.author);
            actionHtml = actionHtml + '<a href="' + payoutRequests + '" data-toggle="tooltip" data-bs-original-title="{{ trans('lang.wallet_history') }}"><i class="mdi mdi-wallet" ></i></a>';

            if (checkCopyPermission) {
                actionHtml = actionHtml + '<a href="javascript:void(0)" vendor_id="' + val.id + '" author="' + val.author + '" name="vendor-clone" data-toggle="tooltip" data-bs-original-title="{{ trans('lang.copy') }}"><i class="mdi mdi-content-copy"></i></a>';
            }
            actionHtml = actionHtml + '<a href="' + route_view + '" data-toggle="tooltip" data-bs-original-title="{{ trans('lang.view') }}"><i class="mdi mdi-eye"></i></a><a href="' + route1 + '" data-toggle="tooltip" data-bs-original-title="{{ trans('lang.edit') }}"><i class="mdi mdi-lead-pencil"></i></a>';
            if (checkDeletePermission) {
                actionHtml = actionHtml + '<a id="' + id + '" author="' + val.author + '" name="delete-btn" class="do_not_delete" href="javascript:void(0)" data-toggle="tooltip" data-bs-original-title="{{ trans('lang.delete') }}"><i class="mdi mdi-delete"></i></a>';
            }
            actionHtml = actionHtml + '</span>';
            html.push(actionHtml);
            if (val.photo != '') {
                if (val.photo) {
                    photo = val.photo;
                } else {
                    photo = placeholderImage;
                }
                html.push('<img alt="" width="100%" style="width:70px;height:70px;" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">' + '<a href="' + route_view + '" class="redirecttopage left_space">' + val.title + '</a>');
            } else {
                html.push('<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">' + '<a href="' + route_view + '" class="redirecttopage left_space">' + val.title + '</a>');
            }

            if (val.phonenumber) {
                if (val.phonenumber.includes('+')) {
                    html.push('+' + EditPhoneNumber(val.phonenumber.slice(1)));
                } else {
                    html.push(EditPhoneNumber(val.phonenumber));
                }
            } else {
                html.push('');
            }
            if (val.createdAt || val.created_at) {
                const rawDate = val.createdAt || val.created_at;
                const dateObj = rawDate && rawDate.toDate ? rawDate.toDate() : new Date(rawDate);
                let date = dateObj.toDateString();
                let time = dateObj.toLocaleTimeString();
                html.push('<span class="dt-time">' + date + '<br> ' + time + '</span>');
            } else {
                html.push('');
            }

            var vendorId = val.firestoreId || val.id;
            var url = '{{ route('vendors.items', ':id') }}';
            url1 = url.replace(":id", vendorId);
            html.push((val.items > 0 ? '<a href="' + url1 + '">' + val.items + '</a>' : val.items));

            var url = '{{ route('vendors.orders', ':id') }}';
            url2 = url.replace(":id", vendorId);
            html.push((val.orders > 0 ? '<a href="' + url2 + '">' + val.orders + '</a>' : val.orders));

            var active = val.isActive;
            return html;
        }
        async function vendorStatus(id) {
            let status = true;
            await database.collection('users').doc(id).get().then((snapshots) => {
                let data = snapshots.data();
                if (data) {
                    status = data.active;
                }
            });
            return status;
        }

        async function getTotalProduct(id) {
            var totalProduct = '';
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (productSnapshots) {
                totalProduct = productSnapshots.docs.length;
            });
            return totalProduct;
        }
        async function getTotalOrders(id) {
            var order_total = '';
            await database.collection('vendor_orders').where('vendorID', '==', id).get().then(async function (productSnapshots) {
                order_total = productSnapshots.docs.length;
            });
            return order_total;
        }
        $("#is_active").click(function () {
            $("#storeTable .is_open").prop('checked', $(this).prop('checked'));
        });
        $("#deleteAll").click(function () {
            if ($('#storeTable .is_open:checked').length) {
                if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                    jQuery("#data-table_processing").show();
                    var toDelete = [];
                    $('#storeTable .is_open:checked').each(function () {
                        toDelete.push($(this).attr('dataId'));
                    });
                    (async function() {
                        for (var storeId of toDelete) {
                            await database.collection('vendors').doc(storeId).delete().catch(e => {});
                        }
                        window.location.reload();
                    })();
                }
            } else {
                alert("{{ trans('lang.select_delete_alert') }}");
            }
        });
        async function deleteStoreData(storeId) {
            await database.collection('users').where('vendorID', '==', storeId).where('role', '==', 'vendor').get().then(async function (userssanpshots) {
                if (userssanpshots.docs.length > 0) {
                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID'); ?>';
                    var item_data = userssanpshots.docs[0].data();
                    var dataObject = {
                        "data": {
                            "uid": item_data.id
                        }
                    };
                    //delete vendor from mysql
                    await database.collection('settings').doc("Version").get().then(function (snapshot) {
                        var settingData = snapshot.data();
                        if (settingData && settingData.storeUrl) {
                            var siteurl = settingData.storeUrl + "/api/delete-user";
                            var dataObject = {
                                "uuid": item_data.id
                            };
                            jQuery.ajax({
                                url: siteurl,
                                method: 'POST',
                                contentType: "application/json; charset=utf-8",
                                data: JSON.stringify(dataObject),
                                success: function (data) {
                                    console.log('Delete user from sql success:', data);
                                },
                                error: function (error) {
                                    console.log('Delete user from sql error:', error.responseJSON.message);
                                }
                            });
                        }
                    });
                    jQuery.ajax({
                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                        method: 'POST',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(dataObject),
                        success: async function (data) {
                            console.log('Delete user success:', data.result);
                            await deleteDocumentWithImage('users', item_data.id, 'profilePictureURL');
                        },
                        error: function (xhr, status, error) {
                            var responseText = JSON.parse(xhr.responseText);
                            console.log('Delete user error:', responseText.error);
                        }
                    });
                }
            });
            var productSnapshot = await database.collection('vendor_products').where('vendorID', '==', storeId).get();
            if (!productSnapshot.empty) {
                for (const doc of productSnapshot.docs) {
                    await deleteDocumentWithImage('vendor_products', doc.id, 'photo', 'photos');
                }
            }
            var orderSnapshot = await database.collection('vendor_orders').where('vendorID', '==', storeId).get();
            if (!orderSnapshot.empty) {
                for (const doc of orderSnapshot.docs) {
                    await deleteDocumentWithImage('vendor_orders', doc.id);
                }
            }
            var reviewSnapshot = await database.collection('items_review').where('VendorId', '==', storeId).get();
            if (!reviewSnapshot.empty) {
                for (const doc of reviewSnapshot.docs) {
                    await deleteDocumentWithImage('items_review', doc.id, '', 'photos');
                }
            }
            var couponSnapshot = await database.collection('coupons').where('vendorID', '==', storeId).get();
            if (!couponSnapshot.empty) {
                for (const doc of couponSnapshot.docs) {
                    await deleteDocumentWithImage('coupons', doc.id, 'image');
                }
            }
            var payoutSnapshot = await database.collection('payouts').where('vendorID', '==', storeId).get();
            if (!payoutSnapshot.empty) {
                for (const doc of payoutSnapshot.docs) {
                    await database.collection('payouts').doc(doc.id).delete()
                }
            }
            const storySnapshot = await database.collection('story').where('vendorID', '==', storeId).get();
            if (!storySnapshot.empty) {
                for (const doc of storySnapshot.docs) {
                    await deleteDocumentWithImage('story', doc.id, 'videoThumbnail', 'videoUrl');
                }
            }
            const snapshots = await database.collection('advertisements').where('vendorId', '==', storeId).get();
            if (!snapshots.empty) {
                for (const doc of snapshots.docs) {
                    await deleteDocumentWithImage('advertisements', doc.id);
                }
            }
            const driverSnapshots = await database.collection('users').where('role', '==', 'driver').where('vendorID', '==', storeId).get();
            if (!driverSnapshots.empty) {
                for (const doc of driverSnapshots.docs) {
                    await deleteDocumentWithImage('users', doc.id, 'profilePictureURL');
                }
            }
        }
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        async function userPhone(author) {
            var userPhones = '';
            await database.collection('users').where("id", "==", author).get().then(async function (snapshotss) {
                if (snapshotss.docs[0]) {
                    var user = snapshotss.docs[0].data();
                    userPhones = user.phoneNumber;
                    if (user.isActive) {
                        jQuery(".active_vendor_" + author + " span").addClass('badge-danger');
                        jQuery(".active_vendor_" + author + " span").text('No');
                    } else {
                        jQuery(".active_vendor_" + author + " span").addClass('badge-success');
                        jQuery(".active_vendor_" + author + " span").text('Yes');
                    }
                } else {
                    jQuery(".phone_" + author).html('');
                    jQuery(".active_vendor_" + author + " span").addClass('badge-success');
                    jQuery(".active_vendor_" + author + " span").text('Yes');
                }
            });
            return userPhones;
        }
        function clickpage(value) {
            setCookie('pagesizes', value, 30);
            location.reload();
        }
        $(document).on("click", "a[name='delete-btn']", async function (e) {
            var id = this.id;
            if (confirm("{{ trans('lang.delete_alert') }}")) {
                jQuery("#data-table_processing").show();
                await database.collection('vendors').doc(id).delete().catch(e => {});
                await deleteStoreData(id);
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }
        });

        $(document).on("click", "a[name='vendor-clone']", async function (e) {
            jQuery("#data-table_processing").show();
            var id = $(this).attr('vendor_id');
            var author = $(this).attr('author');
            await database.collection('users').doc(author).get().then(async function (snapshotsusers) {
                userData = snapshotsusers.data();
            });
            await database.collection('vendors').doc(id).get().then(async function (snapshotsvendors) {
                vendorData = snapshotsvendors.data();
            });
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (snapshotsproducts) {
                vendorProducts = [];
                snapshotsproducts.docs.forEach(async (product) => {
                    vendorProducts.push(product.data());
                });
            });
            if (userData && vendorData) {
                jQuery("#create_vendor").modal('show');
                jQuery("#vendor_title_lable").text(vendorData.title);
                jQuery("#data-table_processing").hide();
            }
        });
        $(document).on("click", "#create_vendor_submit", async function (e) {
            var vendor_id = database.collection("tmp").doc().id;
            if (userData && vendorData) {
                var vendor_title = jQuery("#vendor_title").val();
                var userFirstName = jQuery("#user_name").val();
                var userLastName = jQuery("#user_last_name").val();
                var email = jQuery("#user_email").val();
                var password = jQuery("#user_password").val();
                if (userFirstName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (userLastName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_last_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (vendor_title == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.vendor_title_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (email == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_email_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (password == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.enter_owners_password_error') }}</p>");
                    window.scrollTo(0, 0);
                } else {
                    jQuery("#data-table_processing").show();
                    firebase.auth().createUserWithEmailAndPassword(email, password).then(async function (firebaseUser) {
                        var user_id = firebaseUser.user.uid;
                        userData.email = email;
                        userData.firstName = userFirstName;
                        userData.lastName = userLastName;
                        userData.id = user_id;
                        userData.vendorID = vendor_id;
                        userData.createdAt = createdAt;
                        userData.wallet_amount = 0;
                        vendorData.author = user_id;
                        vendorData.authorName = userFirstName + ' ' + userLastName;
                        vendorData.title = vendor_title;
                        vendorData.id = vendor_id;
                        coordinates = new firebase.firestore.GeoPoint(vendorData.latitude, vendorData.longitude);
                        vendorData.coordinates = coordinates;
                        vendorData.createdAt = createdAt;
                        await database.collection('users').doc(user_id).set(userData).then(async function (result) {
                            await geoFirestore.collection('vendors').doc(vendor_id).set(vendorData).then(async function (result) {
                                if (vendorProducts.length > 0) {
                                    var count = 0;
                                    await vendorProducts.forEach(async (product) => {
                                        var product_id = await database.collection("tmp").doc().id;
                                        product.id = product_id;
                                        product.vendorID = vendor_id;
                                        await database.collection('vendor_products').doc(product_id).set(product).then(function (result) {
                                            count++;
                                            if (count == vendorProducts.length) {
                                                jQuery("#data-table_processing").hide();
                                                jQuery("#create_vendor").modal('hide');
                                                Swal.fire({
                                                    title: "Vendor Created!",
                                                    text: "Vendor data copied successfully.",
                                                    icon: 'success',
                                                    confirmButtonText: "OK"
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        location.reload();
                                                    }
                                                });
                                            }
                                        });
                                    });
                                } else {
                                    jQuery("#data-table_processing").hide();
                                    jQuery("#create_vendor").modal('hide');
                                    Swal.fire({
                                        title: "Vendor Created!",
                                        text: "Vendor data copied successfully.",
                                        icon: 'success',
                                        confirmButtonText: "OK"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                }
                            });
                        })
                    }).catch(function (error) {
                        $(".error_top").show();
                        jQuery("#data-table_processing").hide();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + error + "</p>");
                    });
                }
            }
        });
    </script>

    <style>
        #data-table_processing.page-overlay {
            z-index: 99999 !important;
        }
    </style>

@endsection