<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CustomCreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password} {is_admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user from cli with artisan, with an extra argument';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::factory()->create(
            ['email' => $this->argument('email'),
            'password'=>Hash::make($this->argument('password')),
            'name'=>$this->argument('name'),
            'is_admin'=>$this->argument('is_admin')]
        );
        $this->info('Admin created successfully!');
    }
}
