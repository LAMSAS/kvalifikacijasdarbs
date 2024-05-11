<?php

namespace Modules\EmployeeTeams\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTeamType extends Model
{
    use HasFactory;
    public function teams()
    {
        return $this->hasMany(EmployeeTeam::class, 'team_type_id');
    }
}
