<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VpnRequestDisapproved extends Mailable
{
    public $vpnForm;
    public $disapprovedBy;
    public $remarks;

    public function __construct($vpnForm, $disapprovedBy, $remarks)
    {
        $this->vpnForm = $vpnForm;
        $this->disapprovedBy = $disapprovedBy;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->subject('VPN Access Request Disapproved: ' . $this->vpnForm->control_no)
            ->view('emails.vpn_request_disapproved');
    }
}
