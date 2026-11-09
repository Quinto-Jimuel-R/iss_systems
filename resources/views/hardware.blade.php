@php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $layout = 'layouts.layout';
  
@endphp

@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
    <main class="app-main" id="main" tabindex="-1">

                        <div class="app-content-header">

                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="mb-0 fs-3">Hardware Requests</h1>
                                    </div>
                                </div>

                                <div class="pt-3">
                                    <div class="table-responsive">
                                        <table id="hardwareTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Control No</th>
                                                    <th>Requestor</th>
                                                    <th>Request</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                        @include('forms.vpn_form', ['issMode' => true, 'vpnControlNo' => ''])

                    </main>
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {
            $('#hardwareTable').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('hardware.list') }}",
                order: [[0, 'desc']],
                columns: [
                    { data: 'control_no', name: 'control_no' },
                    { data: 'name', name: 'name' },
                    { data: 'request', name: 'request', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endsection