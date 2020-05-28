<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

/**
 * App\Models\JobApplicant
 *
 * @property int                                                              $id
 * @property string|null                                                      $first_name
 * @property string|null                                                      $last_name
 * @property string|null                                                      $photo
 * @property string|null                                                      $patronymic
 * @property string|null                                                      $sex
 * @property string|null                                                      $family_status
 * @property string|null                                                      $nationality
 * @property string|null                                                      $phone
 * @property string|null                                                      $address
 * @property string|null                                                      $email
 * @property string|null                                                      $education
 * @property string|null                                                      $work_experience
 * @property string|null                                                      $achievements
 * @property string|null                                                      $certificates
 * @property string|null                                                      $skills
 * @property string|null                                                      $languages
 * @property string|null                                                      $interests
 * @property string|null                                                      $attach_cv
 * @property int                                                              $vacancy_id
 * @property Carbon|null                                                      $created_at
 * @property Carbon|null                                                      $updated_at
 * @property Carbon|null                                                      $deleted_at
 * @property-read Vacancy                                                     $vacancy
 * @method static bool|null forceDelete()
 * @method static Builder|JobApplicant newModelQuery()
 * @method static Builder|JobApplicant newQuery()
 * @method static \Illuminate\Database\Query\Builder|JobApplicant onlyTrashed()
 * @method static Builder|JobApplicant query()
 * @method static bool|null restore()
 * @method static Builder|JobApplicant whereAchievements($value)
 * @method static Builder|JobApplicant whereAddress($value)
 * @method static Builder|JobApplicant whereAttachCv($value)
 * @method static Builder|JobApplicant whereCertificates($value)
 * @method static Builder|JobApplicant whereCreatedAt($value)
 * @method static Builder|JobApplicant whereDeletedAt($value)
 * @method static Builder|JobApplicant whereEducation($value)
 * @method static Builder|JobApplicant whereEmail($value)
 * @method static Builder|JobApplicant whereFamilyStatus($value)
 * @method static Builder|JobApplicant whereFirstName($value)
 * @method static Builder|JobApplicant whereId($value)
 * @method static Builder|JobApplicant whereInterests($value)
 * @method static Builder|JobApplicant whereJobId($value)
 * @method static Builder|JobApplicant whereLanguages($value)
 * @method static Builder|JobApplicant whereLastName($value)
 * @method static Builder|JobApplicant whereNationality($value)
 * @method static Builder|JobApplicant wherePatronymic($value)
 * @method static Builder|JobApplicant wherePhone($value)
 * @method static Builder|JobApplicant wherePhoto($value)
 * @method static Builder|JobApplicant whereSex($value)
 * @method static Builder|JobApplicant whereSkills($value)
 * @method static Builder|JobApplicant whereUpdatedAt($value)
 * @method static Builder|JobApplicant whereWorkExperience($value)
 * @method static \Illuminate\Database\Query\Builder|JobApplicant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|JobApplicant withoutTrashed()
 * @mixin Eloquent
 * @property string|null                                                      $cover_letter
 * @property string|null                                                      $linked_in
 * @method static Builder|JobApplicant whereCoverLetter($value)
 * @method static Builder|JobApplicant whereLinkedIn($value)
 * @property string                                                           $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobApplicant whereStatus($value)
 * @property int                                                              $job_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobApplicant whereVacancyId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[] $quizzes
 * @property-read int|null                                                    $quizzes_count
 */
class JobApplicant extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'sex',
        'family_status',
        'nationality',
        'phone',
        'address',
        'email',
        'education',
        'work_experience',
        'achievements',
        'certificates',
        'skills',
        'languages',
        'interests',
        'linked_in',
    ];

    /**
     * Statuses of the applicant
     *
     * @var array
     */
    public static $statuses = [
        'applicant'     => 'Applicant',
        'candidate'     => 'Candidate',
        'invited'       => 'Invited',
        'pending'       => 'Pending',
        'intern'        => 'Intern',
        'inappropriate' => 'Inappropriate'
    ];

    /**
     * Update attachments of the applicant
     *
     * @param Request $request
     *
     * @return bool
     */
    public function updateAttachments(Request $request)
    {
        $photo = $request->file('photo');
        if ($photo) {
            $ext  = $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/applicants/images/' . $this->id, "photo.$ext");

            $newPath     = str_replace('public/', 'storage/', $path);
            $this->photo = asset($newPath);
        }
        $attach_cv = $request->file('attach_cv');
        if ($attach_cv) {
            $ext  = $attach_cv->getClientOriginalExtension();
            $path = $attach_cv->storeAs('public/applicants/cv/' . $this->id, "cv.$ext");

            $newPath         = str_replace('public/', 'storage/', $path);
            $this->attach_cv = asset($newPath);
        }
        $cover_letter = $request->file('cover_letter');
        if ($cover_letter) {
            $ext  = $cover_letter->getClientOriginalExtension();
            $path = $cover_letter->storeAs('public/applicants/cover_letters/' . $this->id, "letter.$ext");

            $newPath            = str_replace('public/', 'storage/', $path);
            $this->cover_letter = asset($newPath);
        }

        return $this->save();
    }

    /**
     * Get the vacancy for which applicant apply
     *
     * @return BelongsTo
     */
    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }

    /**
     * Get the quizzes attached to the applicant
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function quizzes()
    {
        return $this->morphToMany('App\Models\Quiz', 'quizable')->withPivot(['result', 'token']);
    }
}
