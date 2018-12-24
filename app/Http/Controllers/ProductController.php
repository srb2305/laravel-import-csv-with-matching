<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Collection;
use App\Model\Product;
use App\Model\Category; 
use Validator;
use Input;
use Auth;
use Excel;
use chunk;
use File;

class ProductController extends Controller
{
    /**
       * Coded by : Saurabh sahu
       * Contact  : web.saurabhsahu@gmail.com
       * 
    */

    public function index()
    {
    	$product = Product::paginate(10);
    	$data['product'] = $product;
        return view('product.index',compact('data'));
    }

    public function category()
    {
        $category = Category::paginate(10);
        $data['category'] = $category;
        return view('category.index',compact('data'));
    }

    public function parseImport(CsvImportRequest $request)
	{
	    $path = $request->file('csv_file')->getRealPath();
	    // To be continued...
	}

    public function store(Request $request)
    { // import product data
        $validator = Validator::make($request->all(), [
           'file_import' =>  'required|mimes:csv,xlsx,xls,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); 
        }

        if($request->file('file_import'))
        {
            $path = $request->file('file_import')->getRealPath();
            $data = Excel::load($path, function($reader)
            {
                })->get();

            if(!empty($data) && $data->count())
            {
                foreach ($data->toArray() as $row)
                {
                  if(!empty($row))
                  {
                    if(!empty($row['title'])){
                        $title = $row['title'];
                    }else{
                        $title = NULL;
                    }
                    if(!empty($row['sku'])){
                        $sku = $row['sku'];
                    }else{
                        $sku = NULL;
                    }
                    if(!empty($row['description'])){
                        $description = $row['description'];
                    }else{
                        $description = NULL;
                    }
                    if(!empty($row['price'])){
                        $price = $row['price'];
                    }else{
                        $price = NULL;
                    }
                    if(!empty($row['quantity'])){
                        $quantity = $row['quantity'];
                    }else{
                        $quantity = NULL;
                    }
                    if(!empty($row['category'])){
                        $category = $row['category'];
                    }else{
                        $category = NULL;
                    }
                   
                    $dataArray[] =
                    [
                      'title' 		=> $title,
                      'sku' 		=> $sku,
                      'description' => $description,
                      'price' 		=> $price,
                      'quantity' 	=> $quantity,
                      'category' => $category,
                    ];
                  }
                }
                if(!empty($dataArray))
                {
                   
                    $collection = collect($dataArray);   //turn data into collection
                    $chunks = $collection->chunk(1000); //chunk into smaller pieces
                    $chunks->toArray(); //convert chunk to array

                    //loop through chunks:
                    foreach($chunks as $chunk)
                    {
                      Product::insert($chunk->toArray()); //insert chunked data
                    }

                    // Product::insert($dataArray);
                    return back()->with('success','product import successfully');
                }
            }
       }
    }

    public function exportProduct(){
        $items = Product::select('title','sku','description','price','quantity','category')->get();
        Excel::create('products', function($excel) use($items) {
            $excel->sheet('ExportFile', function($sheet) use($items) {
                $sheet->fromArray($items);
          });
      })->export('csv');  //xlsx
    }
}