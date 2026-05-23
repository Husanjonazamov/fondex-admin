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
                    <li class="breadcrumb-item"><a href="{!! route('categories') !!}">{{trans('lang.category_plural')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.category_edit')}}</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="cat-edite-page max-width-box">
                <div class="card  pb-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li role="presentation" class="nav-item">
                                <a href="#category_information" aria-controls="category_information" role="tab"
                                    data-toggle="tab" class="nav-link active"><i class="ri-list-indefinite"></i>
                                    {{trans('lang.category_information')}}</a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a href="#review_attributes" aria-controls="review_attributes" role="tab" data-toggle="tab"
                                    class="nav-link"><i class="ri-list-check"></i>
                                    {{trans('lang.reviewattribute_plural')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="error_top" style="display:none"></div>
                        <div class="row vendor_payout_create" role="tabpanel">
                            <div class="vendor_payout_create-inner tab-content category_edit_div">
                                <div role="tabpanel" class="tab-pane active" id="category_information">
                                    <fieldset>
                                        <legend>{{trans('lang.category_edit')}}</legend>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.category_name')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control cat-name">
                                                <div class="form-text text-muted">{{ trans("lang.category_name_help") }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label
                                                class="col-3 control-label ">{{trans('lang.category_description')}}</label>
                                            <div class="col-7">
                                                <textarea rows="7" class="category_description form-control"
                                                    id="category_description"></textarea>
                                                <div class="form-text text-muted">{{ trans("lang.category_description_help")
                                                        }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.category_image')}}</label>
                                            <div class="col-7">
                                                <input type="file" id="category_image">
                                                <div class="placeholder_img_thumb cat_image"></div>
                                                <div id="uploding_image"></div>
                                                <div class="form-text text-muted w-50">{{ trans("lang.category_image_help")
                                                        }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check width-100">
                                            <input type="checkbox" class="item_publish" id="item_publish">
                                            <label class="col-3 control-label"
                                                for="item_publish">{{trans('lang.item_publish')}}</label>
                                        </div>
                                        <div class="form-check row width-100" id="show_in_home" style="display: none;">
                                            <input type="checkbox" id="show_in_homepage">
                                            <label class="col-3 control-label"
                                                for="show_in_homepage">{{trans('lang.show_in_home')}}</label>
                                            <div class="form-text text-muted w-50">{{trans('lang.show_in_home_desc')}}
                                                <span id="forsection"></span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="review_attributes">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 text-center btm-btn">
                        <button type="button" class="btn btn-primary edit-setting-btn"><i class="fa fa-save"></i>
                            {{trans('lang.save')}}
                        </button>
                        <a href="{!! route('categories') !!}" class="btn btn-default"><i
                                class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">

        var section_id = getCookie('section_id') || '';
        var id = "<?php echo $id; ?>";
        var database = firebase.firestore();

        var ref = database.collection('vendor_categories').where("id", "==", id);
        var ref_review_attributes = database.collection('review_attributes');
        var selected_review_attributes = '';
        var category = '';
        var photo = "";
        var fileName = '';
        var catImageFile = "";
        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');
        var storage = firebase.storage();
        var storageRef = firebase.storage().ref('images');
        var order = 0;
        let sectionData = '';

        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })
        $(document).ready(function () {

            jQuery("#data-table_processing").show();

            database.collection('sections').doc(section_id).get().then(async function (snapshot) {
                sectionData = snapshot.data();
                if (sectionData.serviceTypeFlag == "ecommerce-service" || sectionData.serviceTypeFlag == "delivery-service") {
                    $("#show_in_home").show();
                }
            });

            // Fetch from REST API
            syncToDjango(`categories/${id}/`, 'GET').then(async function (response) {
                if (response && response.status && response.data) {
                    category = response.data;
                    $(".cat-name").val(category.title);
                    order = category.order || 0;
                    $(".category_description").val(category.description);
                    photo = category.photo;
                    if (photo != '' && photo != null) {
                        catImageFile = photo;
                        $(".cat_image").append('<img class="rounded" style="width:50px" src="' + photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">');
                    } else {
                        $(".cat_image").append('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');
                    }
                    if (category.is_publish) {
                        $(".item_publish").prop('checked', true);
                    }
                    if (category.show_in_homepage) {
                        $("#show_in_homepage").prop('checked', true);
                    }
                    if (sectionData) {
                        $("#forsection").text(" for " + sectionData.name + " section");
                    }
                }
                jQuery("#data-table_processing").hide();
            });

            ref_review_attributes.get().then(async function (snapshots) {
                var ra_html = '';
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    ra_html += '<div class="form-check width-100" >';
                    var checked = (category && category.review_attributes && $.inArray(data.id, category.review_attributes) !== -1) ? 'checked' : '';
                    ra_html += '<input type="checkbox" id="review_attribute_' + data.id + '" value="' + data.id + '" ' + checked + '>';
                    ra_html += '<label class="col-3 control-label" for="review_attribute_' + data.id + '">' + data.title + '</label>';
                    ra_html += '</div>';
                })
                $('#review_attributes').html(ra_html);
            })

            $(".edit-setting-btn").click(async function () {
                var title = $(".cat-name").val();
                var description = $(".category_description").val();
                var itemPublish = $(".item_publish").is(":checked");
                var show_in_homepage = $("#show_in_homepage").is(":checked");
                var review_attributes = [];
                $('#review_attributes input').each(function () {
                    if ($(this).is(':checked')) {
                        review_attributes.push($(this).val());
                    }
                });
                
                if (title == '') {
                    $(".error_top").show().html("<p>{{trans('lang.enter_cat_title_error')}}</p>");
                    window.scrollTo(0, 0);
                } else {
                    jQuery("#data-table_processing").show();
                    try {
                        const formData = new FormData();
                        formData.append('title', title);
                        formData.append('description', description);
                        formData.append('is_publish', itemPublish ? 'true' : 'false');
                        formData.append('show_in_homepage', show_in_homepage ? 'true' : 'false');
                        review_attributes.forEach(function (ra) {
                            formData.append('review_attributes', ra);
                        });
                        if (photo && photo !== catImageFile && /^data:image\//i.test(photo)) {
                            const blob = base64ToBlob(photo);
                            const ext = (blob.type.split('/')[1] || 'jpg').replace('jpeg', 'jpg');
                            formData.append('photo', blob, 'category_' + Date.now() + '.' + ext);
                        }

                        const result = await syncToDjango(`categories/${id}/`, 'PATCH', formData);

                        if (result && result.status) {
                            window.location.href = '{{ route("categories")}}';
                        } else {
                            throw new Error(result ? result.message : 'Unknown error');
                        }
                    } catch (error) {
                        jQuery("#data-table_processing").hide();
                        $(".error_top").show().html("<p>" + error.message + "</p>");
                        window.scrollTo(0, 0);
                    }
                }
            });
        });
        function handleFileSelect(evt) {
            var f = evt.target.files[0];
            var reader = new FileReader();
            reader.onload = (function (theFile) {
                return function (e) {
                    var filePayload = e.target.result;
                    var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                    var val = $('#category_image').val().toLowerCase();
                    var ext = val.split('.')[1];
                    var docName = val.split('fakepath')[1];
                    var filename = $('#category_image').val().replace(/C:\\fakepath\\/i, '')
                    var timestamp = Number(new Date());
                    var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                    var uploadTask = storageRef.child(filename).put(theFile);
                    uploadTask.on('state_changed', function (snapshot) {
                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    }, function (error) {
                    }, function () {
                        uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                            jQuery("#uploding_image").text("Upload is completed");
                            photo = downloadURL;
                            $(".cat_image").empty();
                            $(".cat_image").append('<img class="rounded" style="width:50px" src="' + photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">');
                        });
                    });
                };
            })(f);
            reader.readAsDataURL(f);
        }
        //upload image with compression
        $("#category_image").resizeImg({
            callback: function (base64str) {
                var val = $('#category_image').val().toLowerCase();
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = $('#category_image').val().replace(/C:\\fakepath\\/i, '')
                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                photo = base64str;
                fileName = filename;
                $(".cat_image").empty();
                $(".cat_image").append('<img class="rounded" style="width:50px" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">');
                $("#category_image").val('');
            }
        });
        function base64ToBlob(base64) {
            var match = /^data:(image\/[a-z]+);base64,(.+)$/i.exec(base64);
            var mime = match ? match[1] : 'image/jpeg';
            var data = match ? match[2] : base64.replace(/^data:image\/[a-z]+;base64,/, '');
            var binary = atob(data);
            var len = binary.length;
            var bytes = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
                bytes[i] = binary.charCodeAt(i);
            }
            return new Blob([bytes], { type: mime });
        }
    </script>
@endsection