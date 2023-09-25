<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Classroom extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static string $disk = 'public';

    protected $fillable = [
        'name', 'section', 'room', 'subject', 'code', 'user_id', 'cover_image_path', 'theme'
    ];

    protected static function booted()
    {

        static::observe(ClassroomObserver::class);

        // static::addGlobalScope('user', function (Builder $query) {
        //     $query->where('user_id', Auth::id());
        // });
        static::addGlobalScope(new UserClassroomScope);

        // static::creating(function (Classroom $classroom) {
        //     $classroom->code = Str::random(8);
        //     $classroom->user_id = Auth::id();
        // });

        // static::forceDeleted(function (Classroom $classroom) {
        //     static::deleteCoverImage($classroom->cover_image_path);
        // });

        // static::deleted(function (Classroom $classroom) {
        //     $classroom->status = 'deleted';
        //     $classroom->save();
        // });
        // static::restored(function (Classroom $classroom) {
        //     $classroom->status = 'active';
        //     $classroom->save();
        // });
    }

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, 'classroom_id', 'id');
    }
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'classroom_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'classroom_user',
            'classroom_id',
            'user_id',
            'id',
            'id'
        )->withPivot(['role', 'created_at']);
        // ->as('join');
    }
    public function teachers()
    {
        return $this->users()->wherePivot('role', 'teacher');
    }
    public function students()
    {
        return $this->users()->wherePivot('role', 'student');
    }
    public function streams()
    {
        return $this->hasMany(Stream::class)->latest();
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? '', function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });
    }




    public function getRouteKeyName()
    {
        return 'id';
    }

    public static function uploadCoverImage($file)
    {
        $path = $file->store('/covers', [
            'disk' => static::$disk,
        ]);
        return $path;
    }
    public static function deleteCoverImage($path)
    {
        if ($path && Storage::disk(Classroom::$disk)->exists($path)) {
            return Storage::disk(Classroom::$disk)->delete($path);
        }
    }

    public function scopeActive(Builder $query)
    {
        $query->where('status', '=', 'active');
    }
    public function scopeRecent(Builder $query)
    {
        $query->orderBy('updated_at', 'ASC');
    }
    public function scopeStatus(Builder $query, $status)
    {
        $query->where('status', '=', $status);
    }

    public function join($user_id, $role = 'student')
    {

        $exists = $this->users()->where('user_id', $user_id)->exists();
        if ($exists) {
            throw new Exception('User already joined the classroom');
        }

        return $this->users()->attach($user_id, [
            'role' => $role,
            'created_at' => now()
        ]);
        // return DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now(),
        // ]);
    }
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image_path) {
            return Storage::disk('public')->url($this->cover_image_path);
        }
        return 'http://placehold.co/800x200';
    }
}
