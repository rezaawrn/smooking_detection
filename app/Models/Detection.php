<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    protected $table = 'detections';

    protected $fillable = [
        'user_id',
        'image_path',
        'confidence_score',
        'detected_object',
        'detected_at',
        'camera_location',
        'status'
    ];
}

