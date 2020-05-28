<?php

namespace App\Mail;

use App\Models\Vacancy;
use App\Models\JobApplicant;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplicationForm extends Mailable
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
     * @var JobApplicant
     */
    public $applicant;

    /**
     * Create a new message instance.
     *
     * @param JobApplicant $applicant
     */
    public function __construct(JobApplicant $applicant)
    {
        $this->settings  = Setting::find(1);
        $this->vacancy   = $applicant->vacancy;
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->settings->mail_from, $this->settings->mail_name)
                    ->view('email.jobApplicationForm');
    }
}
