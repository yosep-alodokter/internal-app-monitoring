@extends('layouts.skote.master')

@section('title') Device IOT @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
@endsection

@section('content')

    @component('common-components.skote.breadcrumb')
        @slot('title') Device @endslot
        @slot('li_1') Iot @endslot
        @slot('li_2') Device @endslot
    @endcomponent

    
    @include('common-components.skote.alert-info-n-error')

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="device-iot-datatable-index">
                        <thead>
                            <tr align="center">
                                <td>Id</td>
                                <td>Device Name</td>
                                <td>Device Key</td>
                                <td width="150px">Status Active</td>
                                <td>Group</td>
                                <td width="150px">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/iot/device/datatable/index.js') }}"></script> 
@endsection