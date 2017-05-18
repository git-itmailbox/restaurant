<?php

use Illuminate\Database\Seeder;

class PaymentStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        NEW
//        UNCONFIRMED_WRONG
//        UNCONFIRMED_OK
//        CONFIRMED_WRONG
//        CONFIRMED_OK


//
//        DB::table('payment_statuses')->insert([
//            'name' => 'NEW',
//        ]);

        if(DB::table('payment_statuses')->get()->count() == 0){

            DB::table('payment_statuses')->insert([

                [
                    'name' => 'NEW',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'UNCONFIRMED_WRONG',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'UNCONFIRMED_OK',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
,
                [
                    'name' => 'CONFIRMED_WRONG',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'CONFIRMED_OK',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]

            ]);

        } else { echo "\e[31mTable is not empty, therefore NOT "; }

    }

}
