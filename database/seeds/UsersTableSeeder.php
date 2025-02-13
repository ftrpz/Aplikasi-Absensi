<?php

use App\Attendance;
use App\Department;
use \DateTime as DateTime;
use App\User;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        DB::table('employees')->truncate();
        DB::table('departments')->truncate();
        DB::table('attendances')->truncate();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        $employee = User::create([
            'name' => 'Fitria Putri Zaharani',
            'email' => 'fitria@gmail.com',
            'password' => Hash::make('fitria123')
        ]);
        

        $dob = new DateTime('1999-03-29');
        $join = new DateTime('2021-09-15');
        
        $admin = Employee::create([
            'user_id' => 1,
            'first_name' => 'Admin',
            'last_name' => '',
            'dob' => $dob->format('Y-m-d'),
            'sex' => 'Female',
            'desg' => 'Manager',
            'department_id' => 1,
            'join_date' => $join->format('Y-m-d'),
            'salary' => 6500000,
            'photo' => 'admin.png'
        ]);
        $employee = Employee::create([
            'user_id' => 2,
            'first_name' => 'Fitria Putri',
            'last_name' => 'Zaharani',
            'dob' => $dob->format('Y-m-d'),
            'sex' => 'Female',
            'desg' => 'Staff',
            'department_id' => 3,
            'join_date' => $join->format('Y-m-d'),
            'salary' => 300000,
            'photo' => 'farmasi.png'
        ]);

        Department::create(['name' => 'Manajemen']);
        Department::create(['name' => 'Marketing']);
        Department::create(['name' => 'Desain Grafis']);
        Department::create(['name' => 'Customer Service']);
        Department::create(['name' => 'Customer Relationship Management']);

        // Attendance seeder
        $create = Carbon::create(2021, 8, 17, 10, 00, 23, 'Asia/Jakarta');
        $update = Carbon::create(2021, 8, 17, 17, 00, 23, 'Asia/Jakarta');

        for($j=1;$j<=$admin->id;$j++) {
            DB::table('role_user')->insert([
                'role_id' => 1,
                'user_id' => $j
            ]);
        }

        for($i=2;$i<=$employee->id;$i++) {
            DB::table('role_user')->insert([
                'role_id' => 2,
                'user_id' => $i
            ]);
        }

        for($k=2;$k<=$employee->id;$k++) { 
            $attendance = Attendance::create([
                'employee_id' => $k,
                'entry_ip' => '127.0.0.1',
                'entry_location' => '',
                'created_at' => $create
            ]);
            $attendance->exit_ip = '127.0.0.1';
            $attendance->exit_location = '';
            $attendance->registered = 'ya';
            $attendance->updated_at = $update;
            $attendance->save();
            $create->addDay();
            $update->addDay();
        }
    }
}
