@extends('layouts.app')

@section('content')

<?php
$countries = file_get_contents(public_path('countriesdata.json'));
$countries = json_decode($countries);
$countries = (array)$countries;
$newcountries = array();
$newcountriesjs = array();
foreach ($countries as $keycountry => $valuecountry) {
    $newcountries[$valuecountry->phoneCode] = $valuecountry;
    $newcountriesjs[$valuecountry->phoneCode] = $valuecountry->code;
} 
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.edit_vendor')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('vendors') !!}">{{trans('lang.vendors')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.edit_vendor')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="resttab-sec">
                    <div class="menu-tab">
                        <ul>
                            <li class="active vendorRouteLi" style="display:none;">
                                <a href="{{ route('vendors.edit', $id) }}"> <i class="ti-user"></i> {{ trans('lang.profile') }}</a>
                            </li>
                            <li class="vendorRouteLi" style="display:none;">
                                <a class="vendorRoute"> <i class="ri-shopping-bag-2-fill"></i> {{ trans('lang.vendor') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="error_top"></div>
                    <div class="row vendor_payout_create">
                        <div class="vendor_payout_create-inner">

                            <fieldset>
                                <legend>{{trans('lang.admin_area')}}</legend>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control user_first_name" required>
                                        <div class="form-text text-muted">
                                            {{ trans("lang.user_first_name_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.last_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control user_last_name">
                                        <div class="form-text text-muted">
                                            {{ trans("lang.user_last_name_help") }}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                    <div class="col-7">
                                        <input type="email" class="form-control user_email" required>
                                        <div class="form-text text-muted">
                                            {{ trans("lang.user_email_help") }}
                                        </div>
                                    </div>
                                </div>
 

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control user_phone"
                                            onkeypress="return chkAlphabets2(event,'error1')">
                                        <div id="error1" class="err"></div>
                                        <div class="form-text text-muted w-50">
                                            {{ trans("lang.user_phone_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-3 control-label">{{trans('lang.user_profile_picture')}}</label>
                                    <input type="file" onChange="handleFileSelectowner(event,'vendor')" class="col-7">
                                    <div id="uploding_image_owner"></div>

                                    <div class="uploaded_image_owner" style="display:none;">
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="change_expiry_date_div" style="display:none;">
                                    <legend>{{ trans('lang.store_subscription_model') }}</legend>
                                   
                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{ trans('lang.change_expiry_date') }}</label>
                                        <div class="col-7">
                                            <input type="date" name="change_expiry_date" class="form-control"
                                                id="change_expiry_date" value="">
                                        </div>
                                    </div>
                                </fieldset>

                            

                            <fieldset>
                                <legend>{{trans('lang.vendor')}} {{trans('lang.active_deactive')}}</legend>

                                <div class="form-group row width-100">
                                    <div class="form-check">
                                        <input type="checkbox" id="is_active">
                                        <label class="col-3 control-label"
                                            for="is_active">{{trans('lang.active')}}</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" id="reset_password">
                                        <label
                                            class="col-3 control-label">{{trans('lang.reset_store_password')}}</label>

                                            <div class="form-text text-muted w-100 col-12">
                                            {{ trans("lang.note_reset_store_password_email") }}
                                        </div>
                                    </div>
                                    <div class="form-button" style="margin-top: 16px;margin-left: 20px;">
                                        <button type="button" class="btn btn-primary"
                                            id="send_mail">{{trans('lang.send_mail')}}
                                        </button>
                                    </div>
                                </div>


                            </fieldset>

                            <fieldset>
                                <legend>{{trans('lang.bankdetails')}}</legend>

                                <div class="form-group row">

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.bank_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="bank_name" class="form-control" id="bankName">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.branch_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="branch_name" class="form-control" id="branchName">
                                        </div>
                                    </div>


                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.holer_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="holer_name" class="form-control" id="holderName">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.account_number')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="account_number" class="form-control"
                                                id="accountNumber">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.other_information')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="other_information" class="form-control"
                                                id="otherDetails">
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                          
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group col-12 text-center btm-btn">
            <button type="button" class="btn btn-primary  edit-form-btn"><i class="fa fa-save"></i>
                {{trans('lang.save')}}
            </button>
            <a href="{!! route('vendors') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
        </div>

    </div>
</div>


@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

<script type="text/javascript">

    var id = "<?php echo $id; ?>";
    var store_id = null;
    var subscriptionPlanId = '';
    database.collection('users').where("id", "==", id).get().then(function(snapshot) {
        if (!snapshot.empty) {
            snapshot.forEach(function(doc) {
                var data = doc.data(); 
                if (data.hasOwnProperty('subscriptionPlanId') && data.subscriptionPlanId != null && data.subscriptionPlanId != '') {
                    subscriptionPlanId = data.subscriptionPlanId;
                    $(".change_expiry_date_div").show(); 
                } else {
                   
                    $(".change_expiry_date_div").hide(); 
                }

                if (data.hasOwnProperty('vendorID') && data.vendorID != null && data.vendorID != '') {
                    store_id = data.vendorID;
                }
                
            });
        }
    });
    var database = firebase.firestore();  
    var ref = database.collection('users').where("id", "==", id);  
    var photo = "";

    var vendorOwnerId = "";
    var vendorOwnerOnline = false;
    var photocount = 0;

    var ownerPhoto = '';
    var ownerFileName = '';
    var ownerOldImageFile = '';

    var ownerId = '';

    
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    var storageRef = firebase.storage().ref('images');
    var storage = firebase.storage();

    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })

    $("#send_mail").click(function () {
        if ($("#reset_password").is(":checked")) {
            var email = $(".user_email").val();
            firebase.auth().sendPasswordResetEmail(email)
                .then((res) => {
                    alert('{{trans("lang.store_mail_sent")}}');
                })
                .catch((error) => {
                    console.log('Error password reset: ', error);
                });
        } else {
            alert('{{trans("lang.error_reset_store_password")}}');
        }
    });


        jQuery("#data-table_processing").show();
        
        // Fetch from REST API
        syncToDjango(`vendors/${id}/`, 'GET').then(async function (response) {
            if (response && response.status && response.data) {
                var user = response.data;

                ownerId = user.id;
                ownerPhoto = user.image;
                $(".user_first_name").val(user.first_name);
                $(".user_last_name").val(user.last_name);
                $(".user_email").val(user.email).prop('disabled', true);
                $(".user_phone").val(user.phone_number).prop('disabled', true);

                if (user.image) {
                    photo = user.image;
                    $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;">').show();
                } else {
                    $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + placeholderImage + '" width="150px" height="150px;">').show();
                }

                if (user.active) {
                    $("#is_active").prop("checked", true);
                }
                
                // Bank details
                if (user.bank_details) {
                    try {
                        var bank = typeof user.bank_details === 'string' ? JSON.parse(user.bank_details) : user.bank_details;
                        $("#bankName").val(bank.bankName);
                        $("#branchName").val(bank.branchName);
                        $("#holderName").val(bank.holderName);
                        $("#accountNumber").val(bank.accountNumber);
                        $("#otherDetails").val(bank.otherDetails);
                    } catch (e) {
                        console.error("Error parsing bank details", e);
                    }
                }
            }
            jQuery("#data-table_processing").hide();
        });

        $(".edit-form-btn").click(async function () {

            var userFirstName = $(".user_first_name").val();
            var userLastName = $(".user_last_name").val();
            var vendor_active = $("#is_active").is(':checked');

            if (userFirstName == '') {
                $(".error_top").show().html("<p>{{trans('lang.enter_owners_name_error')}}</p>");
                window.scrollTo(0, 0);
            } else {
                jQuery("#data-table_processing").show();
                try {
                    let profileImage = ownerPhoto;
                    // Check if ownerPhoto is base64 (newly uploaded)
                    if (ownerPhoto && ownerPhoto.startsWith('data:image')) {
                        const IMG = await storeImageData();
                        profileImage = IMG.ownerImage || ownerPhoto;
                    }

                    const bankDetails = {
                        'bankName': $("#bankName").val(),
                        'branchName': $("#branchName").val(),
                        'holderName': $("#holderName").val(),
                        'accountNumber': $("#accountNumber").val(),
                        'otherDetails': $("#otherDetails").val(),
                    };

                    const result = await syncToDjango(`vendors/${id}/`, 'PATCH', {
                        'first_name': userFirstName,
                        'last_name': userLastName,
                        'image': profileImage,
                        'active': vendor_active,
                        'bank_details': JSON.stringify(bankDetails)
                    });

                    if (result && result.status) {
                        Swal.fire('Update Complete!', `Vendor updated.`, 'success').then(() => {
                            window.location.href = '{{ route("vendors")}}';
                        });
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

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "<?php echo URL::to('/');?>/scss/icons/flag-icon-css/flags";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + newcountriesjs[state.element.value].toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    }
    function formatState2(state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "<?php echo URL::to('/');?>/scss/icons/flag-icon-css/flags";
        var $state = $(
            '<span><img class="img-flag" /> <span></span></span>'
        );
        $state.find("span").text(state.text);
        $state.find("img").attr("src", baseUrl + "/" + newcountriesjs[state.element.value].toLowerCase() + ".svg");
        return $state;
    }
    var newcountriesjs = '<?php echo json_encode($newcountriesjs); ?>';
    var newcountriesjs = JSON.parse(newcountriesjs);


    async function updateSubscriptionHistory(ownerId, subscriptionPlanExpiryDate,store_id) {
        try {

            const userRef = database.collection('users').doc(ownerId);
            const userDoc = await userRef.get();
            const data = userDoc.data();
            
            if (data.subscriptionPlanId != "" && data.subscriptionPlanId != null) {
                
                database.collection('users').doc(ownerId).update({
                    'subscriptionExpiryDate': subscriptionPlanExpiryDate,
                });
            }
            
            const lastSubscriptionHistory = await database.collection('subscription_history').where('user_id','==',ownerId).orderBy('createdAt','desc').get();
            if(lastSubscriptionHistory && lastSubscriptionHistory.docs && lastSubscriptionHistory.docs.length > 0){
                const subscriptionData = lastSubscriptionHistory.docs[0].data();
                database.collection('subscription_history').doc(subscriptionData.id).update({
                    'expiry_date': subscriptionPlanExpiryDate,
                });
            }
            
        } catch (error) {
            console.error("Error updating subscription history:", error);
        }
    }

    $(document).on("click", ".remove-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_" + id).remove();
        var status = $(this).attr('data-status');
        if (status == "old") {
            galleryImageToDelete.push(firebase.storage().refFromURL(photo_remove));
        }
        index = vendor_photos.indexOf(photo_remove);
        if (index > -1) {
            vendor_photos.splice(index, 1);
        }
        index = new_added_vendor_photos.indexOf(photo_remove);
        if (index > -1) {
            new_added_vendor_photos.splice(index, 1); // 2nd parameter means remove one item only
            new_added_vendor_photos_filename.splice(index, 1);
        }

    });


    function handleFileSelectowner(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                ownerPhoto = filePayload;
                ownerFileName = filename;
                if(ownerPhoto){
                    photo=ownerPhoto;
                }else{
                    photo=placeholderImage;
                }
                $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;">');
                $(".uploaded_image_owner").show();
            };
        })(f);
        reader.readAsDataURL(f);
    }

    function chkAlphabets2(event, msg) {
        if (!(event.which >= 48 && event.which <= 57)
        ) {
            document.getElementById(msg).innerHTML = "Accept only Number";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

   
    async function storeImageData() {
        var newPhoto = [];
        newPhoto['ownerImage'] = ownerPhoto;
        try {
            if (ownerPhoto != '') {
                if (ownerOldImageFile != "" && ownerPhoto != ownerOldImageFile) {
                    var ownerOldImageUrlRef = await storage.refFromURL(ownerOldImageFile);
                    imageBucket = ownerOldImageUrlRef.bucket;
                    var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

                    if (imageBucket == envBucket) {
                        await ownerOldImageUrlRef.delete().then(() => {
                            console.log("Old file deleted!")
                        }).catch((error) => {
                            console.log("ERR File delete ===", error);
                        });
                    } else {
                        console.log('Bucket not matched');
                    }
                }

                if (ownerPhoto != ownerOldImageFile) {

                    ownerPhoto = ownerPhoto.replace(/^data:image\/[a-z]+;base64,/, "")
                    var uploadTask = await storageRef.child(ownerFileName).putString(ownerPhoto, 'base64', { contentType: 'image/jpg' });
                    var downloadURL = await uploadTask.ref.getDownloadURL();
                    newPhoto['ownerImage'] = downloadURL;
                    ownerPhoto = downloadURL;
                }
            }
           
        } catch (error) {
            console.log("ERR ===", error);
        }

        return newPhoto;
    }


</script>
@endsection
