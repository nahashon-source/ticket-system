<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Priority extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name'];
}
