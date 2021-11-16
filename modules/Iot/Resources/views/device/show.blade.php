@extends('layouts.skote.master')

@section('title') Detail Device IOT @endsection

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
        @slot('title') Detail Device IOT @endslot
        @slot('li_1') IOT @endslot
        @slot('li_2') Device @endslot
    @endcomponent

    
    @include('common-components.skote.alert-info-n-error')

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Detail</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#prosessurat" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Parameter Device Input</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="detail" role="tabpanel">   
                            <div class="table-responsive">
                                <table class="table mb-0 table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 300px;">Device Name</th>
                                            <td>{{ $iot_device->device_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 300px;">Device Key</th>
                                            <td>{{ $iot_device->device_key }}</td>
                                        </tr>
                                        @php                                            
                                            $color = ($iot_device->is_active == "yes") ? "success" : "danger"; 
                                        @endphp
                                        <tr>
                                            <th scope="row" style="width: 300px;">Status Active</th>
                                            <td><span class="badge bg-{{ $color }}">{{ $iot_device->is_active }}</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 300px;">Group Site</th>
                                            <td>{{ is_null($iot_device->group_site) ? '-' : $iot_device->group_site->nama_group }}</td>
                                        </tr>
                                        @if ($iot_device->iot_device_details->count() > 0)
                                            <tr>
                                                <th scope="row" style="width: 300px;">URL Hit Data</th>
                                                <td class="text-primary">{{ route('api.v1.iot.device.history.input') }}/?{{ $paramText }}</td>
                                            </tr>                                            
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div><hr/></div>

                            <h2 class="card-title mt-4 mb-3" style="color: blue">Device - Parameter List</h2>                              
                            <table class="table table-bordered border-primary mb-0" id="iot-devicedetail-table-index">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Iot Device</th>
                                        <th>Param Type</th>
                                        <th>Param Value</th>
                                        <th>Status Active</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($iot_device->iot_device_details) > 0)
                                        @php
                                            $no = 0;   
                                        @endphp
                                        @foreach ($iot_device->iot_device_details as $item)
                                            @php
                                                $no++;   
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $no }}</th>
                                                <td>{{ $iot_device->device_name }}</td>
                                                <td>{{ $item->param_type }}</td>
                                                <td>{{ $item->param_value }}</td>
                                                @php                                            
                                                    $color = ($iot_device->is_active == "yes") ? "success" : "danger"; 
                                                @endphp
                                                <td><span class="badge bg-{{ $color }}">{{ $item->is_active }}</span></td>
                                                <td><a type="button" 
                                                    class="btn btn-danger btn-sm waves-effect waves-light btn-delete"
                                                    title="Delete"
                                                    data-id="{{ \Crypt::encrypt($item->id) }}"
                                                    data-name="Parameter Device"
                                                    data-url="{{ route('iot.device-detail.destroy', ['device_detail' => \Crypt::encrypt($item->id)]) }}"
                                                    >
                                                        <i class="bx bx-trash-alt font-size-16 align-middle me-2"></i> Delete
                                                    </a></td>
                                            </tr>
                                        @endforeach  
                                    @else
                                        <tr>
                                            <th scope="row" colspan="6" text-align="center">- tidak ada data. -</th>
                                        </tr>                                        
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-5 float-right">
                                <div class="button-items">
                                    <a href="{{ route('iot.device.index') }}" class="btn btn-danger waves-effect waves-light">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="prosessurat" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-4">
                                        <h4 class="card-title mb-4">Parameter Device Input</h4>
                                        <form class="form-parsley" id="jq-validation-form-create">
                                            <input type="hidden" id="tipeProsesDevice" value="create">
                                            @csrf
                                            <input type="hidden" id="dataIdDevice" name="dataIdDevice" value="{{ \Crypt::encrypt($iot_device->id) }}">

                                            <div class="form-group row mb-3">
                                                <label for="example-text-input" class="col-md-3 col-form-label">Device Name<sup class="text-danger">*</sup></label>
                                                <div class="col-md-9">
                                                    {!! Form::text('name', old('name', $iot_device->device_name), ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Device Name', 'readonly' => true]) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row mb-3">
                                                <label for="example-text-input" class="col-md-3 col-form-label">Param Type<sup class="text-danger">*</sup></label>
                                                <div class="col-md-9">
                                                    {!! Form::select('param_type', $typeParamDevice, null, ['placeholder' => 'Select', 'class' => 'form-control select2', 'id' => 'param_type', 'name' => 'param_type', 'style' => 'width: 100%']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row mb-2">
                                                <label for="example-text-input" class="col-md-3 col-form-label">Param Value<sup class="text-danger">*</sup></label>
                                                <div class="col-md-9">
                                                    {!! Form::text('param_value', old('param_value', null), ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'ruang_it']) !!}
                                                    <p class="text-muted"><b>Note:</b> gunakan underscore untuk mengisi param value. <b>contoh :</b> room_1,  ruang_it</p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mb-3">
                                                <label for="example-text-input" class="col-md-3 col-form-label">Active Status<sup class="text-danger">*</sup></label>
                                                <div class="col-md-9">
                                                    {!! Form::select('is_active', ['yes' => 'Yes', 'no' => 'No'], null, ['placeholder' => 'Select', 'class' => 'form-control select2', 'id' => 'is_active', 'name' => 'is_active', 'style' => 'width: 100%']) !!}
                                                </div>
                                            </div>

                                            <div class="mt-4 float-right">
                                                <div class="button-items">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="btnSubmitForm">Save</button>
                                                </div>
                                            </div>

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
     <!-- validation -->
     <script src="{{ URL::asset('assets/libs/jquery-validation-new/jquery.validate.min.js') }}"></script>
     <script src="{{ URL::asset('assets/libs/jquery-validation-new/additional-methods.min.js') }}"></script>
     <script src="{{ URL::asset('assets/libs/jquery-validation-new/localization/messages_id.min.js') }}"></script>
     
     <!-- alert -->
     <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
 
     <!-- forms -->
     <script src="{{ URL::asset('js/iot/device-detail/forms/form-devicedetail.js') }}"></script>
     <script src="{{ URL::asset('js/iot/device-detail/validator/validationDeviceDetail.js') }}"></script>
 
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