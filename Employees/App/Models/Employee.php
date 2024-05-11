<?php

namespace Modules\Employees\App\Models;

use App\Models\Team;
use App\Classes\AimModel;
use Modules\Fleet\App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Employees\Database\factories\EmployeeFactory;

class Employee extends Model
{
    use HasFactory, AimModel;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    // public function vehicles()
    // {
    //     return $this->hasMany(Vehicle::class, 'responsible_employee_id');
    // }

    protected static function newFactory(): EmployeeFactory
    {
        //return EmployeeFactory::new();
    }
}
