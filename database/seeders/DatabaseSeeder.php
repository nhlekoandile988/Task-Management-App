<?php

namespace Database\Seeders;

use App\Models\CategoryAKL;
use App\Models\TaskAKL;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@smartdrive.test'],
            ['name' => 'Smart Drive Manager', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        $member = User::updateOrCreate(
            ['email' => 'consultant@smartdrive.test'],
            ['name' => 'Smart Drive Consultant', 'password' => Hash::make('password'), 'role' => 'team_member']
        );

        User::updateOrCreate(
            ['email' => 'guest@smartdrive.test'],
            ['name' => 'Smart Drive Guest', 'password' => Hash::make('password'), 'role' => 'guest']
        );

        $categories = collect([
            ['name' => 'Sales Leads', 'color' => '#1E3A5F'],
            ['name' => 'Test Drives', 'color' => '#FF6B6B'],
            ['name' => 'Finance Applications', 'color' => '#2f5f8f'],
            ['name' => 'Vehicle Delivery', 'color' => '#8a98a8'],
            ['name' => 'After-Sales Follow Up', 'color' => '#D3D3D3'],
        ])->map(fn ($data) => CategoryAKL::updateOrCreate(['name' => $data['name']], $data));

        TaskAKL::updateOrCreate(
            ['title' => 'Follow up with SUV lead'],
            [
                'category_id' => $categories[0]->id,
                'assigned_to' => $member->id,
                'created_by' => $admin->id,
                'description' => 'Call the customer interested in the Toyota Fortuner, confirm budget, and schedule a showroom visit.',
                'priority' => 'high',
                'status' => 'in_progress',
                'deadline' => now()->addDays(2)->toDateString(),
            ]
        );

        TaskAKL::updateOrCreate(
            ['title' => 'Prepare delivery paperwork for sedan sale'],
            [
                'category_id' => $categories[3]->id,
                'assigned_to' => $admin->id,
                'created_by' => $admin->id,
                'description' => 'Finalize invoice, registration documents, warranty forms, and delivery checklist before handover.',
                'priority' => 'medium',
                'status' => 'pending',
                'deadline' => now()->addWeek()->toDateString(),
            ]
        );

        TaskAKL::updateOrCreate(
            ['title' => 'Book test drive for hatchback customer'],
            [
                'category_id' => $categories[1]->id,
                'assigned_to' => $member->id,
                'created_by' => $admin->id,
                'description' => 'Reserve the demo vehicle, confirm customer license details, and prepare the route.',
                'priority' => 'medium',
                'status' => 'pending',
                'deadline' => now()->addDays(3)->toDateString(),
            ]
        );

        TaskAKL::updateOrCreate(
            ['title' => 'Submit finance application for bakkie buyer'],
            [
                'category_id' => $categories[2]->id,
                'assigned_to' => $member->id,
                'created_by' => $admin->id,
                'description' => 'Collect payslips, bank statements, ID copy, and submit the finance application to the bank.',
                'priority' => 'high',
                'status' => 'pending',
                'deadline' => now()->addDay()->toDateString(),
            ]
        );
    }
}

