<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Vacancy
 *
 * @property int                            $id
 * @property string                         $position
 * @property string|null                    $location
 * @property string|null                    $duration
 * @property string|null                    $work_type
 * @property string|null                    $description
 * @property string|null                    $responsibilities
 * @property string|null                    $qualifications
 * @property Carbon                         $open_date
 * @property Carbon                         $end_date
 * @property string|null                    $application_procedure
 * @property int|null                       $contact_person_id
 * @property int|null                       $salary
 * @property string|null                    $salary_currency
 * @property string|null                    $contact_email
 * @property bool                           $with_form
 * @property string|null                    $first_name
 * @property string|null                    $last_name
 * @property string|null                    $photo
 * @property string|null                    $patronymic
 * @property string|null                    $sex
 * @property string|null                    $family_status
 * @property string|null                    $nationality
 * @property string|null                    $phone
 * @property string|null                    $address
 * @property string|null                    $email
 * @property string|null                    $education
 * @property string|null                    $work_experience
 * @property string|null                    $achievements
 * @property string|null                    $certificates
 * @property string|null                    $skills
 * @property string|null                    $languages
 * @property string|null                    $interests
 * @property string|null                    $attach_cv
 * @property Carbon|null                    $created_at
 * @property Carbon|null                    $updated_at
 * @property Carbon|null                    $deleted_at
 * @property bool                           $published
 * @property-read Collection|JobApplicant[] $applicants
 * @property-read int|null                  $applicants_count
 * @property-read Employee|null             $contactPerson
 * @property-read string|null               $contact_person_title
 * @method static bool|null forceDelete()
 * @method static Builder|Vacancy newModelQuery()
 * @method static Builder|Vacancy newQuery()
 * @method static \Illuminate\Database\Query\Builder|Vacancy onlyTrashed()
 * @method static Builder|Vacancy query()
 * @method static bool|null restore()
 * @method static Builder|Vacancy whereAchievements($value)
 * @method static Builder|Vacancy whereAddress($value)
 * @method static Builder|Vacancy whereApplicationProcedure($value)
 * @method static Builder|Vacancy whereAttachCv($value)
 * @method static Builder|Vacancy whereCertificates($value)
 * @method static Builder|Vacancy whereContactEmail($value)
 * @method static Builder|Vacancy whereContactPersonId($value)
 * @method static Builder|Vacancy whereCreatedAt($value)
 * @method static Builder|Vacancy whereDeletedAt($value)
 * @method static Builder|Vacancy whereDescription($value)
 * @method static Builder|Vacancy whereDuration($value)
 * @method static Builder|Vacancy whereEducation($value)
 * @method static Builder|Vacancy whereEmail($value)
 * @method static Builder|Vacancy whereEndDate($value)
 * @method static Builder|Vacancy whereFamilyStatus($value)
 * @method static Builder|Vacancy whereFirstName($value)
 * @method static Builder|Vacancy whereId($value)
 * @method static Builder|Vacancy whereInterests($value)
 * @method static Builder|Vacancy whereLanguages($value)
 * @method static Builder|Vacancy whereLastName($value)
 * @method static Builder|Vacancy whereLocation($value)
 * @method static Builder|Vacancy whereNationality($value)
 * @method static Builder|Vacancy whereOpenDate($value)
 * @method static Builder|Vacancy wherePatronymic($value)
 * @method static Builder|Vacancy wherePhone($value)
 * @method static Builder|Vacancy wherePhoto($value)
 * @method static Builder|Vacancy wherePosition($value)
 * @method static Builder|Vacancy wherePublished($value)
 * @method static Builder|Vacancy whereQualifications($value)
 * @method static Builder|Vacancy whereResponsibilities($value)
 * @method static Builder|Vacancy whereSalary($value)
 * @method static Builder|Vacancy whereSalaryCurrency($value)
 * @method static Builder|Vacancy whereSex($value)
 * @method static Builder|Vacancy whereSkills($value)
 * @method static Builder|Vacancy whereUpdatedAt($value)
 * @method static Builder|Vacancy whereWithForm($value)
 * @method static Builder|Vacancy whereWorkExperience($value)
 * @method static Builder|Vacancy whereWorkType($value)
 * @method static \Illuminate\Database\Query\Builder|Vacancy withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Vacancy withoutTrashed()
 * @mixin Eloquent
 * @property string|null                    $cover_letter
 * @property string|null                    $linked_in
 * @method static Builder|Vacancy whereCoverLetter($value)
 * @method static Builder|Vacancy whereLinkedIn($value)
 */
class Vacancy extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'location',
        'duration',
        'work_type',
        'description',
        'responsibilities',
        'qualifications',
        'open_date',
        'end_date',
        'application_procedure',
        'salary',
        'salary_currency',
        'contact_email',
        'with_form',
        'first_name',
        'last_name',
        'photo',
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
        'attach_cv',
        'cover_letter',
        'linked_in',
        'published',
        'contact_person_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'with_form' => 'boolean',
        'published' => 'boolean',
        'salary' => 'integer'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'open_date',
        'end_date',
    ];

    /**
     * Statuses of form fields
     *
     * @var array
     */
    public static $statuses = [
        'required' => 'Required',
        'optional' => 'Optional',
    ];

    /**
     * Get the applicants of the vacancy
     *
     * @return HasMany
     */
    public function applicants()
    {
        return $this->hasMany('App\Models\JobApplicant');
    }

    /**
     * Get the contact person/employee of vacancy
     *
     * @return BelongsTo
     */
    public function contactPerson()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the dynamic contact_person_title attribute
     *
     * @return string|null
     */
    public function getContactPersonTitleAttribute()
    {
        return $this->contactPerson ? $this->contactPerson->role : null;
    }

    /**
     * Accessor for open_date attribute
     *
     * @param $date
     *
     * @return string
     */
    public function getOpenDateAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Accessor for end_date attribute
     *
     * @param $date
     *
     * @return string
     */
    public function getEndDateAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Mutator for open_date attribute
     *
     * @param $date
     */
    public function setOpenDateAttribute($date)
    {
        $this->attributes['open_date'] = $date ? Carbon::parse($date) : null;
    }

    /**
     * Mutator for end_date attribute
     *
     * @param $date
     */
    public function setEndDateAttribute($date)
    {
        $this->attributes['end_date'] = $date ? Carbon::parse($date) : null;
    }
}
