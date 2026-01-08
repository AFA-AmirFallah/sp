<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class provinces_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
            [ 'id' => 1, 'Country' => 'IRI', 'ProvinceName' => 'تهران', ],[ 'id' => 2, 'Country' => 'IRI', 'ProvinceName' => 'گيلان', ],[ 'id' => 3, 'Country' => 'IRI', 'ProvinceName' => 'آذربايجان شرقي ', ],[ 'id' => 4, 'Country' => 'IRI', 'ProvinceName' => 'خوزستان', ],[ 'id' => 5, 'Country' => 'IRI', 'ProvinceName' => 'فارس', ],[ 'id' => 6, 'Country' => 'IRI', 'ProvinceName' => 'اصفهان', ],[ 'id' => 7, 'Country' => 'IRI', 'ProvinceName' => 'خراسان رضوي ', ],[ 'id' => 8, 'Country' => 'IRI', 'ProvinceName' => 'قزوين', ],[ 'id' => 9, 'Country' => 'IRI', 'ProvinceName' => 'سمنان', ],[ 'id' => 10, 'Country' => 'IRI', 'ProvinceName' => 'قم', ],[ 'id' => 11, 'Country' => 'IRI', 'ProvinceName' => 'مركزي', ],[ 'id' => 12, 'Country' => 'IRI', 'ProvinceName' => 'زنجان', ],[ 'id' => 13, 'Country' => 'IRI', 'ProvinceName' => 'مازندران', ],[ 'id' => 14, 'Country' => 'IRI', 'ProvinceName' => 'گلستان', ],[ 'id' => 15, 'Country' => 'IRI', 'ProvinceName' => 'اردبيل', ],[ 'id' => 16, 'Country' => 'IRI', 'ProvinceName' => 'آذربايجان غربي', ],[ 'id' => 17, 'Country' => 'IRI', 'ProvinceName' => 'همدان', ],[ 'id' => 18, 'Country' => 'IRI', 'ProvinceName' => 'كردستان', ],[ 'id' => 19, 'Country' => 'IRI', 'ProvinceName' => 'كرمانشاه', ],[ 'id' => 20, 'Country' => 'IRI', 'ProvinceName' => 'لرستان', ],[ 'id' => 21, 'Country' => 'IRI', 'ProvinceName' => 'بوشهر', ],[ 'id' => 22, 'Country' => 'IRI', 'ProvinceName' => 'كرمان', ],[ 'id' => 23, 'Country' => 'IRI', 'ProvinceName' => 'هرمزگان', ],[ 'id' => 24, 'Country' => 'IRI', 'ProvinceName' => 'چهارمحال و بختياري ', ],[ 'id' => 25, 'Country' => 'IRI', 'ProvinceName' => 'يزد', ],[ 'id' => 26, 'Country' => 'IRI', 'ProvinceName' => 'سيستان و بلوچستان ', ],[ 'id' => 27, 'Country' => 'IRI', 'ProvinceName' => 'ايلام', ],[ 'id' => 28, 'Country' => 'IRI', 'ProvinceName' => 'كهگيلويه و بويراحمد ', ],[ 'id' => 29, 'Country' => 'IRI', 'ProvinceName' => 'خراسان شمالي ', ],[ 'id' => 30, 'Country' => 'IRI', 'ProvinceName' => 'خراسان جنوبي ', ],[ 'id' => 31, 'Country' => 'IRI', 'ProvinceName' => 'البرز', ]
        ]);
    }
}
