<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\CsvData;
use App\Model\Category;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class ImportController extends Controller
{
  /**
   * Coded by : Saurabh sahu
   * Contact  : web.saurabhsahu@gmail.com
   * 
   */

    public function getImport()
    {
        return view('import.import');
    }

    public function parseImport(CsvImportRequest $request)
    {
         $validator = Validator::make($request->all(), [
           'csv_file' =>  'required|mimes:csv,xlsx,xls,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); 
        }


        $path = $request->file('csv_file')->getRealPath();

        if ($request->has('header')) {
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('import.import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

    }

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $product = new Product();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                   
                    $catIdsAry = [];
                    if($field == 'category'){
                       $catAry =  explode('|', $row[$request->fields[$field]]);
                       foreach ($catAry as $key => $value) {
                           $checkCategory = Category::where('name',$value)->first();
                           if($checkCategory){
                            $carId = $checkCategory->id;
                           }else{
                             $category = new Category();
                             $category->name = $value;
                             $category->save();
                             $carId = $category->id;
                           }
                           $catIdsAry[] = $carId;
                           $catStr = implode(',',$catIdsAry);
                       }
                        $product->$field = $catStr;
                    }else{
                        $product->$field = $row[$request->fields[$field]];
                    }

                } else {
                    
                     $catIdsAry = [];
                    if($field == 'category'){
                       $catAry =  explode('|', $row[$request->fields[$index]]);
                       foreach ($catAry as $key => $value) {
                           $checkCategory = Category::where('name',$value)->first();
                           if($checkCategory){
                            $carId = $checkCategory->id;
                           }else{
                             $category = new Category();
                             $category->name = $value;
                             $category->save();
                             $carId = $category->id;
                           }
                           $catIdsAry[] = $carId;
                           $catStr = implode(',', $catIdsAry);
                       }
                        $product->$field = $catStr;
                    }else{
                        $product->$field = $row[$request->fields[$index]];
                    }


                }
            }
            $product->save();
        }

        return view('import.import_success');
    }

}
