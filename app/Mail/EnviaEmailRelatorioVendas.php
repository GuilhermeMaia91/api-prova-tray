<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaEmailRelatorioVendas extends Mailable
{
    use Queueable, SerializesModels;

    protected $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $info)
    {
        $this->data = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.envia_pedido')->with('email', $this->data);
    }
}
