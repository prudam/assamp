<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TopCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('top_category')->insert([
        	[
            	'top_cate_name' => 'MEKHELA CHADDAR',
                'slug' => strtolower(Str::slug('MEKHELA CHADDAR', '-')),
                'status' => 1,
            	'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            	'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
	    	],	
	    	[
            	'top_cate_name' => 'SAREE',
                'slug' => strtolower(Str::slug('SAREE', '-')),
                'status' => 1,
            	'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            	'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
	    	],    
            [
                'top_cate_name' => 'KURTI',
                'slug' => strtolower(Str::slug('KURTI', '-')),
                'status' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ],  
            [
                'top_cate_name' => 'BELL & BRASS METAL',
                'slug' => strtolower(Str::slug('BELL BRASS METAL', '-')),
                'status' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]
		]);
    }
}
