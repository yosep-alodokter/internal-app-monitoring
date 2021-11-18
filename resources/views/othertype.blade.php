@extends('layouts.skote-horizontal.master-layouts')

@section('title') Monitoring Chart @endsection

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

@section('body')
    <body data-topbar="light" data-layout="horizontal">
@endsection

@section('content')

    @component('common-components.skote.breadcrumb')
        @slot('li_1') 
            {!! Form::select('device_id', $dataIotDevice, null, ['placeholder' => 'Pilih Device', 'class' => 'form-control select2', 'id' => 'device_id', 'name' => 'device_id', 'style' => 'width: 200px']) !!} 
        @endslot
        @slot('title') Monitoring Device @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <input value="{{ app('file.helper')->getFileUrl('inventory_default_image.png', 'inventory_image') }}" id="hidden_url" type="hidden">
                
                <div id="value-chart">
                    <div class="card-body">
                        <img src="{{ app('file.helper')->getFileUrl('inventory_default_image.png', 'inventory_image') }}" alt="" class="img-fluid mx-auto d-block rounded" width="700px" height="700px">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

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

    <script src="{{ URL::asset('js/monitoring/chart/othertype.js') }}"></script>
    <script src="{{ URL::asset('js/monitoring/chart/validationChart.js') }}"></script>

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

