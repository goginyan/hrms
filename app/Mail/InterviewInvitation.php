<?php

namespace App\Mail;

use App\Models\Interview;
use App\Models\Setting;
use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Setting
     */
    public $settings;

    /**
     * @var Vacancy
     */
    public $vacancy;

    /**
     * @var Interview
     */
    public $interview;

    /**
     * @var boolean
     */
    public $isMember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Interview $interview, $isMember = false)
    {
        $this->interview = $interview;
        $this->vacancy   = $interview->vacancy;
        $this->settings  = Setting::find(1);
        $this->isMember  = $isMember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->settings->mail_from, $this->settings->mail_name)->view('email.interview.invitation');
    }
}
