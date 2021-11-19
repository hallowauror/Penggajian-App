<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Position;
use App\Models\Presences;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function presences()
    {
        return $this->hasMany(Presences::class);
    }
}
