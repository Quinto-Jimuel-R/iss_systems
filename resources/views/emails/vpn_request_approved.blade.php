<div style="font-family: Arial, sans-serif; font-size: 14px;">
    <p>Hello {{ $vpnForm->name }},</p>

    <p>Your request <strong>{{ $vpnForm->control_no }}</strong> is approved by the {{ $approverRole }}{{ $approverName ? ' ' . $approverName : '' }}.</p>

    @if ($completed)
        <p>Your request has been forwarded to ISS Hardware.</p>
    @else
        <p>It has been forwarded to the next approver.</p>
    @endif

    <p style="color: #777;">This is an automated message from the ISS system. Please do not reply.</p>
</div>
