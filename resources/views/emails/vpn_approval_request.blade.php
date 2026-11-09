<div style="font-family: Arial, sans-serif; font-size: 14px;">
    <p>Hello {{ $approverName }},</p>

    <p>You have a pending approval from {{ $vpnForm->name }} for VPN Access Request {{ $vpnForm->control_no }}.</p>

    <table cellpadding="6" style="border-collapse: collapse;">
        <tr><td><strong>Control No.</strong></td><td>{{ $vpnForm->control_no }}</td></tr>
        <tr><td><strong>Requestor</strong></td><td>{{ $vpnForm->name }} ({{ $vpnForm->emp_no }})</td></tr>
        <tr><td><strong>Department / Section</strong></td><td>{{ $vpnForm->department_section }}</td></tr>
        <tr><td><strong>Type of Request</strong></td><td>{{ $vpnForm->type_of_request }}</td></tr>
        <tr><td><strong>Purpose</strong></td><td>{{ $vpnForm->purpose }}</td></tr>
        <tr><td><strong>Access Period</strong></td><td>{{ $vpnForm->date_from }} to {{ $vpnForm->date_to }}</td></tr>
        <tr><td><strong>Access Location</strong></td><td>{{ $vpnForm->access_location }}</td></tr>
    </table>

    <p style="color: #777;">This is an automated message from the ISS system. Please do not reply.</p>
</div>