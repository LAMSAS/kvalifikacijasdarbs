<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Modules\Employees\App\Models\Employee;

class EmployeesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('lv_LV');

        for ($i = 0; $i < 50; $i++) {
            $employee = new Employee;

            $employee->first_name = $faker->firstName;
            $employee->last_name = $faker->lastName;
            $employee->email = $faker->email;
            $employee->phone = $faker->e164PhoneNumber;
            $employee->state = $faker->country;
            $employee->city = $faker->city;
            $employee->address = $faker->address;
            $employee->zip = $faker->postcode;
            $employee->department = $faker->randomElement(['Human resources', 'Information technology', 'Finance', 'Marketing', 'Sales', 'Management'], 1);
            $employee->position = $faker->randomElement(['Manager', 'Assistant Manager', 'Executive', 'Intern'], 1);
            $employee->salary = $faker->randomFloat(2, 1000, 10000);
            $employee->is_active = $faker->boolean;
            $employee->hire_date = $faker->date;
            $employee->birthday = $faker->date;
            $employee->nameday = $faker->date;
            $employee->team_id = $faker->numberBetween(1, 50);

            $employee->save();
        }
    }
}
