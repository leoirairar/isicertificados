<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class zipCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$file)
    {
        $this->data = $data;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datas = $this->data;
        $location = storage_path('certificates/'.$this->file);
        $this->view('emails.zipCertificates',compact('datas'))
                ->from('isicertificados@gmail.com', 'ISI Ingeniería')
                ->subject($this->data->subject)
                ->attach(storage_path('/app/certificates/'.$this->file));
                
                // ->attachFromStorage('\app\public\Alturas y bajos.zip');
    }
}
