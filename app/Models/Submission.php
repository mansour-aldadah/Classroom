<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'classwork_id', 'content', 'type'];

    public function classwork()
    {
        return $this->belongsTo(Classwork::class);
    }
}
