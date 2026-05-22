<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DirectorDivisionSeeder extends Seeder
{
    public function run(): void
    {
        // Data directors dengan divisions dan departments
        $directorsData = [
            [
                'title' => 'PRESIDENT DIRECTOR', 
                'name' => 'ADE HARTONO', 
                'divisions' => [
                    ['name' => 'Corporate Secretary', 'departments' => ['Corporate Affairs', 'Manager Legal']],
                    ['name' => 'Internal Audit', 'departments' => ['Internal Audit']]
                ]
            ],
            [
                'title' => 'VICE PRESIDENT DIRECTOR', 
                'name' => 'BUDI CAHYONO', 
                'divisions' => [
                    ['name' => 'Marketing', 'departments' => ['EIR key account landisde', 'Key account seaside']],
                    ['name' => 'Business Development', 'departments' => ['Customer Service', 'Business Dev & Marketing Intelligence']]
                ]
            ],
            [
                'title' => 'OPERATION DIRECTOR', 
                'name' => 'P THAVANESWARA', 
                'divisions' => [
                    ['name' => 'Supply Chain', 'departments' => ['Supply Chain Manager', 'Procurement']],
                    ['name' => 'Logistics', 'departments' => ['Logistics Manager', 'Driver']],
                    ['name' => 'Warehouse Management', 'departments' => ['Warehouse Keeper', 'Inventory']]
                ]
            ],
            [
                'title' => 'FINANCE DIRECTOR', 
                'name' => 'MARVIN SETIAWAN', 
                'divisions' => [
                    ['name' => 'Accounting', 'departments' => ['Accounting Manager', 'Accountant']],
                    ['name' => 'Finance Control', 'departments' => ['Finance Manager', 'Analyst']],
                    ['name' => 'Treasury', 'departments' => ['Treasury Manager', 'Cashier']]
                ]
            ],
            [
                'title' => 'ADMINISTRATIVE DIRECTOR', 
                'name' => 'HENRY NALDI', 
                'divisions' => [
                    ['name' => 'Administration', 'departments' => ['Admin Manager', 'Admin Staff']],
                    ['name' => 'General Affairs', 'departments' => ['GA Manager', 'Maintenance']],
                    ['name' => 'Office Management', 'departments' => ['Office Manager', 'Receptionist']]
                ]
            ],
            [
                'title' => 'HUMAN RESOURCE DIRECTOR', 
                'name' => 'SANDY WIJAYA', 
                'divisions' => [
                    ['name' => 'Recruitment', 'departments' => ['Recruitment Manager', 'Recruiter']],
                    ['name' => 'Training & Development', 'departments' => ['Training Manager', 'Trainer']],
                    ['name' => 'Employee Relations', 'departments' => ['HR Manager', 'HR Staff']]
                ]
            ]
        ];

        foreach ($directorsData as $directorData) {
            $director = Director::create([
                'title' => $directorData['title'],
                'name' => $directorData['name']
            ]);

            foreach ($directorData['divisions'] as $divisionData) {
                $division = Division::create([
                    'director_id' => $director->id,
                    'name' => $divisionData['name']
                ]);

                // Create departments for each division
                foreach ($divisionData['departments'] as $departmentName) {
                    Department::create([
                        'division_id' => $division->id,
                        'name' => $departmentName
                    ]);
                }
            }
        }
    }
}
