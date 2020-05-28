<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Setting
 *
 * @property int         $id
 * @property string      $company_name
 * @property string      $company_logo
 * @property string      $language
 * @property string      $timezone
 * @property string      $mail_from
 * @property string      $mail_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCompanyLogo($value)
 * @method static Builder|Setting whereCompanyName($value)
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereLanguage($value)
 * @method static Builder|Setting whereMailFrom($value)
 * @method static Builder|Setting whereMailName($value)
 * @method static Builder|Setting whereTimezone($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Setting extends Model
{
    //
}
