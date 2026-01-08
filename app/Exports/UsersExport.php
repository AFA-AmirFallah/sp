<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserInfo::whereDate('CreateDate','>','2022-12-06')->whereDate('CreateDate','<=','2022-12-10')->get();
       // return  UserInfo::where('UserName', '09192228284')->get();

        
    }

}
