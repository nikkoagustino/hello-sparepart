<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerModel extends Model
{
    use HasFactory;

    static function insert($request) {
        $insert = DB::table('tb_customer')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_customer')
                    ->orderBy('customer_code', 'ASC')
                    ->get();
        return $result;
    }

    static function getById($customer_code) {
        $result = DB::table('tb_customer')
                    ->where('customer_code', $customer_code)
                    ->first();
        return $result;
    }

    static function deleteCustomer($customer_code) {
        $delete = DB::table('tb_customer')
                    ->where('customer_code', $customer_code)
                    ->delete();
        return $delete;
    }

    static function editCustomer($request) {
        $update = DB::table('tb_customer')
                    ->where('customer_code', $request->customer_code)
                    ->update([
                        'customer_name' => $request->customer_name,
                        'address' => $request->address,
                        'phone_number_1' => $request->phone_number_1,
                        'phone_number_2' => $request->phone_number_2,
                        'contact_person' => $request->contact_person,
                        'limit' => $request->limit,
                    ]);
        return $update;
    }
}
