<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UsersModel;
use App\Models\RolesModel;
use DB;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lemari:root';

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
        if($this->secret('Please insert developer keys?') == 'lemari')
        {
            while(true)
            {
                $this->info('--Lemari Creative Menu--');
                foreach (['1. Insert Admin', '2. Update Admin', '3. Delete Admin', '4. Exit'] as $key => $value) {
                    $this->info($value);
                }
                $choose = $this->ask('What your choose?');
                if($choose==1){
                    $role = RolesModel::where('name', 'admin')->first();
                    if($role == null){
                        $data_role = array();
                        $data_role['name'] = 'admin';
                        $data_role['display_name'] = 'Admin';
                        $data_role['description'] = 'role for admin';
                        $role = RolesModel::create($data_role);
                    }

                    $data_create = array();
                    $data_create['role_id'] = $role->id;
                    $data_create['name'] = $this->ask('Input admin name!');
                    $data_create['phone'] = $this->ask('Input admin phone!');
                    $data_create['email'] = $this->ask('Input admin email!');
                    $data_create['password'] = bcrypt($this->ask('Input admin password!'));
                    $data_create['status'] = 1;
                    UsersModel::create($data_create);
                    $this->info('Successful create admin "'.$data_create['name'].'"');
                }
                else if($choose==2)
                {
                    $this->info('--List Admin--');
                    $role = RolesModel::where('name', 'admin')->first();
                    foreach (UsersModel::where('role_id', $role->id)->get() as $key => $row) {
                        $this->info('[id='.$row->id.'] '.$row->name);
                    }
                    $id = $this->ask('What id will update?');
                    if(UsersModel::find($id)->get()->count()>0)
                    {
                        $data_create['role_id'] = $role->id;
                        $data_create['name'] = $this->ask('Input admin name!');
                        $data_create['phone'] = $this->ask('Input admin phone!');
                        $data_create['email'] = $this->ask('Input admin email!');
                        $data_create['password'] = bcrypt($this->ask('Input admin password!'));
                        $data_create['status'] = 1;
                        UsersModel::find($id)->update($data_update);
                        $this->info('Successful update admin "'.$data_update['name'].'"');
                    }
                    else
                    {
                        $this->info('Id not registered, abort to update');
                    }                    
                }
                else if($choose==3)
                {
                    $this->info('--List Admin--');
                    $role = RolesModel::where('name', 'admin')->first();
                    foreach (UsersModel::where('role_id', $role->id)->get() as $key => $row) {
                        $this->info('[id='.$row->id.'] '.$row->name);
                    }
                    $id = $this->ask('What id will delete?');
                    if(UsersModel::find($id)->get()->count()>0)
                    {
                        UsersModel::find($id)->delete($data_update);
                        $this->info('Successful delete admin');
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
