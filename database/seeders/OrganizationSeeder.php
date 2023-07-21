<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Organization;
use App\Models\Host;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $host = new Host;
        $host->domain = 'comproaki.com';
        $host->save();


        $host = new Host;
        $host->domain = 'dos.dominio.com';
        $host->save();

        DB::table('organizations')->insert([
            'user_id' => 1, 'parent_id' => 1,'above_id' => null, 'host_id' => 1, 'level' => 1]);

        DB::table('organizations')->insert([
            'user_id' => 1, 'parent_id' => 1,'above_id' => null, 'host_id' => 2, 'level' => 1]);

        DB::table('organizations')->insert([
            'user_id' => 2, 'parent_id' => 1,'above_id' => 1, 'host_id' => 2, 'level' => 2]);

        DB::table('organizations')->insert([
            'user_id' => 3, 'parent_id' => 1,'above_id' => 1, 'host_id' => 1, 'level' => 2]);
    }
}
