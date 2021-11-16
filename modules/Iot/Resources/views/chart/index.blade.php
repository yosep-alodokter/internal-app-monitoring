@extends('layouts.skote.master')

@section('title') Chart IOT @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">

    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/datepicker/datepicker.min.css') }}">
@endsection

@section('content')

    @component('common-components.skote.breadcrumb')
        @slot('title') Chart @endslot
        @slot('li_1') Iot @endslot
        @slot('li_2') Chart @endslot
    @endcomponent

    
    @include('common-components.skote.alert-info-n-error')

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-parsley" id="jq-validation-form-create">
                                <input type="hidden" id="tipeProses" value="create">
                                @csrf
                                <div class="form-group" style="padding-top: 10px;" class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Pilih Device<sup class="text-danger">*</sup></label>
                                    <div class="col-md-12">
                                        {!! Form::select('device_id', $dataIotDevice, null, ['placeholder' => 'Select', 'class' => 'form-control select2', 'id' => 'device_id', 'name' => 'device_id']) !!}
                                    </div>
                                </div>
                                <div id="value-input"></div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="btnSubmitForm">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div id="value-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Realtimechart Testing</h4>

                    <div id="realtime_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="realtime_line" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div> --}}
    
@endsection

@section('script')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- validation -->
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/additional-methods.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-validation-new/localization/messages_id.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('js/iot/chart/index.js') }}"></script>
    <script src="{{ URL::asset('js/iot/chart/validationChart.js') }}"></script>

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