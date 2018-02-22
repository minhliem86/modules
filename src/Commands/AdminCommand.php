<?php

namespace Liemphan\modules\Commands;

use Illuminate\Console\Command;
use Hash;
use DB;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin Role and login Permission';

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
        $role = new Role();
        $role->name = 'admin';
        $role->display_name = 'Administrator';
        $role->description = 'Dashboard Administration';
        $role->save();

        $permission = new Permission;
        $permission->name = 'login';
        $permission->display_name = 'Login to Dashboard';
        $permission->description = 'Login to DashBoard';
        $permission->save();

        $role->attachPermission($permission);

        $data['name'] = $this->ask('What your name ?','Admin');
        $data['email'] = $this->ask('What your email ?','admin@localhost.com');
        $data['password'] = $this->ask('What is the password ?','1234567');
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->attachRole($role);

        $this->info('Admin Create Successfully.');
    }
}
