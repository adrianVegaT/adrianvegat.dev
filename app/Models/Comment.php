<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
        'is_approved',
        'author_name',
        'author_email',
    ];

    protected $appends = ['display_name', 'avatar_url'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function getDisplayNameAttribute(): string
    {
        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->name;
        }

        return $this->author_name ?? 'Anónimo';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->avatar_url;
        }

        $name = urlencode($this->author_name ?? 'Anónimo');

        return 'https://ui-avatars.com/api/?name=' . $name . '&color=7F9CF5&background=EBF4FF';
    }

    public function isAnonymous(): bool
    {
        return $this->user_id === null;
    }

    public function canBeManagedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $user->id === $this->user_id || $user->hasRole('admin');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('is_approved', true)
            ->with('user', 'replies');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}