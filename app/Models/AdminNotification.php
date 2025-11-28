<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $message
 * @property string|null $route
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminNotification extends Model
{
    protected $fillable = ['title', 'message', 'route', 'is_read'];
}
