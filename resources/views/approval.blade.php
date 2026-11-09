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
                                        <h1 class="mb-0 fs-3">Approval</h1>
                                    </div>
                                </div>

                                <div class="tab-content pt-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

                                        <div class="table-responsive">
                                            <table id="approvalTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Control No</th>
                                                        <th>Request</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="approvalModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="approvalRemarks" class="form-label fw-bold">Remarks</label>
                                        <textarea id="approvalRemarks" class="form-control" rows="3" maxlength="255"></textarea>
                                        <div class="invalid-feedback">Remarks is required when disapproving.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn" id="approvalConfirm">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </main>
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {

            $('#approvalTable').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('approval.list') }}",
                order: [[0, 'desc']],
                columns: [
                    { data: 'control_no', name: 'control_no' },
                    { data: 'request', name: 'request', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });

            let approvalId = null;
            let approvalAction = null;

            $(document).on('click', '.approvalAction', function() {
                approvalId = $(this).data('id');
                approvalAction = $(this).data('action');
                const isApprove = approvalAction === 'approve';

                $('#approvalModalLabel').text((isApprove ? 'Approve ' : 'Disapprove ') + $(this).data('control-no'));
                $('#approvalConfirm')
                    .text(isApprove ? 'Approve' : 'Disapprove')
                    .toggleClass('btn-primary', isApprove)
                    .toggleClass('btn-danger', !isApprove);
                $('#approvalRemarks').val('').removeClass('is-invalid');

                $('#approvalModal').modal('show');
            });

            $('#approvalConfirm').on('click', function() {
                const remarks = $('#approvalRemarks').val().trim();

                if (approvalAction === 'disapprove' && remarks === '') {
                    $('#approvalRemarks').addClass('is-invalid');
                    return;
                }

                $.ajax({
                    url: "{{ route('approval.vpn.action') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: approvalId,
                        action: approvalAction,
                        remarks: remarks
                    },
                    success: function() {
                        $('#approvalModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: approvalAction === 'approve' ? 'Request approved' : 'Request disapproved',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let message = 'Unable to save your decision. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            message = xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Unable to save',
                            text: message
                        });
                    }
                });
            });

        });
    </script>
@endsection