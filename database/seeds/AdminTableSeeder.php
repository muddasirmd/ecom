<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id'=>1, 'name'=>'admin', 'type'=>'admin','mobile'=>'090078601','email'=>'admin@admin.com',
            'password'=>'$2y$10$YZYAfvPZuUEr/vf5UMqndOkmgiuEsuyCfAkpqTceVP4tAIpbyTo5y','image'=>'','status'=>1
        ],
        ['id'=>2, 'name'=>'john', 'type'=>'admin','mobile'=>'090078601','email'=>'john@admin.com',
        'password'=>'$2y$10$YZYAfvPZuUEr/vf5UMqndOkmgiuEsuyCfAkpqTceVP4tAIpbyTo5y','image'=>'', 'status'=>1
        ],
        ['id'=>3, 'name'=>'smith', 'type'=>'admin','mobile'=>'090078601','email'=>'smith@admin.com',
        'password'=>'$2y$10$YZYAfvPZuUEr/vf5UMqndOkmgiuEsuyCfAkpqTceVP4tAIpbyTo5y','image'=>'','status'=>1
        ],
        ];

        DB::table('admins')->insert($adminRecords);

        // foreach($adminRecords as $key => $record){
        //     \App\Models\Admin::create($record);
        // }
    }
}
