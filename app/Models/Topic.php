<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'apdated_at';
    protected $connection = 'mysql';
    protected $table = 'topics';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'classroom_id', 'user_id', 'name'
    ];


    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? '', function ($builder, $value) {
            $builder->where(function ($builder) use ($value) {
                $builder->where('name', 'LIKE', "%{$value}%")
                    ->orWhereHas('classworks', function ($builder) use ($value) {
                        $builder->where('title', 'LIKE', "%{$value}%")
                            ->orWhere('description', 'LIKE', "%{$value}%");
                    });
            });
        });
    }


    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, 'topic_id', 'id');
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
}
