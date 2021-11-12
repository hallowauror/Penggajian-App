<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Presence extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['periode'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
