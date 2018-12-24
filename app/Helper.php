<?php 

namespace App;
use App\Model\Category; 

class Helper
{
	/**
	   * Coded by : Saurabh sahu
	   * Contact  : web.saurabhsahu@gmail.com
	   *
	Note : There are one more way to create Helper file that is loaded from composer.    
	*/	
    public static function categoryName($id)
    {
        $data = Category::where('id',$id)->first();
        return $data->name;    
    }
}