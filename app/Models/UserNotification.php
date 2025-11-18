<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string $message
 * @property string|null $route
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereUserId($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    protected $fillable = ['user_id', 'title', 'message', 'route', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
