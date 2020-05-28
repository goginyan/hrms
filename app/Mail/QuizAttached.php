<?php

namespace App\Mail;

use App\Models\Quiz;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizAttached extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Setting
     */
    public $settings;

    /**
     * @var Quiz
     */
    public $quiz;

    /**
     * @var string
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Quiz $quiz, $token)
    {
        $this->settings = Setting::find(1);
        $this->quiz     = $quiz;
        $this->token    = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->settings->mail_from, $this->settings->mail_name)
                    ->view('email.quizAttached');
    }
}
