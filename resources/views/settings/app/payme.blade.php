@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="card">

            <div class="payment-top-tab mt-3 mb-3">

                <ul class="nav nav-tabs card-header-tabs align-items-end">

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
                        <a class="nav-link wallet_active_label" href="{!! url('settings/payment/wallet') !!}"><i
                                class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_wallet')}}<span
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
                                    <input type="text" class="form-control payme_id">
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
                <button type="button" class="btn btn-primary edit-setting-btn"><i class="fa fa-save"></i> Save</button>
                <a href="{{ url('/dashboard') }}" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</a>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script type="text/javascript">

        var database = firebase.firestore();

        var codData = database.collection('settings').doc('CODSettings');
        var walletData = database.collection('settings').doc('walletSettings');
        var paymeSettings = database.collection('settings').doc('paymeSettings');

        var paymeSettings = database.collection('settings').doc('paymeSettings');



        $(document).ready(function () {

            jQuery("#data-table_processing").show();

            paymeSettings.get().then(async function (snapshot) {
                var payme = snapshot.data();

                if (payme && payme.enable) {
                    $(".enable_payme").prop('checked', true);
                    jQuery(".payme_active_label span").addClass('badge-success').text('Active');
                }

                $(".payme_id").val(payme ? payme.merchant_id : '');
                $(".payme_key").val(payme ? payme.secret_key : '');

                codData.get().then(async function (codSnapshots) {
                    var cod = codSnapshots.data();
                    if (cod.isEnabled) {
                        jQuery(".cod_active_label span").addClass('badge-success');
                        jQuery(".cod_active_label span").text('Active');
                    }
                })

                walletData.get().then(async function (walletSnapshots) {
                    var wallet = walletSnapshots.data();
                    if (wallet.isEnabled) {
                        jQuery(".wallet_active_label span").addClass('badge-success');
                        jQuery(".wallet_active_label span").text('Active');
                    }
                })

                jQuery("#data-table_processing").hide();
            });



        });

        $(".edit-setting-btn").click(function () {
            var payme_id = $(".payme_id").val();
            var payme_key = $(".payme_key").val();
            var isEnabled = $(".enable_payme").is(":checked");

            paymeSettings.set({
                merchant_id: payme_id,
                secret_key: payme_key,
                enable: isEnabled
            }, { merge: true })
                .then(function () {
                    alert("Payme settings saqlandi!");
                    window.location.href = '{{ url("settings/payment/payme") }}';
                })
                .catch(function (err) {
                    alert("Error saving Payme settings: " + err);
                });
        });
    </script>
@endsection