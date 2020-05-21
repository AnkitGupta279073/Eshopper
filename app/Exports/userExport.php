<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class userExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::select('name','email')->where('status',1)->orderBy('id','DESC')->get();
        return $users;
    }
    public function headings(): array{
        return ["Name","Email"];
    }
}
