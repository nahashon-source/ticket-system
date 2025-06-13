<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $user_id
 * @property string $action
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ticket $ticket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketLog whereUserId($value)
 * @mixin \Eloquent
 */
class TicketLog extends Model
{
    //
    protected $fillable = [
        'ticket_id', 'user_id', 'action', 'description'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
