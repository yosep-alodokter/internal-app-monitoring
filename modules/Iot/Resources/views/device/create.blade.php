@extends('layouts.skote.master')

@section('title') Device @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/datepicker/datepicker.min.css') }}">
@endsection

@section('content')

    @component('common-components.skote.breadcrumb')
        @slot('title') Create Device @endslot
        @slot('li_1') IOT @endslot
        @slot('li_2') Device @endslot
    @endcomponent

    
    @include('common-components.skote.alert-info-n-error')

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">

                    <form class="form-parsley" id="jq-validation-form-create">
                        <input type="hidden" id="dataId" value="">
                        <input type="hidden" id="tipeProses" value="create">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group row mb-3">
                            <label for="example-text-input" class="col-md-2 col-form-label">Device Name<sup class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" id="device_name" name="device_name" placeholder="Device Name">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="example-text-input" class="col-md-2 col-form-label">Device Key<sup class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" id="device_key" name="device_key" placeholder="Device Key">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="example-text-input" class="col-md-2 col-form-label">Is Active<sup class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                {!! Form::select('is_active', ["yes" => "yes", "no" => "no"], null, ['placeholder' => 'Select', 'class' => 'form-control select2', 'id' => 'is_active', 'name' => 'is_active']) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="example-text-input" class="col-md-2 col-form-label">Group Site<sup class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                {!! Form::select('group_id', $dataGroupSite, null, ['placeholder' => 'Select', 'class' => 'form-control select2', 'id' => 'group_id', 'name' => 'group_id']) !!}
                            </div>
                        </div>

                        <div class="mt-4 float-right">
                            <div class="button-items">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="btnSubmitForm">Save</button>
                                <a href="{{ route('iot.device.index') }}" class="btn btn-danger waves-effect waves-light">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    
@endsection

@section('script')
    <!-- validation -->
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/additional-methods.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/localization/messages_id.min.js') }}"></script>

    <!-- forms -->
    <script src="{{ URL::asset('js/iot/device/forms/form-device.js') }}"></script>
    <script src="{{ URL::asset('js/iot/device/validator/validationDevice.js') }}"></script>
    
    <!-- alert -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- additional form advanced -->
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection