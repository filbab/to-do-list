<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('task_statuses')->insert(['name' => 'pending']);
        DB::table('task_statuses')->insert(['name' => 'in progress']);
        DB::table('task_statuses')->insert(['name' => 'completed']);
    }
}