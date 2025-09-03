<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoles;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [
        'id',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    function getRouteKeyName()
    {
        return 'account_code';
    }


    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function invitedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user');
    }

    public function paymentTransaction()
    {
        return $this->morphToMany(PaymentTransaction::class, 'model');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'employee_id');
    }
    // SCOPES
    function scopeEmployeesOnly($query)
    {
        return $query->whereDoesntHave('roles', function ($query) {
            $query->where('name', UserRoles::ADMINISTRATOR->value);
        });
    }

    function scopeLastAttendanceAction()
    {
        $attendance_log = $this->attendanceLogs()->whereDate('created_at', Carbon::today())->latest()->first();
        if (!is_null($attendance_log) && $attendance_log->action == 'check-in') {
            return 'check-out';
        }
        return 'check-in';
    }
}