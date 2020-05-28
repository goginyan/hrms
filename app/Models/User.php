<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Cmgmyr\Messenger\Traits\Messagable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int                                                        $id
 * @property int|null                                                   $role_id
 * @property string                                                     $email
 * @property Carbon|null                                                $email_verified_at
 * @property string                                                     $password
 * @property string|null                                                $remember_token
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property-read RoleDocTypeCreator|null                               $creator
 * @property-read Collection|DocType[]                                  $docTypes
 * @property-read int|null                                              $doc_types_count
 * @property-read Employee                                              $employee
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @property-read Role|null                                             $role
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property Carbon|null                                                $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property-read Collection|Message[]                                  $messages
 * @property-read int|null                                              $messages_count
 * @property-read Collection|Participant[]                              $participants
 * @property-read int|null                                              $participants_count
 * @property-read Collection|Thread[]                                   $threads
 * @property-read int|null                                              $threads_count
 * @property-read Collection|Permission[]                               $permissions
 * @property-read int|null                                              $permissions_count
 * @property-read Collection|Role[]                                     $roles
 * @property-read int|null                                              $roles_count
 * @method static Builder|User permission($permissions)
 * @method static Builder|User role($roles, $guard = null)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use Messagable;
    use HasRoles;

    protected $guard_name = 'web';

    /**
     * Eager loaded relations
     *
     * @var array
     */
    protected $with = ['employee'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
    ];

    /**
     * Get the role of the user
     *
     * @return mixed
     */
    public function getRoleAttribute()
    {
        return $this->roles->first();
    }

    /**
     * Get the createRole instance of the user
     *
     * @return RoleDocTypeCreator
     */
    public function getCreatorAttribute()
    {
        $roleId = $this->roles->first()->id;

        return RoleDocTypeCreator::find($roleId);
    }

    /**
     * Get the employee instance of the user
     *
     * @return HasOne
     */
    public function employee()
    {
        return $this->hasOne('App\Models\Employee')->withDefault([
            'first_name' => __('Super'),
            'last_name'  => __('Admin'),
        ]);
    }

    /**
     * Get the DocTypes created by the user
     *
     * @return HasMany
     */
    public function docTypes()
    {
        return $this->hasMany("App\Models\DocType", "author_id");
    }

    /**
     * Check if the user is root
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('root');
    }

    /**
     * Mutator for password field for
     * hashing password when it need
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }
}
