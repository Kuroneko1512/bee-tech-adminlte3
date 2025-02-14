<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\Customer;
use App\Models\District;
use App\Models\Province;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');
    
        // Lấy tất cả các tỉnh/thành phố đã có trong database
        $provinces = Province::all()->pluck('id')->toArray();
    
        for ($i = 0; $i < 20; $i++) {
            // Chọn ngẫu nhiên một tỉnh/thành phố từ danh sách các tỉnh/thành phố đã có
            $province_id = $faker->randomElement($provinces);
    
            // Chọn ngẫu nhiên một quận/huyện từ danh sách các quận/huyện của tỉnh/thành phố đã chọn
            $districts = District::where('province_id', $province_id)->pluck('id')->toArray();
            $district_id = $faker->randomElement($districts);
    
            // Chọn ngẫu nhiên một xã/phường từ danh sách các xã/phường của quận/huyện đã chọn
            $communes = Commune::where('district_id', $district_id)->pluck('id')->toArray();
            $commune_id = $faker->randomElement($communes);
    
            Customer::create([
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->numerify('09########'),
                'password' => Hash::make('Password@123'),
                'full_name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
                'address' => $faker->address,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'commune_id' => $commune_id,
                'status' => 'active',
                'flag_delete' => false
            ]);
        }
    }
}