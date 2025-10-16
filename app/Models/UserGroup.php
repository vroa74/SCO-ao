<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the members of the group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot(['role', 'is_active', 'created_at', 'updated_at'])
            ->withTimestamps();
    }

    /**
     * Get the active members of the group.
     */
    public function activeMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('is_active', true);
    }

    /**
     * Get the group members with their roles.
     */
    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    /**
     * Get the active group members.
     */
    public function activeGroupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class)->where('is_active', true);
    }

    /**
     * Scope for active groups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for groups created by a specific user.
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Scope for groups where user is a member.
     */
    public function scopeWhereUserIsMember($query, $userId)
    {
        return $query->whereHas('activeMembers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Check if a user is a member of this group.
     */
    public function hasMember($userId): bool
    {
        return $this->activeMembers()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a user is an admin of this group.
     */
    public function hasAdmin($userId): bool
    {
        return $this->activeMembers()
            ->where('user_id', $userId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    /**
     * Get the count of active members.
     */
    public function getMembersCountAttribute(): int
    {
        return $this->activeMembers()->count();
    }

    /**
     * Check if the group has the minimum required members (2).
     */
    public function hasMinimumMembers(): bool
    {
        return $this->members_count >= 2;
    }

    /**
     * Add a member to the group.
     */
    public function addMember($userId, $role = 'member'): bool
    {
        if ($this->hasMember($userId)) {
            return false; // User is already a member
        }

        $this->members()->attach($userId, [
            'role' => $role,
            'is_active' => true,
        ]);

        return true;
    }

    /**
     * Remove a member from the group.
     */
    public function removeMember($userId): bool
    {
        if (!$this->hasMember($userId)) {
            return false; // User is not a member
        }

        $this->members()->updateExistingPivot($userId, [
            'is_active' => false,
        ]);

        return true;
    }

    /**
     * Update member role.
     */
    public function updateMemberRole($userId, $role): bool
    {
        if (!$this->hasMember($userId)) {
            return false;
        }

        $this->members()->updateExistingPivot($userId, [
            'role' => $role,
        ]);

        return true;
    }
}