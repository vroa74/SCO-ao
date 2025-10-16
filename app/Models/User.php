<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rfc',
        'curp',
        'direccion',
        'cargo',
        'sexo',
        'lvl',
        'tipo',
        'estatus',
        'theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'estatus' => 'boolean',
        'tipo' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Si tenemos una foto personalizada y existe el archivo
        if ($this->profile_photo_path && file_exists(public_path($this->profile_photo_path))) {
            return asset($this->profile_photo_path);
        }
        
        // Fallback a avatar con iniciales usando UI Avatars
        return "https://ui-avatars.com/api/?name=" . urlencode($this->nombre) . "&color=7F9CF5&background=EBF4FF";
    }

    /**
     * Get the user groups that the user belongs to.
     */
    public function userGroups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'group_members')
            ->withPivot(['role', 'is_active', 'created_at', 'updated_at'])
            ->withTimestamps();
    }

    /**
     * Get the active user groups that the user belongs to.
     */
    public function activeUserGroups(): BelongsToMany
    {
        return $this->userGroups()->wherePivot('is_active', true);
    }

    /**
     * Get the groups created by this user.
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(UserGroup::class, 'created_by');
    }

    /**
     * Get the group memberships.
     */
    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    /**
     * Get the active group memberships.
     */
    public function activeGroupMemberships(): HasMany
    {
        return $this->hasMany(GroupMember::class)->where('is_active', true);
    }

    /**
     * Check if the user belongs to a specific group.
     */
    public function belongsToGroup($groupId): bool
    {
        return $this->activeUserGroups()->where('user_groups.id', $groupId)->exists();
    }

    /**
     * Check if the user is an admin of a specific group.
     */
    public function isAdminOfGroup($groupId): bool
    {
        return $this->activeUserGroups()
            ->where('user_groups.id', $groupId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    /**
     * Get groups where user is admin.
     */
    public function adminGroups(): BelongsToMany
    {
        return $this->activeUserGroups()->wherePivot('role', 'admin');
    }
}
