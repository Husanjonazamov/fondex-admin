@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="card">
        
        <div class="payment-top-tab mt-3 mb-3">

            <ul class="nav nav-tabs card-header-tabs align-items-end">

                <li class="nav-item">

                    <a class="nav-link  stripe_active_label" href="{!! url('settings/payment/stripe') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_stripe')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link active payme_active_label" href="{!! url('settings/payment/payme') !!}">
                        <i class="fa fa-credit-card mr-2"></i>Payme<span class="badge ml-2"></span>
                    </a>
                </li>


                <li class="nav-item">

                    <a class="nav-link cod_active_label" href="{!! url('settings/payment/cod') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_cod_short')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link razorpay_active_label" href="{!! url('settings/payment/razorpay') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_razorpay')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link paypal_active_label" href="{!! url('settings/payment/paypal') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_paypal')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link wallet_active_label" href="{!! url('settings/payment/wallet') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_wallet')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>



                <li class="nav-item">

                    <a class="nav-link payfast_active_label" href="{!! url('settings/payment/payfast') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.payfast')}}<span class="badge ml-2"></span>

                    </a>

                </li>





                <li class="nav-item">

                    <a class="nav-link paystack_active_label" href="{!! url('settings/payment/paystack') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_paystack_lable')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>



                <li class="nav-item">

                    <a class="nav-link flutterWave_active_label" href="{!! url('settings/payment/flutterwave') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.flutterWave')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link mercadopago_active_label" href="{!! url('settings/payment/mercadopago') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.mercadopago')}}<span

                            class="badge ml-2"></span></a>

                </li>

                <li class="nav-item">

                    <a class="nav-link xendit_active_label" href="{!! url('settings/payment/xendit') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.xendit')}}<span class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link midTrans_active_label" href="{!! url('settings/payment/midtrans') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.midtrans')}}<span class="badge ml-2"></span>

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link  orangePay_active_label" href="{!! url('settings/payment/orangepay') !!}"><i

                            class="fa fa-envelope-o mr-2"></i>{{trans('lang.orangePay')}}<span

                            class="badge ml-2"></span>

                    </a>

                </li>

            </ul>

        </div>

        <div class="card-body">
            <div class="row vendor_payout_create">
                <div class="vendor_payout_create-inner">
                    <fieldset>
                        <legend><i class="mr-3 fa fa-credit-card"></i>Payme Settings</legend>

                        <div class="form-group row width-100">
                            <label class="col-3 control-label">Payme ID</label>
                            <div class="col-7">
                                <input type="text" class="form-control payme__id">
                                <div class="form-text text-muted">
                                    Enter your Payme ID
                                </div>
                            </div>
                        </div>

                        <div class="form-group row width-100">
                            <label class="col-3 control-label">Secret Key</label>
                            <div class="col-7">
                                <input type="password" class="form-control payme_key">
                                <div class="form-text text-muted">
                                    Enter your Payme Secret Key
                                </div>
                            </div>
                        </div>

                        <div class="form-check width-100">
                            <input type="checkbox" class="enable_payme" id="enable_payme">
                            <label class="col-3 control-label" for="enable_payme">Enable Payme</label>
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>

        <div class="form-group col-12 text-center btm-btn" style="margin-bottom:inherit;">
            <button type="button" class="btn btn-primary edit-payme-btn"><i class="fa fa-save"></i> Save</button>
            <a href="{{ url('/dashboard') }}" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</a>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
var database = firebase.firestore();
var paymeSettings = database.collection('settings').doc('paymeSettings');

$(document).ready(function() {

    // Firebase dan o'qish
    paymeSettings.get().then(function(snapshot) {
        var payme = snapshot.data();
        if(payme) {
            $(".payme_id").val(payme.merchant_id);
            $(".payme_key").val(payme.secret_key);
            if(payme.isEnabled) {
                $(".enable_payme").prop('checked', true);
                $(".payme_active_label span").addClass('badge-success').text('Active');
            }
        }
    });

    // Saqlash
    $(".edit-payme-btn").click(function() {
        var merchantId = $(".payme_id").val();
        var secretKey = $(".payme_key").val();
        var isEnabled = $(".enable_payme").is(":checked");

        paymeSettings.update({
            'merchant_id': merchantId,
            'secret_key': secretKey,
            'isEnabled': isEnabled
        }).then(function(result) {
            window.location.href = '{{ url("settings/payment/payme") }}';
        }).catch(function(err){
            alert("Error saving Payme settings: " + err);
        });
    });

});
</script>
@endsection
