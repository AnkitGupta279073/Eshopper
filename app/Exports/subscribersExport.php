<?php

namespace App\Exports;

use App\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class subscribersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $subscriberData = NewsletterSubscriber::select('id','email','created_at')->orderBy('id','DESC')->where('status',1)->get();
    	return $subscriberData;
    }

    public function headings(): array{
        return ["id", "Email", "Created_at"];
    }
}
