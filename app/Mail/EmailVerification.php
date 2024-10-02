<?php

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
use SerializesModels;

public $user;

public function __construct($user)
{
$this->user = $user;
}

public function build()
{
return $this->view('emails.email-verification')
->subject('Email Verification');
}
}
