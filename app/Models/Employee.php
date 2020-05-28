<?php /** @noinspection ALL */

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Countries\Countries;

/**
 * App\Models\Employee
 *
 * @property int                                                                          $id
 * @property int                                                                          $user_id
 * @property int|null                                                                     $department_id
 * @property string                                                                       $first_name
 * @property string                                                                       $last_name
 * @property \Illuminate\Support\Carbon|null                                              $created_at
 * @property \Illuminate\Support\Carbon|null                                              $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[]             $assignedTasks
 * @property-read int|null                                                                $assigned_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[]             $createdTasks
 * @property-read int|null                                                                $created_tasks_count
 * @property-read \App\Models\Department|null                                             $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[]         $documents
 * @property-read int|null                                                                $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[]         $documentsForApprove
 * @property-read int|null                                                                $documents_for_approve_count
 * @property-read string                                                                  $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[]         $rejectedDocuments
 * @property-read int|null                                                                $rejected_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[]             $responsibleTasks
 * @property-read int|null                                                                $responsible_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[]             $teams
 * @property-read int|null                                                                $teams_count
 * @property-read \App\Models\User                                                        $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereUserId($value)
 * @mixin \Eloquent
 * @property string|null                                                                  $patronymic
 * @property string                                                                       $birth_date
 * @property string|null                                                                  $sex
 * @property string|null                                                                  $phone_number
 * @property string|null                                                                  $nationality
 * @property string|\Countries                                                            $citizenship
 * @property string|null                                                                  $residence_address
 * @property string|null                                                                  $registration_address
 * @property string|null                                                                  $avatar
 * @property \Illuminate\Support\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Education[]        $educations
 * @property-read int|null                                                                $educations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Experience[]       $experiences
 * @property-read int|null                                                                $experiences_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProfileFormField[] $profileFormField
 * @property-read int|null                                                                $profile_form_field_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Employee onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereRegistrationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereResidenceAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Employee withoutTrashed()
 * @property-read string                                                                  $email
 * @property-read string                                                                  $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProfileFormField[] $profileFormFields
 * @property-read int|null                                                                $profile_form_fields_count
 * @property-read \App\Models\CalendarSetting                                             $calendarSettings
 * @property float                                                                        $salary
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[]            $events
 * @property-read int|null                                                                $events_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereSalary($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[]            $createdEvents
 * @property-read int|null                                                                $created_events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmployeeSalary[]   $employeeSalary
 * @property-read int|null                                                                $employee_salary_count
 * @property-read \Collection                                                             $all_assigned_tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeTracker[]      $trackers
 * @property-read int|null                                                                $trackers_count
 * @property \Illuminate\Support\Carbon|null                                              $vacation_expire
 * @property-read int                                                                     $new_documents_count
 * @property-read mixed                                                                   $new_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeOff[]          $timeOffs
 * @property-read int|null                                                                $time_offs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereVacationExpire($value)
 * @property float                                                                        $paid_time
 * @property float                                                                        $unpaid_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee wherePaidTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereUnpaidTime($value)
 * @property-read int|null                                                                $age
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogPost[]         $posts
 * @property-read int|null                                                                $posts_count
 * @property string|null                                                                  $social_in
 * @property string|null                                                                  $social_fb
 * @property string|null                                                                  $social_tw
 * @property-read \Illuminate\Database\Eloquent\HasMany                                   $current_salary
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereSocialFb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereSocialIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereSocialTw($value)
 * @property string|null                                                                  $status
 * @property-read string                                                                  $birthday_month
 * @property-read string                                                                  $date_of_birth
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo                       $department_name
 * @property-read string                                                                  $job_title
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo                       $recruited_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereStatus($value)
 * @property int|null                                                                     $manager_id
 * @property-read \App\Models\Employee|null                                               $manager
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[]         $subordinates
 * @property-read int|null                                                                $subordinates_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereManagerId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Survey[]           $activeSurveys
 * @property-read int|null                                                                $active_surveys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Survey[]           $createdSurveys
 * @property-read int|null                                                                $created_surveys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Survey[]           $surveys
 * @property-read int|null                                                                $surveys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[]         $questions
 * @property-read int|null                                                                $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Interview[]        $interviews
 * @property-read int|null                                                                $interviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Interview[]        $organizedInterviews
 * @property-read int|null                                                                $organized_interviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[]             $quizzes
 * @property-read int|null                                                                $quizzes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[]             $createdQuizzes
 * @property-read int|null                                                                $created_quizzes_count
 * @property int                                                                          $reward_received
 * @property int                                                                          $reward_monthly
 * @property int                                                                          $reward_left
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Redeemable[]       $redeemables
 * @property-read int|null                                                                $redeemables_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereRewardLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereRewardMonthly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereRewardReceived($value)
 */
