@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="" method="post">
                @csrf
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('Online Payment')</p>
                                <p class="mb-0">
                                    <small>@lang('If you disable this module, no one can appointment payment by online')</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" name="online_payment" @if($general->online_payment) checked @endif>
                            </div>
                        </li>


                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('Force SSL')</p>
                                <p class="mb-0">
                                    <small>@lang('By enabling') <span class="fw-bold">@lang("Force SSL (Secure Sockets Layer)")</span> @lang('the system will force a visitor that he/she must have to visit in secure mode. Otherwise, the site will be loaded in secure mode.')</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" name="force_ssl" @if($general->force_ssl) checked @endif>
                            </div>
                        </li>

                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('Email Notification')</p>
                                <p class="mb-0">
                                    <small>@lang('If you enable this module, the system will send emails to users where needed. Otherwise, no email will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any emails.')</code></small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" name="en" @if($general->en) checked @endif>
                            </div>
                        </li>




                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('SMS Notification')</p>
                                <p class="mb-0">
                                    <small>@lang('If you enable this module, the system will send SMS to users where needed. Otherwise, no SMS will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any SMS.')</code></small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" name="sn" @if($general->sn) checked @endif>
                            </div>
                        </li>

                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('Language Option')</p>
                                <p class="mb-0">
                                    <small>@lang('If you enable this module, users can change the language according to their needs')</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" name="multi_language" @if($general->multi_language) checked @endif>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .toggle.btn-lg{
        height: 37px !important;
        min-height: 37px !important;
    }
    .toggle-handle{
        width: 25px !important;
        padding: 0;
    }
    .form-group{
        width: 125px;
        margin-bottom: 0;
        flex-shrink: 0
    }
    .list-group-item:hover {
        background-color: #F7F7F7
    }
</style>
@endpush
