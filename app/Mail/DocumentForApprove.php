<?php

namespace App\Mail;

use App\Models\Document;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentForApprove extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Document
     */
    public $document;

    /**
     * @var Setting
     */
    public $settings;

    /**
     * Create a new message instance.
     *
     * @param Document $document
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->settings = Setting::find(1);
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->settings->mail_from, $this->settings->mail_name)
                    ->view('email.documentForApprove');
    }
}
