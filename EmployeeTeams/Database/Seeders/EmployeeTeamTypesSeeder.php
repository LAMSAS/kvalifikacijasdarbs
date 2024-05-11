<?php

namespace Modules\EmployeeTeams\Database\Seeders;

use Modules\EmployeeTeams\App\Models\EmployeeTeamType;
use Illuminate\Database\Seeder;

class EmployeeTeamTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        EmployeeTeamType::create([
            'title' => 'lala',
            'icon' => 'ti-users-group',
            'color' => 'primary',
            'is_active' => true,
            'order_id' => 1
        ]);
    }

    /*
     {
        Schema::create('employee_team_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon');
            $table->string('color');
            $table->boolean('is_active')->nullable();
            $table->integer('order_id');
            $table->timestamps();
        });
    }
     * */
}
