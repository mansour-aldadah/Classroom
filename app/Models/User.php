<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function setEmailAttribute($value)
    // {
    //     $this->attributes['email'] = ucfirst($value);
    // }

    // protected function email(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => strtoupper($value),
    //         set: fn ($value) => strtolower($value)
    //     );
    // }

    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class,
            'classroom_user',
            'user_id',
            'classroom_id',
            'id',
            'id'
        )->withPivot(['role', 'created_at']);
        // ->as('join');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function createdClassrooms()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    public function classworks()
    {
        return $this->belongsToMany(Classwork::class)
            ->withPivot(['grade', 'submitted_at', 'created_at', 'status'])
            ->using(ClassworkUser::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')
            ->withDefault();
    }
}
