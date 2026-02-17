@extends('layouts.app')



@section('content')

    <div class="page-wrapper">

        <div class="card">

            <div class="payment-top-tab mt-3 mb-3">

                <ul class="nav nav-tabs card-header-tabs align-items-end">

                    <li class="nav-item">
                        <a class="nav-link payme_active_label" href="{!! url('settings/payment/payme') !!}">
                            <i class="fa fa-credit-card mr-2"></i>Payme<span class="badge ml-2"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active cod_active_label" href="{!! url('settings/payment/cod') !!}"><i
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

                            <legend><i class="mr-3 fa fa-money"></i>{{trans('lang.app_setting_cod_short')}}</legend>

                            <div class="form-check width-100">

                                <input type="checkbox" class=" enable_cod" id="enable_cod">

                                <label class="col-3 control-label"
                                    for="enable_cod">{{trans('lang.app_setting_enable_cod')}}</label>

                                <div class="form-text text-muted">

                                    {!! trans('lang.app_settings_enable_cod_help') !!}

                                </div>

                            </div>

                        </fieldset>

                    </div>

                </div>

            </div>



            <div class="form-group col-12 text-center btm-btn" style="margin-bottom: inherit;">

                <button type="button" class="btn btn-primary edit-setting-btn"><i class="fa fa-save"></i>
                    {{trans('lang.save')}}</button>

                <a href="{{url('/dashboard')}}" class="btn btn-default"><i
                        class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>

            </div>



        </div>

    </div>



@endsection



@section('scripts')



    <script type="text/javascript">



        var database = firebase.firestore();
        var ref = database.collection('settings').doc('CODSettings');
        var walletData = database.collection('settings').doc('walletSettings');
        var paymeSettings = database.collection('settings').doc('paymeSettings');



        $(document).ready(function () {

            jQuery("#data-table_processing").show();

            ref.get().then(async function (snapshots) {

                var cod = snapshots.data();



                if (cod.isEnabled) {

                    $(".enable_cod").prop('checked', true);

                    jQuery(".cod_active_label span").addClass('badge-success');

                    jQuery(".cod_active_label span").text('Active');

                }



                walletData.get().then(async function (walletSnapshots) {

                    var wallet = walletSnapshots.data();

                    if (wallet.isEnabled) {

                        jQuery(".wallet_active_label span").addClass('badge-success');

                        jQuery(".wallet_active_label span").text('Active');

                    }

                })



                paymeSettings.get().then(async function (paymeSnapshot) {
                    var payme = paymeSnapshot.data();

                    if (payme && payme.enable) {
                        jQuery(".payme_active_label span").addClass('badge-success');
                        jQuery(".payme_active_label span").text('Active');
                    }
                })



                jQuery("#data-table_processing").hide();

            })



            $(".edit-setting-btn").click(function () {



                var isCODEnabled = $(".enable_cod").is(":checked");

                database.collection('settings').doc("CODSettings").update({ 'isEnabled': isCODEnabled, 'name': 'Naqt pul' }).then(function (result) {



                    window.location.href = '{{ url("settings/payment/cod")}}';



                });



            })



        })



    </script>



@endsection