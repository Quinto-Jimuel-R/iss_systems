<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VpnRequestApproved extends Mailable
{
    public $vpnForm;
    public $approverRole;
    public $approverName;
    public $completed;

    public function __construct($vpnForm, $approverRole, $approverName, $completed)
    {
        $this->vpnForm = $vpnForm;
        $this->approverRole = $approverRole;
        $this->approverName = $approverName;
        $this->completed = $completed;
    }

    public function build()
    {
        return $this->subject('VPN Access Request Approved by ' . $this->approverRole . ': ' . $this->vpnForm->control_no)
            ->view('emails.vpn_request_approved');
    }
}
