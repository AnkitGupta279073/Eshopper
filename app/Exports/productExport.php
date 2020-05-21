<?php

namespace App\Exports;

use App\Product;
use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class productExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = Product::select('category_id','product_name','product_code','product_color','price')->where('status',1)->orderBy('id','DESC')->get();

        foreach($products as $key=>$product)
        {
        	$catName = Category::select('name')->where('id',$product->category_id)->first();
        	$products[$key]->category_id = $catName->name;
        }
        
        return $products;
    }

    public function headings(): array{
        return ["Category Name", "Product Name", "Product Code","Product Color","Price"];
    }
}
