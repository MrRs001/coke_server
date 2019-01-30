<?php

namespace App\Imports;

use App\Customer;

use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'customer_code' => $row[0],
            'name' => isset($row[1]) ? $row[1] : '',
            'sales_office' => isset($row[2]) ? $row[2] : '',
            'distribute_code' => isset($row[3]) ? $row[3] : '',
            'city' => isset($row[4]) ? $row[4] : '' ,
            'district' => isset($row[5]) ? $row[5] : '',
            'street' => isset($row[6]) ? $row[6] : '',
            'contact_first_name' => isset($row[7]) ? $row[7] : '',
            'sales_rep' => isset($row[8]) ? $row[8] : '',
            'telephone' => isset($row[9]) ? $row[9] : '',
            'mobile' => isset($row[10]) ? $row[10] : '',
            'trade_channel' => isset($row[11]) ? $row[11] : '',
            'customer_category' => isset($row[12]) ? $row[12] : '',
            'sub_trade_channel' => isset($row[13]) ? $row[13] : '',
            'key_acc' => isset($row[14]) ? $row[14] : ''
        ]);
    }
}
