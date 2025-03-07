<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Scalar\String_;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public String_ $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build(): UserRegisteredMail
    {
        return $this->subject('Welcome to Our Platform')
            ->view('emails.user_registered') // Custom Blade template
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email
            ]);
    }
}
