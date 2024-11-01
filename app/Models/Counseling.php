<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'topic', 'description', 'time_reference', 'status', 'level', 'sentiment'];
}
