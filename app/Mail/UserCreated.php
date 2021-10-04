<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * TODO se usa para enviar por correo al usuario
 * Class UserCreated
 * @package App\Mail
 */
class UserCreated extends Mailable
{
    use Queueable, SerializesModels;
    //TODO variable que se usa en la plantilla del email que se envia al usuario
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
       // return $this->text('email.welcome')->subject('Por favor confirma tu correo electronico');
        return $this->markdown('email.welcome')->subject('Por favor confirma tu correo electronico');
    }
}
