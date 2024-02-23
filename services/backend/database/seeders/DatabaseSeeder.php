<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Interview;
use App\Models\Selection;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // ユーザーを3人作成
        for ($i = 1; $i <= 3; $i++) {
            $user = User::factory()->create([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@test.com',
                'password' => bcrypt('password'),
            ]);

            // $companies = Company::factory(5)->create([
            //     'user_id' => $user->id,
            // ]);

            // foreach ($companies as $company) {
            //     Selection::factory()->create([
            //         'company_id' => $company->id,
            //     ]);

            //     Interview::factory(3)->create([
            //         'company_id' => $company->id,
            //     ]);
            // }
        }
    }
}
