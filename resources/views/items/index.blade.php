@extends('layouts.app')

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <div class="d-flex top-title-section justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/item_image.png') }}"></span>
                        <h3 class="mb-0 page-title">{{trans('lang.item_plural')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.item_table')}}</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">

            <div class="admin-top-section">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex top-title-section pb-4 justify-content-between">
                            <div class="d-flex top-title-left align-self-center">
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="select-box pl-3">
                                    <select class="form-control section_selector">
                                        <option value="" selected>{{trans("lang.section_plural")}} ({{trans("lang.ombor")}})</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3 item_type_selector_div" style="display:none;">
                                    <select class="form-control item_type_selector">
                                        <option value="" selected>{{trans("lang.type")}}</option>
                                        <option value="veg">{{trans("lang.veg")}}</option>
                                        <option value="non-veg">{{trans("lang.non_veg")}}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control category_selector">
                                        <option value="" selected>{{trans("lang.category_plural")}}</option>
                                    </select>
                                </div>
                                <div class="pl-3">
                                    <button class="btn btn-secondary btn-sm" id="clear_filters">{{trans('lang.clear')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="table-list">
                <div class="row">
                    <div class="col-12">
                        <?php if ($id != '') { ?>
                        <div class="menu-tab">
                            <ul>
                                <li>
                                    <a href="{{route('stores.view', $id)}}"><i
                                            class="ri-list-indefinite"></i>{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li class="active">
                                    <a href="{{route('vendors.items', $id)}}"><i
                                            class="ri-shopping-basket-fill"></i>{{trans('lang.tab_items')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.orders', $id)}}"><i
                                            class="ri-shopping-bag-line"></i>{{trans('lang.tab_orders')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.reviews', $id)}}"><i
                                            class="ri-shield-star-fill"></i>{{trans('lang.tab_reviews')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.coupons', $id)}}"><i
                                            class="ri-discount-percent-fill"></i>{{trans('lang.tab_promos')}}</a>
                                <li>
                                    <a href="{{route('vendors.payout', $id)}}"><i
                                            class="ri-bank-card-line"></i>{{trans('lang.tab_payouts')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('payoutRequests.vendor.view', $id)}}"><i
                                            class="ri-refund-line"></i>{{trans('lang.tab_payout_request')}}</a>
                                </li>
                                <li>
                                    <a class="wallet_transaction"><i
                                            class="ri-wallet-line"></i>{{trans('lang.wallet_transaction')}}</a>
                                </li>

                                <li class="dine_in_future" style="display:none;">
                                    <a href="{{route('vendors.booktable', $id)}}"><i
                                            class="ri-restaurant-line"></i>{{trans('lang.dine_in_booking_history')}}</a>
                                </li>
                                <?php
        $subscription = route("subscription.subscriptionPlanHistory", ":id");
        $subscription = str_replace(":id", "storeID=" . $id, $subscription);
                            ?>
                                <li>
                                    <a href="{{ $subscription }}"><i
                                            class="ri-chat-history-fill"></i>{{trans('lang.subscription_history')}}</a>
                                </li>
                                <li>
                                    <a href="{{ route('restaurants.advertisements', $id) }}"><i
                                            class="mdi mdi-newspaper"></i>{{ trans('lang.advertisement_plural') }}</a>
                                </li>
                                @php
                                    $sectionType = $_COOKIE['service_type'] ?? ''; 
                                @endphp
                                <?php    if ($sectionType == 'ecommerce-service') { ?>

                                <?php    } else { ?>
                                <li class="">
                                    <a href="{{ route('restaurants.deliveryman', $id) }}"><i
                                            class="ri-riding-fill"></i>{{ trans('lang.deliveryman') }}</a>
                                </li>
                                <?php    }?>
                            </ul>
                        </div>
                        <?php } ?>
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-0">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.item_table')}}</h3>
                                    <p class="mb-0 text-dark-2">{{trans('lang.item_table_text')}}</p>
                                </div>
                                <div class="card-header-right d-flex align-items-center">
                                    <div class="card-header-btn mr-3">

                                        <?php if ($id != '') { ?>

                                        <a class="btn-primary btn rounded-full"
                                            href="{!! route('items.create') !!}/{{$id}}"><i
                                                class="mdi mdi-plus mr-2"></i>{{trans('lang.item_create')}}</a>

                                        <?php } else { ?>

                                        <a class="btn-primary btn rounded-full" href="{!! route('items.create') !!}"><i
                                                class="mdi mdi-plus mr-2"></i>{{trans('lang.item_create')}}</a>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive m-t-10">
                                    <table id="itemTable"
                                        class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (in_array('items.delete', json_decode(@session('user_permissions'), true))) { ?>
                                                <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                        class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                            class="do_not_delete" href="javascript:void(0)"><i
                                                                class="mdi mdi-delete"></i>
                                                            {{trans('lang.all')}}</a></label></th>
                                                <?php } ?>
                                                <th>{{trans('lang.item_info')}}</th>
                                                <th>{{trans('lang.item_price')}}</th>

                                                <?php if ($id == '') { ?>
                                                <th>{{trans('lang.item_vendor_id')}}</th>
                                                <?php } ?>
                                                <th>{{trans('lang.category')}}</th>

                                                <th>{{trans('lang.item_publish')}}</th>
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
        if ($.inArray('items.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

        const urlParams = new URLSearchParams(location.search);
        var brandID = urlParams.get('brandID') || '';
        var categoryID = urlParams.get('categoryID') || '';

        var database = firebase.firestore();
        var currentCurrency = '';
        var currencyAtRight = false;
        var decimal_degits = 0;
        var ref_sections = database.collection('sections');
        var vendorID = "{{$id}}";

        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        refCurrency.get().then(async function (snapshots) {
            if (snapshots.docs.length > 0) {
                var currencyData = snapshots.docs[0].data();
                currentCurrency = currencyData.symbol;
                currencyAtRight = currencyData.symbolAtRight;
                if (currencyData.decimal_degits) {
                    decimal_degits = currencyData.decimal_degits;
                }
            }
        });

        var placeholderImage = '';
        var categoryNameMap = {};
        database.collection('settings').doc('placeHolderImage').get().then(async function (snapshotsimage) {
            if (snapshotsimage.exists) {
                var placeholderImageData = snapshotsimage.data();
                placeholderImage = placeholderImageData.image;
            }
        });

        (async function loadFilters() {
            // Load Sections (Storages)
            const sectionResponse = await syncToDjango('sections/?page=1&page_size=100', 'GET');
            const sectionData = (sectionResponse && sectionResponse.status && sectionResponse.data) ? sectionResponse.data : null;
            if (sectionData && sectionData.results) {
                sectionData.results.forEach(function(sec) {
                    $('.section_selector').append($("<option></option>").attr("value", sec.id).text(sec.name));
                });
            }
            if (section_id) {
                $('.section_selector').val(section_id).trigger('change');
            }

            // Load Categories
            async function refreshCategories(sId = '') {
                let catUrl = `categories/?page=1&page_size=300`;
                if (sId) catUrl += `&section=${sId}`;
                const catResponse = await syncToDjango(catUrl, 'GET');
                const catData = (catResponse && catResponse.status && catResponse.data) ? catResponse.data : (catResponse && catResponse.results ? catResponse : null);
                
                $('.category_selector').html('<option value="" selected>{{trans("lang.category_plural")}}</option>');
                if (catData && catData.results) {
                    catData.results.forEach(function(cat) {
                        var name = cat.title || cat.name || '';
                        // Map by both Django ID and Firestore ID for lookup
                        if (cat.id) categoryNameMap[cat.id] = name;
                        if (cat.firestore_id) categoryNameMap[cat.firestore_id] = name;
                        $('.category_selector').append($("<option></option>").attr("value", cat.firestore_id).attr("data-id", cat.id).text(name));
                    });
                }
                if (categoryID) {
                    if ($('.category_selector option[value="' + categoryID + '"]').length > 0) {
                        $('.category_selector').val(categoryID).trigger('change');
                    } else {
                        let matchingOption = $('.category_selector option').filter(function() {
                            return $(this).attr('data-id') == categoryID;
                        });
                        if (matchingOption.length > 0) {
                            categoryID = matchingOption.val();
                            $('.category_selector').val(categoryID).trigger('change');
                        }
                    }
                }
            }
            
            await refreshCategories(section_id);

            $('.section_selector').on('change', function() {
                let sId = $(this).val();
                refreshCategories(sId);
            });
        })();

        $(document).ready(function () {
            
            // UI Initializations
            $('.item_type_selector').select2({
                placeholder: "{{trans('lang.type')}}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('.category_selector').select2({
                placeholder: "{{trans('lang.category')}}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('.section_selector').select2({
                placeholder: "{{trans('lang.section_plural')}}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            
            $('#clear_filters').on('click', function() {
                $('.section_selector').val('').trigger('change');
                $('.category_selector').val('').trigger('change');
                $('.item_type_selector').val('').trigger('change');
                categoryID = ''; 
                table.ajax.reload();
            });

            // Firestore Section Data (Optional, don't block)
            if (section_id) {
                database.collection('sections').doc(section_id).get().then(function(sectionSnap) {
                    if (sectionSnap.exists) {
                        let sectionData = sectionSnap.data();
                        if (sectionData.dine_in_active === true) $(".dine_in_future").show();
                        if (sectionData.is_product_details === true) $(".item_type_selector_div").show();
                    }
                }).catch(e => console.error("Firestore section error:", e));
            }

            console.log("Initializing itemTable DataTable...");
            const table = $('#itemTable').DataTable({
                pageLength: 10,
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 500,
                ajax: function (data, callback, settings) {
                    (async function() {
                        try {
                            const start = data.start || 0;
                            const length = data.length || 10;
                            const searchValue = (data.search.value || '').trim();
                            const page = Math.floor(start / length) + 1;

                            let url = `products/?page=${page}&page_size=${length}`;
                            if (searchValue) url += `&search=${encodeURIComponent(searchValue)}`;
                            const selectedCategory = $('.category_selector').val() || '';
                            const selectedSection = $('.section_selector').val() || '';

                            if (vendorID) url += `&vendor=${vendorID}`;
                            if (selectedCategory) url += `&category=${selectedCategory}`;
                            else if (categoryID) url += `&category=${categoryID}`;
                            
                            // Try both section and section_id or ensure the correct one is used
                            if (selectedSection) {
                                url += `&section=${selectedSection}`;
                            } else if (section_id && !selectedCategory && !categoryID) {
                                url += `&section=${section_id}`;
                            }

                            const response = await syncToDjango(url, 'GET');

                            // Support both wrapped response and direct DRF response
                            const responseData = (response && response.results !== undefined)
                                ? response
                                : (response && response.data && response.data.results !== undefined ? response.data : null);

                            if (!responseData) {
                                console.error("No valid response data found:", response);
                                callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                                return;
                            }

                            let totalRecords = responseData.count || responseData.total_items || responseData.total || responseData.total_records || 0;
                            const results = responseData.results || [];
                            
                            // If API uses CursorPagination (no total count), we must provide a fallback for DataTables
                            if (!totalRecords && results.length > 0) {
                                if (responseData.next) {
                                    totalRecords = start + length + 1;
                                } else {
                                    totalRecords = start + results.length;
                                }
                            }
                            
                            $('.total_count').text(totalRecords);

                            let records = [];
                            if (results) {
                                for (const item of results) {
                                    // Normalize fields for buildHTML compatibility
                                    item.publish = item.hasOwnProperty('is_publish') ? item.is_publish : (item.publish === 'Yes' || item.publish === true);
                                    item.photo = item.image || item.photo || ''; 
                                    item.foodName = item.name || item.title || '';
                                    item.finalPrice = parseFloat(item.price) || 0;
                                    item.sku = item.sku || item.item_sku || item.code || '';
                                    item.vendor = item.vendor || item.vendor_id || '';
                                    item.store = item.vendor_name || item.vendor_title || ''; 
                                    
                                    const rawCat = item.category_name || item.category_title || '';
                                    const catId = item.category || item.category_id || '';
                                    item.category = rawCat || categoryNameMap[catId] || catId || 'N/A';
                                    
                                    var htmlRows = await buildHTML(item);
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
                            console.error("DataTable Ajax Error:", e);
                            callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                        }
                    })();
                },
                order: (checkDeletePermission) ? [1, 'asc'] : [0, 'asc'],
                columnDefs: [
                    { orderable: false, targets: (vendorID == '') ? ((checkDeletePermission) ? [0, 5, 6] : [4, 5]) : ((checkDeletePermission) ? [0, 4, 5] : [3, 4]) },
                    { type: 'formatted-num', targets: (checkDeletePermission) ? [2] : [1] }
                ],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}",
                    "processing": ""
                },
                dom: 'lfrtipB',
                buttons: [], // Simplified for now
                initComplete: function () {
                    $(".dataTables_filter").append($(".dt-buttons").detach());
                    $('.dataTables_filter input')
                        .attr('placeholder', 'Search...')
                        .attr('autocomplete', 'off');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                }
            });

            $('select').change(function () {
                table.ajax.reload();
            });
        });

        async function buildHTML(val) {
            var html = [];
            if (checkDeletePermission) {
                html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + val.id + '" class="is_open" dataId="' + val.id + '"><label class="col-3 control-label" for="is_open_' + val.id + '"></label></td>');
            }

            var route1 = '{{route("items.edit", ":id")}}';
            route1 = route1.replace(':id', val.id);

            if (val.photo == '') {
                html.push('<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"> <a href="' + route1 + '">' + val.foodName + '</a></td>');
            } else {
                html.push('<td><img class="rounded" style="width:50px" src="' + val.photo + '" alt="image" onerror="this.src=\''+placeholderImage+'\'"> <a href="' + route1 + '">' + val.foodName + '</a></td>');
            }

            if (currencyAtRight) {
                html.push('<td>' + val.finalPrice.toFixed(decimal_degits) + '' + currentCurrency + '</td>');
            } else {
                html.push('<td>' + currentCurrency + '' + val.finalPrice.toFixed(decimal_degits) + '</td>');
            }

            if (vendorID == '') {
                var vendor_route = '{{route("stores.view", ":id")}}';
                vendor_route = vendor_route.replace(':id', val.vendor);
                html.push('<td><a href="' + vendor_route + '">' + val.store + '</a></td>');
            }

            html.push('<td>' + val.category + '</td>');

            if (val.publish) {
                html.push('<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>');
            } else {
                html.push('<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>');
            }

            html.push('<span class="action-btn"><a href="' + route1 + '"><i class="mdi mdi-mode-edit"></i></a><a id="' + val.id + '" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a></span>');

            return html;
        }

        $(document).on("click", "input[name='publish']", async function (e) {
            var id = $(this).attr('id');
            var is_publish = $(this).is(':checked');
            await syncToDjango(`products/${id}/`, 'PATCH', { is_publish: is_publish });
        });

        $(document).on("click", ".do_not_delete", async function (e) {
            var id = $(this).attr('id');
            // "Barchasi" (select all) header link is handled separately by #deleteAll below.
            if (id === 'deleteAll') {
                return;
            }
            if (confirm("{{trans('lang.delete_alert')}}")) {
                const res = await syncToDjango(`products/${id}/`, 'DELETE');
                if (res.status) {
                    window.location.reload();
                } else {
                    alert("Error deleting item: " + res.message);
                }
            }
        });

        // Select-all checkbox in the table header toggles every row checkbox.
        $(document).on("change", "#is_active", function () {
            $("#itemTable .is_open").prop('checked', $(this).prop('checked'));
        });

        // Bulk delete: remove every checked product, then reload.
        $(document).on("click", "#deleteAll", async function (e) {
            var $checked = $('#itemTable .is_open:checked');
            if (!$checked.length) {
                alert("{{ trans('lang.select_delete_alert') }}");
                return;
            }
            if (!confirm("{{ trans('lang.selected_delete_alert') }}")) {
                return;
            }
            jQuery("#data-table_processing").show();
            var ids = $checked.map(function () { return $(this).attr('dataId'); }).get();
            var failed = [];
            for (const id of ids) {
                const res = await syncToDjango(`products/${id}/`, 'DELETE');
                if (!res || !res.status) {
                    failed.push(id);
                }
            }
            if (failed.length) {
                alert("Error deleting " + failed.length + " item(s).");
            }
            window.location.reload();
        });

    </script>

@endsection