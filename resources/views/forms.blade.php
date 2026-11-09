@php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $layout = 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Forms')

@section('content_page')
<main class="app-main" id="main" tabindex="-1">

    <div class="app-content-header">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="mb-0 fs-3">Forms</h1>
                </div>

                <div class="d-flex align-items-start flex-column">
                    <div class="d-flex align-items-center gap-2">
                        <span class="bg-warning rounded-circle d-inline-block" style="width: 16px; height: 16px;"></span>
                        <span class="fw-bold text-dark">Pending</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <span class="bg-success rounded-circle d-inline-block" style="width: 16px; height: 16px;"></span>
                        <span class="fw-bold text-dark">Approved</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <span class="bg-danger rounded-circle d-inline-block" style="width: 16px; height: 16px;"></span>
                        <span class="fw-bold text-dark">Disapproved</span>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation Header -->
            <ul class="nav nav-tabs fw-bold mt-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                        type="button" role="tab" aria-controls="tab1" aria-selected="true">
                        VPN Request
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                        role="tab" aria-controls="tab2" aria-selected="false">
                        Email Registration
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button"
                        role="tab" aria-controls="tab3" aria-selected="false">
                        Personal IT Devices Pass Slip
                    </button>
                </li>
            </ul>

            <div class="tab-content pt-3" id="myTabContent">

                <!-- VPN Request Tab -->
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

                    <div class="text-end mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#vpnRequestModal">
                            New VPN Request
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="vpnTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Control No</th>
                                    <th>Approver</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    @include('forms.vpn_form')

                </div>

                <!-- Email Registration Tab -->
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <h3>Tab 2 Content</h3>
                    <p>This is the content for Tab 2.</p>
                </div>

                <!-- Personal IT Devices Pass Slip Tab -->
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                    <h3>Tab 3 Content</h3>
                    <p>This is the content for Tab 3.</p>
                </div>
            </div>

        </div>

    </div>

</main>
@endsection

@section('js_content')
<script>
    $(document).ready(function() {
        $('#vpnTable').DataTable({
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('forms.vpn.list') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'control_no', name: 'control_no' },
                { data: 'approvers', name: 'approvers', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });
    });
</script>
@endsection
