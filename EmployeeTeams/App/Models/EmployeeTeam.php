<?php

namespace Modules\EmployeeTeams\App\Models;

use App\Classes\AimModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Employees\App\Models\Employee;

class EmployeeTeam extends Model
{
    use HasFactory, AimModel;

    protected $fillable = ['title', 'manager_id', 'team_type_id', 'is_active'];

    public function teamType()
    {
        return $this->belongsTo(EmployeeTeamType::class, 'team_type_id');
    }

    public function employee ()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }
}
