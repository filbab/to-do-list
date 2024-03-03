<?php
 
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
 
class CreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:users {--count=1}';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create users for testing purposes.';
 
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
      $count = $this->option('count');

      $users = User::factory()->count($count)->create();

      $this->info($users->pluck('email'));
    }
}