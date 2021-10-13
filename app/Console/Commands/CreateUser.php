<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UsersModel;
use App\Models\RolesModel;
use DB;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base_admin:root';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        if($this->secret('Please insert developer keys?') == '123456')
        {
            while(true)
            {
                $this->info('--Menu--');
                foreach (['1. Insert User', '2. Update user', '3. Delete User', '4. Exit'] as $key => $value) {
                    $this->info($value);
                }
                $choose = $this->ask('What your choose?');
                if($choose==1){
                    $this->info('--List Role--');
                    $role = RolesModel::all();
                    foreach ($role as $key => $row) {
                        $this->info('[id='.$row->id.'] '.$row->name);
                    }

                    $role_id = $this->ask('Select user role?');
                    if(RolesModel::find($role_id)){
                        $data_create = array();
                        $data_create['role_id'] = $role_id;
                        $data_create['first_name'] = $this->ask('Input user first name!');
                        $data_create['last_name'] = $this->ask('Input user last name!');
                        $data_create['email'] = $this->ask('Input user email!');
                        $data_create['password'] = bcrypt($this->ask('Input user password!'));
                        UsersModel::create($data_create);
                        $this->info('Successful create user "'.$data_create['first_name'].'"');
                    }else{
                        $this->info('Role not available');
                    }
                }
                else if($choose==2)
                {
                    $this->info('--List user--');
                    foreach (UsersModel::all() as $key => $row) {
                        $this->info('[id='.$row->id.'] '.$row->name);
                    }
                    $id = $this->ask('What id will update?');
                    if(UsersModel::find($id))
                    {
                        $data_create['first_name'] = $this->ask('Input user first name!');
                        $data_create['last_name'] = $this->ask('Input user last name!');
                        $data_create['name'] = $this->ask('Input user name!');
                        $data_create['email'] = $this->ask('Input user email!');
                        $data_create['password'] = bcrypt($this->ask('Input user password!'));
                        UsersModel::find($id)->update($data_update);
                        $this->info('Successful update user "'.$data_update['first_name'].'"');
                    }
                    else
                    {
                        $this->info('Id not registered, abort to update');
                    }                    
                }
                else if($choose==3)
                {
                    $this->info('--List User--');
                    foreach (UsersModel::all() as $key => $row) {
                        $this->info('[id='.$row->id.'] '.$row->name);
                    }
                    $id = $this->ask('What id will delete?');
                    if(UsersModel::find($id))
                    {
                        UsersModel::find($id)->delete();
                        $this->info('Successful delete user');
                    }
                    else
                    {
                        $this->info('Id not registered, abort to delete');
                    }
                }
                else if($choose==4)
                {
                    break;
                }
            }
        }
        else
        {
            $this->info('You not allow to access');
        }
        
    }
}
