<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $calling_code
 * @property string|null $country
 * @property string|null $dp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCallingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereZipCode($value)
 * @mixin \Eloquent
 */
class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'state',
        'zip_code',
        'phone',
        'calling_code',
        'country',
        'dp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
