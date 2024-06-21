<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTanswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('tuser')->get();

        foreach ($users as $user) {
            DB::table('tanswer')
                ->where('idUser', $user->idUser)
                ->update([
                    'dni' => $user->numberDni,
                    'firstName' => $user->firstName,
                    'surName' => $user->surName,
                ]);
        }
    }
}
