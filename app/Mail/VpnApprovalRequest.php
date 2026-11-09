<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VpnApprovalRequest extends Mailable
{
    public $vpnForm;
    public $approverName;

    public function __construct($vpnForm, $approverName)
    {
        $this->vpnForm = $vpnForm;
        $this->approverName = $approverName;
    }

    public function build()
    {
        return $this->subject('VPN Access Request for Approval: ' . $this->vpnForm->control_no)
            ->view('emails.vpn_approval_request');
    }
}
