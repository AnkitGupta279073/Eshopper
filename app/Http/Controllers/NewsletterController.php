<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterSubscriber;
use App\Exports\subscribersExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Excel;
class NewsletterController extends Controller 
{
    public function checkSubscriber(Request $request)
    {
    	if($request->ajax())
    	{
    		$data =  $request->all();
    		$subscriberCount = NewsletterSubscriber::where('email',$data['subscriber_email'])->count();
    		if($subscriberCount > 0)
    		{
    			echo "exit";
    		}
    		else
    		{
    			// add newletters subscriber
    			$newletters = new NewsletterSubscriber();
    			$newletters->email = $data['subscriber_email'];
    			$newletters->status = 1;
    			$newletters->save();
    			echo "save";
    		}
    	}
    }

    public function viewNewslettersSubscriber()
    {
    	$viewNewslettersSubscriber = NewsletterSubscriber::orderBy('id','DESC')->get();
    	return view('admin.newsletters.view_newsletters')->with(compact('viewNewslettersSubscriber'));
    }

    public function updateNewsLettersStatus($id,$status)
    {
    	NewsletterSubscriber::where('id',$id)->update(['status'=>$status]);
    	return redirect()->back()->with('flash_message_success','Newslertters Status has been updated.');
    }
     public function deleteNewsLettersStatus($id)
    {
    	NewsletterSubscriber::where('id',$id)->delete();
    	return redirect()->back()->with('flash_message_success','Records has been deleted successfully.');
    }

    // public function exportNewslettersEmails()
    // {
    	
    // 	return Excel::download(new DataExport,'newsletters.xlsx');
    	
    // 	// return Excel::store('subscriber'.rand(),function($excel) use($subscriberData){

    // 	// 	$excel->sheet('mysheet',function($sheet) use($subscriberData){

    // 	// 		$sheet->fromArray($subscriberData);
    // 	// 	});
    // 	// })->download('xlsx');

    // 	// return Excel::download($subscriberData, 'disney.xlsx');



    // }

    public function exportNewslettersEmails()
    {
        
        return Excel::download(new subscribersExport,'newsletters.xlsx');
        
    }
}

/**
 * 
 */
// class DataExport implements FromCollection, WithHeadings
// {
	
// 	function collection()
// 	{
// 		$subscriberData = NewsletterSubscriber::select('id','email','created_at')->orderBy('id','DESC')->where('status',1)->get();
//     	// $subscriberData = json_decode(json_encode($subscriberData));
//     	return $subscriberData;
// 	}

// 	public function headings(): array{
//         return ["id", "Email", "Created_at"];
//     }
// }
