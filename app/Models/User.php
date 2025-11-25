<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'level'
    ];
    protected $casts = [
        'is_admin' => 'boolean',
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user');
    }
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
    public function addPoints($action, $points)
    {
        $this->increment('points', $points);

        // Registrar en historial si lo deseás
        PointsHistory::create([
            'user_id' => $this->id,
            'action' => $action,
            'points' => $points
        ]);
    }
    public function assignBadgesIfNeeded()
    {
        $badges = \App\Models\Badge::all();

        foreach ($badges as $badge) {
            if ($this->points >= $badge->required_points &&
                !$this->badges->contains($badge->id)) 
            {
                $this->badges()->attach($badge->id);
            }
        }
    }
    /**
     * Suma beans al usuario.
     */
    public function addBeans(int $amount)
    {
        $this->points += $amount;
        $this->save();

        $this->updateLevel();
        $this->assignBadgesIfNeeded();
    }
    /**
     * Resta beans al usuario.
     */
    public function subtractBeans(int $amount)
    {
        $this->points = max(0, $this->points - $amount);
        $this->save();

        $this->updateLevel(); // recalcula nivel
        $this->assignBadgesIfNeeded();
    }

    /**
     * Determina el nivel según la cantidad de beans.
     */
    public function updateLevel()
    {
        $badges = Badge::all();

        foreach ($badges as $badge) {
            if ($this->points >= $badge->required_points &&
                !$this->badges->contains($badge->id)) {

                $this->badges()->attach($badge->id);
            }
        }   
        if ($this->points >= 1200) {
            $this->level = 'master';
        } elseif ($this->points >= 600) {
            $this->level = 'gold';
        } elseif ($this->points >= 200) {
            $this->level = 'silver';
        } else {
            $this->level = 'bronze';
        }

        $this->save();
    }

    public function checkBadges()
{
    $badges = \App\Models\Badge::all();

    foreach ($badges as $badge) {
        if (
            $this->points >= $badge->required_beans &&
            !$this->badges->contains($badge->id)
        ) {
            $this->badges()->attach($badge->id);
        }
    }
}

    /**
     * Retorna un badge legible según el nivel.
     */
    public function getLevelLabel()
    {
        return match ($this->level) {
            'bronze' => '🥉 Bronze Cafetero',
            'silver' => '🥈 Silver Roaster',
            'gold'   => '🥇 Golden Brewer',
            'master' => '🎖 Master Barista',
            default => '🥉 Bronze Cafetero'
        };
    }
}
