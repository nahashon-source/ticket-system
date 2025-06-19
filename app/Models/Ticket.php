<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Fixed the typo here

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $priority
 * @property string $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $agent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Label> $labels
 * @property-read int|null $labels_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereUserId($value)
 * @property int $priority_id
 * @property int $status_id
 * @property int|null $assigned_user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket applyRequestFilters($request)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket applyUserFilter($user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereAssignedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereStatusId($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority_id',
        'status_id',
        'assigned_user_id',
        'user_id',
    ];

    // Renamed 'use' method to 'user' to avoid PHP reserved word
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    // Relationship with File (One to Many)
    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Many-to-many relationship with Label
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status ()
    {
        return $this->belongsTo(Status::class, 'status_id');

    }


    public function scopeApplyUserFilter($query, $user)
    {
        return match ($user->role) {
            'user'  => $query->where('user_id', $user->id),
            'agent' => $query->where('assigned_user_id', $user->id),
            default => $query,
        };
    }

    public function scopeApplyRequestFilters($query, $request)
    {
        return $query
            ->when($request->filled('status'), fn ($q) =>
                $q->where('status_id', $request->status)
            )
            ->when($request->filled('priority'), fn ($q) =>
                $q->where('priority_id', $request->priority)
            )
            ->when($request->filled('category'), fn ($q) =>
                $q->whereHas('categories', fn ($q) =>
                    $q->where('category_id', $request->category)
                )
            );
    }
}
