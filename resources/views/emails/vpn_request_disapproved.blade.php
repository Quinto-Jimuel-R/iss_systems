<div style="font-family: Arial, sans-serif; font-size: 14px;">
    <p>Hello {{ $vpnForm->name }},</p>

    <p>Your VPN Access Request <strong>{{ $vpnForm->control_no }}</strong> was disapproved{{ $disapprovedBy ? ' by ' . $disapprovedBy : '' }}.</p>

    <p><strong>Remarks:</strong> {{ $remarks ?: 'None' }}</p>

    <p>You may submit a new request with the necessary corrections.</p>

    <p style="color: #777;">This is an automated message from the ISS system. Please do not reply.</p>
</div>