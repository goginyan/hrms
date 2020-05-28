<?php

namespace App\Models;

use App\Mail\InterviewInvitation;
use App\Notifications\InterviewPlanned;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Mail;

/**
 * App\Models\Interview
 *
 * @property-read \App\Models\JobApplicant                                        $applicant
 * @property-read \App\Models\Vacancy                                             $vacancy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $members
 * @property-read int|null                                                        $members_count
 * @property-read \App\Models\Employee                                            $organizer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview query()
 * @mixin \Eloquent
 * @property int                                                                  $id
 * @property \Illuminate\Support\Carbon                                           $planned_at
 * @property int|null                                                             $organizer_id
 * @property int                                                                  $vacancy_id
 * @property int                                                                  $applicant_id
 * @property string|null                                                          $comment
 * @property string                                                               $status
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereOrganizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview wherePlannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereUpdatedAt($value)
 * @property int                                                                  $job_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interview whereVacancyId($value)
 */
class Interview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'planned_at',
        'comment',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'planned_at',
    ];

    /**
     * Statuses of the interview
     *
     * @var array
     */
    public static $statuses = [
        'active'  => 'Active',
        'pending' => 'Pending',
        'done'    => 'Done',
    ];

    /**
     * Get the organizer of the interview
     *
     * @return BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the vacancy for which was created interview
     *
     * @return BelongsTo
     */
    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }

    /**
     * Get the applicant of the interview
     *
     * @return BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo('App\Models\JobApplicant');
    }


    /**
     * Get the members/employees of the interview
     *
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\Employee', 'employee_interview', 'interview_id', 'employee_id');
    }

    /**
     * Send notify mails and notification to candidate and members of interview
     */
    public function notifyAll()
    {
        if ($this->applicant->email) {
            Mail::to($this->applicant->email)->send(new InterviewInvitation($this));
            if (env('MAIL_HOST', false) === 'smtp.mailtrap.io') {
                sleep(3);
            }
        }
        foreach ($this->members as $member) {
            $user = $member->user;
            $user->notify(new InterviewPlanned($this));
            Mail::to($user)->send(new InterviewInvitation($this, true));
            if (env('MAIL_HOST', false) === 'smtp.mailtrap.io') {
                sleep(7);
            }
        }
    }
}
