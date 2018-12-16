<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class ManageRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage:roles {--C|create} 
                                        {--R|read} 
                                        {--U|update= : updatedRoleName,"new role description" (only single role allowed). }
                                        {--D|delete}
                                        
                                        {roles* : roleName,"new role description" anotherRoleName,"yes another" }
                                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backend Roles CRUD';

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
        $roles = $this->argument('roles');

        if(count(array_filter(array_only($this->options(),['create','read','update','delete']))) > 1)
        {
            $this->error('Only one option allowed.');

            return 1;
        }

        if($this->option('create'))
        {
            $this->create($roles);
            $this->info('Roles has been created');
        }

        if($this->option('read'))
        {
            $this->read($roles);            
        }

        if($this->option('update'))
        {            
            if($this->option('update') !== "")
            {
                $this->update($roles[0],$this->option('update'));
                $this->info('Roles has been updated.');
            }
            
        }

        if($this->option('delete'))
        {
            $this->delete($roles);

        }
        
    }

    private function create($roles)
    {
        
        foreach($roles as $role)
        {
            $data = explode(",",$role);

            if(!array_key_exists(1,$data))
            {
                $data[1] = $role.' role';
            }

            Role::create(['name'=>strtolower($data[0]),'description'=>$data[1]]);
        }        

        return true;        
        
    }

    private function read($roles)
    {
        $datas = Role::whereIn('name',$roles)->get();

        foreach($datas as $role)
        {
            $this->info('-----');
            $columns = Schema::getColumnListing((new Role)->getTable());
            foreach($columns as $column)
            {
                $this->info($column." : ".$role->{$column});
            }
            $this->info('-----');
        }
        
    }

    private function update($role, $value)
    {  
        $data = explode(",",$value);

        if(!array_key_exists(1,$data))
        {
            $data[1] = $role.' role';
        }

       return  Role::whereName($role)->update(['name'=>strtolower($data[0]),'description'=>$data[1]]);

    }

    private function delete($roles)
    {
        return Role::whereIn('name',$roles)->delete();
    }
}
