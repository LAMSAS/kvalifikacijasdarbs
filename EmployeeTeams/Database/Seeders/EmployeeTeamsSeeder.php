<?php

namespace Modules\EmployeeTeams\Database\Seeders;

use Modules\EmployeeTeams\App\Models\EmployeeTeam;
use Illuminate\Database\Seeder;
use Modules\Employees\App\Models\Employee;
use Faker\Factory as Faker;


class EmployeeTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $faker = Faker::create('lv_LV');

        foreach ($employees as $employee) {
            EmployeeTeam::create([
                'title' => $employee->first_name. ' '. $employee->last_name . "'s Team",
                'manager_id' => $employee->id,
                'employee_count' => $faker->randomDigit(),
                'team_type_id' => 1,
                'is_active' => $faker->boolean(50),
                'initials' => mb_substr($employee->first_name, 0, 1).mb_substr($employee->last_name, 0, 1)
            ]);

        }
    }
}
