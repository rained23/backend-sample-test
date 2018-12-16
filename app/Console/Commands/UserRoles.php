<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Role;

class UserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:roles {--D|detach : Detach roles from user} {userId} {roleName* : roleName anotherRoleName ... }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set or unset user role(s).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {                
        $user = User::find($this->argument('userId'));
        
        $roles = Role::whereIn('name',$this->argument('roleName'))->pluck('id');
        if(!$user)
        {
            $this->error('No user found for that ID');
            return 1;
        }        
        
        if(! $this->option('detach') )
        {
            $user->roles()->sync($roles);
            $this->info('User has been assigned with the role(s).');
        } else {
            $user->roles()->detach($roles);
            $this->info('Role(s) has been detached from user.');
        }                    

    }
}
