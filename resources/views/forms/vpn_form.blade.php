<style>
.form-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 13px;
}

.form-table td,
.form-table th {
    border: 1px solid #000;
    padding: 4px 8px;
    vertical-align: middle;
}

.section-header {
    background-color: #d9e1f2;
    font-weight: bold;
    text-transform: uppercase;
}

.form-table input[type="text"],
aa .form-table input[type="date"] {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
}

.form-table input[type="text"]:focus,
.form-table input[type="date"]:focus {
    background-color: #f0f8ff;
}

.header-title {
    text-align: center;
    font-weight: bold;
}

.underline-input {
    border: none;
    border-bottom: 1px solid #000;
    outline: none;
    background: transparent;
}
</style>

<div class="modal fade" id="vpnRequestModal" tabindex="-1" aria-labelledby="vpnRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vpnRequestModalLabel">VPN Access Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- HEADER SECTION -->
                <div class="header-title mb-3">
                    <h3 class="fw-bold mb-1" style="font-size: 18px;">VPN ACCESS REQUEST FORM</h3>
                    <h5 class="fw-bold mb-3" style="font-size: 14px;">INFORMATION SYSTEMS SECTION (ISS)</h5>
                </div>

                <form id="vpn_form">
                    @csrf
                    <div class="d-flex justify-content-between mb-2 fw-bold" style="font-size: 13px;">
                        <div>Control No.: <span class="fw-normal" id="vpn_control_no">{{ $vpnControlNo }}</span></div>
                        <div>Date of Request: <input type="date" name="date_now" id="date_now" class="underline-input" style="width: 150px;" disabled></div>
                    </div>
                    <table class="form-table mb-0">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <!-- A. REQUESTOR INFORMATION -->
                        <tr>
                            <td colspan="4" class="section-header">A. REQUESTOR INFORMATION</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Employee No.</td>
                            <td class="p-1">
                                <input type="text" name="employee_no" id="employee_no" class="border-0 bg-transparent">
                            </td>
                            <td class="fw-bold">Employee Name</td>
                            <td class="p-1 bg-secondary bg-opacity-25">
                                <input type="text" name="employee_name" id="employee_name" class="border-0 bg-transparent" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Department / Section</td>
                            <td class="p-1 bg-secondary bg-opacity-25">
                                <input type="text" name="department" id="department" class="border-0 bg-transparent" readonly>
                            </td>
                            <td class="fw-bold">Position</td>
                            <td class="p-1 bg-secondary bg-opacity-25">
                                <input type="text" name="position" id="position" class="border-0 bg-transparent" readonly>
                            </td>
                        </tr>
                    </table>

                    <table class="form-table mb-0">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <tr>
                            <td colspan="4" class="section-header">B. VPN ACCESS DETAILS</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Type of Request</td>
                            <td colspan="3">
                                <label class="me-3"><input type="checkbox" name="request_type" value="New Access" class="type_request"> New Access</label>
                                <label><input type="checkbox" name="request_type" value="Extension" class="type_request"> Extension</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Purpose / Business Justification</td>
                            <td colspan="3" style="height: 40px;">
                                <input type="text" name="purpose" id="purpose">
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Required Access Period</td>
                            <td>
                                <div class="d-flex mb-1">
                                    <div style="width: 50px">
                                        From:
                                    </div>
                                    <input type="date" name="date_from" id="date_from" class="underline-input" style="width: 100%">
                                </div>
                                <div class="d-flex">
                                    <div style="width: 50px">
                                        To:
                                    </div>
                                    <input type="date" name="date_to" id="date_to" class="underline-input" style="width: 100%">
                                </div>
                            </td>

                            <td class="fw-bold">Access Location</td>
                            <td>
                                <label class="me-3">
                                    <input type="checkbox" name="location" value="Home" class="access_location"> Home
                                </label>
                                <label class="me-3">
                                    <input type="checkbox" name="location" value="Business Trip" class="access_location"> Business Trip
                                </label>
                                <label><input type="checkbox" id="access_location_other" name="location" value="Other" class="access_location"> Other:
                                </label>
                                <input type="text" id="location_other" class="underline-input d-inline-block ms-1" style="width: 100%;" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Device Name</td>
                            <td>
                                <input type="text" name="device_name" id="device_name">
                            </td>
                            <td class="fw-bold">Asset Tag</td>
                            <td>
                                <input type="text" name="asset_tag" id="asset_tag">
                            </td>
                        </tr>
                    </table>

                    <table class="form-table mb-0">
                        <tr>
                            <td colspan="4" class="section-header">C. REQUESTOR'S ACKNOWLEDGMENT</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: justify; padding: 8px;">
                                I understand that VPN access is provided only for authorized business purposes. I agree
                                to comply
                                with company IT security policies, protect my login credentials and MFA token, and
                                report any
                                suspicious activity or unauthorized access immediately to ISS. I understand that VPN
                                access may be
                                restricted, monitored, suspended, or revoked in accordance with company policies.
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Requestor's Signature</td>
                            <td class="p-0 text-center">
                                <img id="requestor_sign" class="d-none mx-auto" style="max-height: 50px;" alt="Signature">
                            </td>
                            <td class="fw-bold">Date</td>
                            <td><input type="date" name="date_today" id="date_today" class="underline-input" style="width: 100%" disabled></td>
                        </tr>
                    </table>

                    <table class="form-table mb-0">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="35%">
                            <col width="15%">
                        </colgroup>
                        <tr>
                            <td colspan="4" class="section-header">D. APPROVAL</td>
                        </tr>
                        <tr class="fw-bold" style="background-color: #f2f2f2;">
                            <td>Approver</td>
                            <td>Name / Signature</td>
                            <td>Date &amp; Remarks</td>
                            <td>Status</td>
                        </tr>
                        <tr>
                            <td class="fw-bold py-3">IT Manager</td>
                            <td class="text-center py-1">
                                <div class="d-flex flex-column">
                                    <div>
                                        <img id="appr_iss_manager_sign" class="d-none mx-auto" style="max-height: 50px;" alt="Signature">
                                    </div>
                                    <div>
                                        Janessa G. Sulit
                                    </div>
                                </div>
                            </td>
                            <td class="py-3" id="appr_iss_manager_info"></td>
                            <td class="py-3" id="appr_iss_manager_status"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold py-3">Asst. Vice President</td>
                            <td class="text-center py-1">
                                <div class="d-flex flex-column">
                                    <div>
                                        <img id="appr_admin_avp_sign" class="d-none mx-auto" style="max-height: 50px;" alt="Signature">
                                    </div>
                                    <div>
                                        Evangeline S. Molina
                                    </div>
                                </div>
                            </td>
                            <td class="py-3" id="appr_admin_avp_info"></td>
                            <td class="py-3" id="appr_admin_avp_status"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold py-3">President</td>
                            <td class="text-center py-1">
                                <div class="d-flex flex-column">
                                    <div>
                                        <img id="appr_admin_president_sign" class="d-none mx-auto" style="max-height: 50px;" alt="Signature">
                                    </div>
                                    <div>
                                        Joel C. Padullo
                                    </div>
                                </div>
                            </td>
                            <td class="py-3" id="appr_admin_president_info"></td>
                            <td class="py-3" id="appr_admin_president_status"></td>
                        </tr>
                    </table>

                    <table class="form-table mb-0">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <tr>
                            <td colspan="4" style="background-color: #819bd3">E. ISS USE ONLY</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">VPN Access Status</td>
                            <td>
                                <label class="me-2"><input type="checkbox" class="vpn_access_status" value="Approved" disabled> Approved</label>
                                <label class="me-2"><input type="checkbox" class="vpn_access_status" value="Rejected" disabled> Rejected</label>
                                Remarks:
                            </td>
                            <td class="fw-bold">Date Activated</td>
                            <td><input type="date" id="iss_activation_date" class="underline-input" style="width: 100%" disabled></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">FortiClient VPN Installed</td>
                            <td>
                                <label class="me-2"><input type="checkbox" class="forticlient_vpn_installed" value="Yes" disabled> Yes</label>
                                <label class="me-2"><input type="checkbox" class="forticlient_vpn_installed" value="No" disabled> No</label>
                                <label><input type="checkbox" class="forticlient_vpn_installed" value="N/A" disabled> N/A</label>
                            </td>
                            <td class="fw-bold">Expiration / Review Date</td>
                            <td><input type="date" id="iss_expiration_date" class="underline-input" style="width: 100%" disabled></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">FortiToken Mobile / MFA Configured</td>
                            <td>
                                <label class="me-2"><input type="checkbox" class="fortitoken_mobile_mfa_configured" value="Yes" disabled> Yes</label>
                                <label class="me-2"><input type="checkbox" class="fortitoken_mobile_mfa_configured" value="No" disabled> No</label>
                                <label><input type="checkbox" class="fortitoken_mobile_mfa_configured" value="N/A" disabled> N/A</label>
                            </td>
                            <td class="fw-bold" rowspan="2">Remarks</td>
                            <td rowspan="2"><input type="text" id="iss_remarks" maxlength="255" disabled></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">VPN User Account Created / Updated</td>
                            <td>
                                <label class="me-2"><input type="checkbox" class="vpn_user_account_created" value="Yes" disabled> Yes</label>
                                <label><input type="checkbox" class="vpn_user_account_created" value="No" disabled> No</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Access Restrictions Applied</td>
                            <td>
                                <label class="me-2"><input type="checkbox" class="access_restrictions_applied" value="Yes" disabled> Yes</label>
                                <label><input type="checkbox" class="access_restrictions_applied" value="No" disabled> No</label>
                            </td>
                            <td class="fw-bold">Prepared By</td>
                            <td><input type="text" id="iss_prepared_by" maxlength="255" disabled></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Approved Access Schedule</td>
                            <td>Until 12AM only (For Local Managers)</td>
                            <td class="fw-bold">Date Completed</td>
                            <td><input type="date" id="iss_date_completed" class="underline-input" style="width: 100%" disabled></td>
                        </tr>
                    </table>

                    <table class="form-table mb-0">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <tr>
                            <td colspan="4" style="background-color: #819bd3">F. ACCESS CLOSURE</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Reason for Revocation</td>
                            <td>
                                <div><label><input type="checkbox" class="revocation_reason" disabled> End of Access Period</label></div>
                                <div><label><input type="checkbox" class="revocation_reason" disabled> No Longer Required</label></div>
                            </td>
                            <td class="fw-bold">Revoked By</td>
                            <td><input type="text" disabled></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Date Access Revoked</td>
                            <td><input type="date" class="underline-input" style="width: 100%" disabled></td>
                            <td class="fw-bold">Verified By</td>
                            <td><input type="text" disabled></td>
                        </tr>
                    </table>

                    <!-- FOOTER NOTE -->
                    <p class="mt-2" style="font-size: 15px; text-align: justify;">
                        <strong>Note:</strong> VPN access shall only be activated upon completion of the required
                        approvals and ISS
                        security checks. Access duration and restrictions must follow applicable company IT security
                        policies.
                    </p>

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="vpn_save_btn" class="btn bg-success text-white fw-bold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    const today = new Date().toISOString().split('T')[0];
  
    // Set the default date values for the date inputs
    $('#date_now').val(today);
    $('#date_today').val(today);

    $('#vpn_form').on('submit', function(event) {
        event.preventDefault();

        // hardware page: the form is read-only except the ISS Use Only part
        if (issMode) {
            saveIssDetails();
            return;
        }

        let $form = $(this);

        let formData = $form.serializeArray();
        let locationOtherVal = $('#location_other').val().trim();
        $.each(formData, function(i, field) {
            if (field.name === 'location' && $('#access_location_other').is(':checked') && locationOtherVal !== '') {
                field.value = locationOtherVal;
            }
        });

        $.ajax({
            url: "{{ route('forms.vpn.store') }}",
            method: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(response) {
                // control no for the next new request
                newControlNo = response.next_control_no;

                if ($.fn.DataTable.isDataTable('#vpnTable')) {
                    $('#vpnTable').DataTable().ajax.reload(null, false);
                }

                // show the saved request in the read-only view, with a small toast at the top right
                showVpnDetails(response.id);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'VPN request saved',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            },
            error: function(xhr) { // <--- Pwede mo rin ilagay ang error dito para mas malinis
                let message = 'Unable to save the VPN request. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const firstError = Object.keys(xhr.responseJSON.errors)[0];
                    message = xhr.responseJSON.errors[firstError][0];
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Unable to save request',
                    text: message
                });
            }
        });
    });

    $('#employee_no').on('keydown', function(event) {
        if (event.key !== 'Enter') {
            return;
        }

        event.preventDefault();

        const employeeNo = $(this).val().trim();
        const $employeeName = $('#employee_name');
        const $department = $('#department');
        const $position = $('#position');

        // Linisin muna ang mga fields bago mag-request
        $employeeName.val('');
        $department.val('');
        $position.val('');

        if (employeeNo === '') {
            return; // Huwag ituloy kung blangko ang input
        }

        $.ajax({
            url: '{{ route("employee.details") }}',
            type: 'GET',
            dataType: 'json',
            data: {
                employee_no: employeeNo
            },
            success: function(employee) {
                // Siguraduhing may naibalik na data o employee
                if (employee && employee.employee_name) {
                    $employeeName.val(employee.employee_name);
                    $position.val(employee.position);

                    // Salain ang department at section para tanggalin ang empty, null, o literal na "-"
                    const deptDetails = [employee.department, employee.section].filter(
                        function(val) {
                            return val && val.trim() !== '' && val.trim() !== '-';
                        });

                    // Pagsamahin gamit ang comma at space, o maglagay ng "-" kung walang natira
                    const finalDeptText = deptDetails.length > 0 ? deptDetails.join(', ') :
                        '-';
                    $department.val(finalDeptText);
                } else {
                    // Kung walang nahanap sa database
                    $department.val('');
                }
            },
            error: function(xhr, status, error) {
                $department.val('');

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'User not found!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        });
    });

    //for inputting other location
    $('.access_location').on('change', function() {
        $('.access_location').not(this).prop('checked', false);
        
        let isOther = (this.value === 'Other' && this.checked);
        $('#location_other').prop('disabled', !isOther);

        if (!isOther) {
            $('#location_other').val('');
            $('#access_location_other').val('Other');
        }
    });

    $('#location_other').on('input', function() {
        $('#access_location_other').val($(this).val());
    });
    //

    $('.type_request').on('change', function() {
        $('.type_request').not(this).prop('checked', false);
    });
    
    $('.vpn_access_status').on('change', function() {
        $('.vpn_access_status').not(this).prop('checked', false);
    });

    $('.forticlient_vpn_installed').on('change', function() {
        $('.forticlient_vpn_installed').not(this).prop('checked', false);
    });

    $('.fortitoken_mobile_mfa_configured').on('change', function() {
        $('.fortitoken_mobile_mfa_configured').not(this).prop('checked', false);
    });

    $('.vpn_user_account_created').on('change', function() {
        $('.vpn_user_account_created').not(this).prop('checked', false);
    });

    $('.access_restrictions_applied').on('change', function() {
        $('.access_restrictions_applied').not(this).prop('checked', false);
    });

    $('.revocation_reason').on('change', function() {
        $('.revocation_reason').not(this).prop('checked', false);
    });

    // ---- View VPN Request Details ----
    let newControlNo = $('#vpn_control_no').text();
    let currentVpnId = null;

    // true on the Hardware Requests page, where "E. ISS USE ONLY" is editable
    const issMode = @json($issMode ?? false);
    const issFields = '.vpn_access_status, .forticlient_vpn_installed, .fortitoken_mobile_mfa_configured, '
        + '.vpn_user_account_created, .access_restrictions_applied, #iss_activation_date, #iss_expiration_date, '
        + '#iss_remarks, #iss_date_completed';

    // Prepared By is filled with the logged-in hardware employee and stays read-only
    const issPreparedBy = @json($_SESSION['rapidx_name'] ?? '');

    function setIssChecked(selector, value) {
        $(selector).prop('checked', function() { return !!value && this.value === value; });
    }

    function fillIssDetails(iss) {
        setIssChecked('.vpn_access_status', iss.vpn_access_status);
        setIssChecked('.forticlient_vpn_installed', iss.forticlient_vpn_installed);
        setIssChecked('.fortitoken_mobile_mfa_configured', iss.fortitoken_mobile_mfa_configured);
        setIssChecked('.vpn_user_account_created', iss.vpn_user_account_created);
        setIssChecked('.access_restrictions_applied', iss.access_restrictions_applied);

        $('#iss_activation_date').val(iss.activation_date || '');
        $('#iss_expiration_date').val(iss.expiration_date || '');
        $('#iss_remarks').val(iss.remarks || '');
        $('#iss_prepared_by').val(iss.prepared_by || (issMode ? issPreparedBy : ''));
        $('#iss_date_completed').val(iss.date_completed || '');
    }

    function saveIssDetails() {
        const checked = function(selector) { return $(selector + ':checked').val() || ''; };

        $.ajax({
            url: "{{ route('hardware.vpn.update', ':id') }}".replace(':id', currentVpnId),
            method: 'POST',
            dataType: 'json',
            data: {
                _token: $('#vpn_form input[name="_token"]').val(),
                vpn_access_status: checked('.vpn_access_status'),
                forticlient_vpn_installed: checked('.forticlient_vpn_installed'),
                fortitoken_mobile_mfa_configured: checked('.fortitoken_mobile_mfa_configured'),
                vpn_user_account_created: checked('.vpn_user_account_created'),
                access_restrictions_applied: checked('.access_restrictions_applied'),
                activation_date: $('#iss_activation_date').val(),
                expiration_date: $('#iss_expiration_date').val(),
                remarks: $('#iss_remarks').val(),
                date_completed: $('#iss_date_completed').val()
            },
            success: function() {
                $('#vpnRequestModal').modal('hide');

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'ISS details saved',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            },
            error: function(xhr) {
                let message = 'Unable to save the ISS details. Please try again.';
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
    }
    const editableFields = '#employee_no, #purpose, #date_from, #date_to, #device_name, #asset_tag, .type_request, .access_location';
    const statusLabels = {
        2: '<span>Approved</span>',
        3: '<span>Disapproved</span>'
    };

    function resetVpnModal() {
        $('#vpn_form')[0].reset();
        $('#vpnRequestModalLabel').text('VPN Access Request');
        $('#vpn_control_no').text(newControlNo);
        $(editableFields).prop('disabled', false);
        $('#location_other').prop('disabled', true).val('');
        $(issFields).prop('disabled', true);
        $('#vpn_save_btn').show();
        $('#date_now, #date_today').val(today);
        $('[id^="appr_"]:not(img)').empty();
        $('#requestor_sign, img[id^="appr_"]').addClass('d-none').removeAttr('src');
    }

    $('#vpnRequestModal').on('hidden.bs.modal', resetVpnModal);

    $(document).on('click', '.viewVpnRequestDetails', function() {
        showVpnDetails($(this).data('id'));
    });

    function showVpnDetails(id) {
        $.ajax({
            url: "{{ route('forms.vpn.show', ':id') }}".replace(':id', id),
            method: 'GET',
            dataType: 'json',
            success: function(vpn) {
                resetVpnModal();

                $('#vpnRequestModalLabel').text('VPN Access Request Details');
                $('#vpn_control_no').text(vpn.control_no);
                $('#date_now, #date_today').val(vpn.date_requested);

                $('#employee_no').val(vpn.emp_no);
                $('#employee_name').val(vpn.name);
                $('#department').val(vpn.department_section);
                $('#position').val(vpn.position);

                $('.type_request').prop('checked', function() { return this.value === vpn.type_of_request; });
                $('#purpose').val(vpn.purpose);
                $('#date_from').val(vpn.date_from);
                $('#date_to').val(vpn.date_to);

                const knownLocation = ['Home', 'Business Trip'].includes(vpn.access_location);
                $('.access_location').prop('checked', function() {
                    return knownLocation ? this.value === vpn.access_location : this.value === 'Other';
                });
                $('#location_other').val(knownLocation ? '' : vpn.access_location);

                $('#device_name').val(vpn.device_name);
                $('#asset_tag').val(vpn.asset_tag);

                $.each(vpn.approvals, function(stage, approval) {
                    const info = [approval.date, approval.remarks].filter(Boolean).join(' - ');
                    $('#appr_' + stage + '_info').text(info);
                    $('#appr_' + stage + '_status').html(statusLabels[approval.status] || '');

                    if (approval.signature) {
                        $('#appr_' + stage + '_sign').attr('src', approval.signature).removeClass('d-none');
                    }
                });

                if (vpn.requestor_signature) {
                    $('#requestor_sign').attr('src', vpn.requestor_signature).removeClass('d-none');
                }

                $(editableFields).prop('disabled', true);
                $('#vpn_save_btn').hide();

                currentVpnId = id;

                // the requestor sees the ISS Use Only part once hardware has saved it;
                // hardware employees can edit it only until then
                fillIssDetails(vpn.iss_details || {});

                if (issMode && !vpn.iss_locked) {
                    $(issFields).prop('disabled', false);
                    $('#vpn_save_btn').show();
                }

                $('#vpnRequestModal').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Unable to load request details'
                });
            }
        });
    }

});
</script>