class Employee extends Model
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
        'birth_date',
        'sex',
        'phone_number',
        'nationality',
        'citizenship',
        'residence_address',
        'registration_address',
        'paid_time',
        'unpaid_time',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'paid_time'   => 'float',
        'unpaid_time' => 'float',
    ];

    /**
     * The attributes that should be append dynamic.
     *
     * @var array
     */
    protected $append = [
        'fullName',
        'role',
        'email',
        'age'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birth_date',
        'vacation_expire'
    ];

    /**
     * Sexes of the employees
     *
     * @var array
     */
    public static $sexes = [
        'male'   => 'Male',
        'female' => 'Female',
    ];

    /**
     * Sexes of the employees
     *
     * @var array
     */
    public static $statuses = [
        'full'   => 'Full-Time',
        'part'   => 'Part-Time',
        'intern' => 'Intern',
        'remote' => 'Remote',
    ];

    /**
     * Accessor for birth_date column
     *
     * @param string $birthDate
     *
     * @return string
     */
    public function getBirthDateAttribute($birthDate)
    {
        return $birthDate ? Carbon::parse($birthDate) : null;
    }

    /**
     * Get the formated birth_date of the employee
     *
     * @param string $birthDate
     *
     * @return string
     */
    public function getDateOfBirthAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d.m.Y') : null;
    }

    /**
     * Get the month of birth_date of the employee
     *
     * @param string $birthDate
     *
     * @return string
     */
    public function getBirthdayMonthAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('F') : null;
    }

    /**
     * Get the formated created_at of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getRecruitedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d.m.Y') : null;
    }

    /**
     * Mutator for birth_date column
     *
     * @param string $birthDate
     */
    public function setBirthDateAttribute($birthDate)
    {
        $this->attributes['birth_date'] = $birthDate ? Carbon::parse($birthDate) : null;
    }

    /**
     * Accessor for sex column
     *
     * @param string $sex
     *
     * @return string
     */
    public function getSexAttribute($sex)
    {
        return !empty($sex) ? __(self::$sexes[$sex]) : null;
    }

    /**
     * Accessor for status column
     *
     * @param string $status
     *
     * @return string
     */
    public function getStatusAttribute($status)
    {
        return !empty($status) ? __(self::$statuses[$status]) : null;
    }

    /**
     * Get the employee's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the employee's email.
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get the employee's role.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        return $this->user->role->display_name;
    }

    /**
     * Get the employee's job title.
     *
     * @return string
     */
    public function getJobTitleAttribute()
    {
        return $this->role;
    }

    /**
     * Get the employee's age.
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->diffInYears() : null;
    }

    /**
     * Get the department of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    /**
     * Get the department name of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getDepartmentNameAttribute()
    {
        return $this->department->name;
    }

    /**
     * Get the user instance of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the tasks assigned to the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function assignedTasks()
    {
        return $this->morphMany('App\Models\Task', 'assignee');
    }

    /**
     * Get all (include inherited from team) the tasks assigned to the employee
     *
     * @return Collection
     */
    public function getAllAssignedTasksAttribute()
    {
        $tasks = $this->assignedTasks;
        $teams = $this->teams;
        foreach ($teams as $team) {
            $tasks = $tasks->merge($team->assignedTasks);
        }

        return $tasks->unique();
    }

    /**
     * Get the count of assigned to employee tasks with status "new"
     *
     * @return mixed
     */
    public function getNewTasksCountAttribute()
    {
        $tasks = $this->assignedTasks()->whereStatus('new')->get();
        $teams = $this->teams;
        foreach ($teams as $team) {
            $tasks = $tasks->merge($team->assignedTasks()->whereStatus('new')->get());
        }

        return $tasks->unique()->count();
    }

    /**
     * Get the tasks created by the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTasks()
    {
        return $this->hasMany('App\Models\Task', 'author_id');
    }

    /**
     * Get the tasks for which the employee is responsible
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responsibleTasks()
    {
        return $this->hasMany('App\Models\Task', 'responsible_id');
    }

    /**
     * Get the documents created by the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document', 'author_id');
    }

    /**
     * Get the documents for approve by the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentsForApprove()
    {
        return $this->hasMany('App\Models\Document', 'waiting_id');
    }

    /**
     * Get the types of user's documents in process
     *
     * @return Collection
     */
    public function getDocTypesInProcess()
    {
        $documents = $this->documents()->whereNull('rejected_by')->whereApproved(false)->get();
        $types     = [];
        foreach ($documents as $doc) {
            $types[] = $doc->type->name;
        }

        return collect($types)->unique();
    }

    /**
     * Get the documents rejected by the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rejectedDocuments()
    {
        return $this->hasMany('App\Models\Document', 'rejected_by');
    }

    /**
     * Get the teams where registered the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'employee_team', 'employee_id', 'team_id')->withPivot('role');
    }

    /**
     * Get the educations of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations()
    {
        return $this->hasMany('App\Models\Education')->orderBy('date_from', 'desc');
    }

    /**
     * Get the experiences of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Models\Experience')->orderBy('date_from', 'desc');
    }

    /**
     * Get the formField of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profileFormFields()
    {
        return $this->belongsToMany('App\Models\ProfileFormField')->withPivot('data');
    }

    /**
     * Get the calendar settings of the employee
     *
     * @return \Illuminate\Database\Eloquent\HasOne
     */
    public function calendarSettings()
    {
        return $this->hasOne('App\Models\CalendarSetting')->withDefault(config('calendarSettings'));
    }

    /**
     * Get the events in wich the employee takes part
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany('App\Models\Event');
    }

    /**
     * Get the interviews in wich the employee takes part
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interviews()
    {
        return $this->belongsToMany('App\Models\Interview');
    }

    /**
     * Get the events created by employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdEvents()
    {
        return $this->hasMany('App\Models\Event', 'creator_id');
    }

    /**
     * Get the events created by employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizedInterviews()
    {
        return $this->hasMany('App\Models\Interview', 'organizer_id');
    }

    /**
     * Get salary records of the employee
     *
     * @return \Illuminate\Database\Eloquent\HasMany
     */
    public function employeeSalary()
    {
        return $this->hasMany('App\Models\EmployeeSalary');
    }

    /**
     * Get the current salary of the employee
     *
     * @return int|float
     */
    public function getCurrentSalaryAttribute()
    {
        return $this->employeeSalary->where('month', now()->format("Y-m"))->first()->salary ?? 0.00;
    }

    /**
     * Get salary records of the employee by month
     *
     * @return App\Models\EmployeeSalary|null
     */
    public function employeeSalaryByMonth($month)
    {
        return $this->employeeSalary()->where('month', $month)->first();
    }

    /**
     * Get the time trackers created by the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->hasMany('App\Models\TimeTracker');
    }

    /**
     * Get the time-offs of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeOffs()
    {
        return $this->hasMany('App\Models\TimeOff');
    }

    /**
     * Get the blog posts of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\BlogPost', 'author_id');
    }

    /**
     * Get the subordinates of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subordinates()
    {
        return $this->hasMany('App\Models\Employee', 'manager_id');
    }

    /**
     * Get the manager of the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the created surveys by the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdSurveys()
    {
        return $this->hasMany('App\Models\Survey', 'author_id');
    }


    /**
     * Get all surveys attached to the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function surveys()
    {
        return $this->belongsToMany('App\Models\Survey')->withPivot('status');
    }

    /**
     * Get active surveys attached to the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeSurveys()
    {
        return $this->surveys()->wherePivot('status', 'active');
    }

    /**
     * Get the questions what the employee answered
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Models\Question')->whereNotNull('survey_id')->withPivot('answer');
    }

    /**
     * Get the quizzes attached to the employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function quizzes()
    {
        return $this->morphToMany('App\Models\Quiz', 'quizable')->withPivot('result');
    }

    /**
     * Get the created surveys by the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdQuizzes()
    {
        return $this->hasMany('App\Models\Quiz', 'author_id');
    }

    /**
     * Get the redeemable products or servicies redeemed by employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function redeemables()
    {
        return $this->belongsToMany('App\Models\Redeemable')->withPivot('date');
    }

    /**
     * Calculate specific tax details for employee
     *
     * @return array
     */
    public function calculateTaxDetails(Tax $tax, $salary = null)
    {
        $defaults = [
            'rate'   => 0,
            'amount' => 0,
        ];
        if (!$salary) {
            $salary = $this->salary;
        }

        $taxInterval = $tax->taxIntervals()->where('start', '<=', $salary)->where('end', '>=', $salary)->first();

        $rate = $taxInterval ? $taxInterval->rate : $defaults['rate'];

        $amount = $salary * $rate / 100;

        return compact('salary', 'amount', 'rate');
    }
}
