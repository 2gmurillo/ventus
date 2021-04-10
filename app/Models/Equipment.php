<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property null|string risk
 * @property null|string maintenance
 * @property null|string calibration
 * @property null|string next_maintenance
 */
class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'risk',
        'maintenance',
        'calibration',
    ];

    protected $dates = [
        'maintenance',
        'calibration',
        'next_maintenance',
    ];
}
