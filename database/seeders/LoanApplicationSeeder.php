<?php

use Illuminate\Database\Seeder;

class LoanApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\LoanApplication::class, 10)->create()->each(function($post){
            $post->save();
            });
    }
}
