<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Http\Start\Helpers;
use App\DataTables\BoatsDataTable;
use Validator;

class BoatController extends Controller
{

    protected $helper;  // Global variable for instance of Helpers

    public function __construct()
    {
        $this->helper = new Helpers;
    }
 
    public function index(BoatsDataTable $dataTable)
    {
        
        return $dataTable->render('admin.boat.view');
    }

    public function store(Request $request)
{
  


if($request->submit)
{
   

       
        $check_boat_data = Boat::where('to_date', '<=', $request->to_date)->where('from_date', '>=', $request->to_date)->where('boat_type', '=', $request->boat_type)->get();
        $check_boat_data_1 = Boat::where('to_date', '<=', $request->from_date)->where('from_date', '>=', $request->from_date)->where('boat_type', '=', $request->boat_type)->get();
      
       
        
        if(count($check_boat_data) >= 1 ){
            $this->helper->flash_message('error', 'you have Already set price for this date'); 
            return redirect(ADMIN_URL.'/add_boat');
        }

        if(count($check_boat_data_1) >= 1){
            $this->helper->flash_message('error', 'you have Already set price for this date'); 
            return redirect(ADMIN_URL.'/add_boat');
        }

        $check_condition=Boat::where('from_date', '=', $request->from_date)->where('to_date', '=', $request->to_date)->where('boat_type', '=', $request->boat_type)->get();
        if(count($check_condition)>0)
{
        $this->helper->flash_message('error', 'you have Already set price for these dates'); 
        return redirect(ADMIN_URL.'/add_boat');
}
  

$request->validate([ 
        'from_date' => 'required', 
        'to_date' => 'required', 
        'full_day_price' => 'required', 
         'half_day_price' => 'required', 
         'season_name' => 'required',
        'boat_type' => 'required',
    
]);

$boat = new Boat;  
$boat->from_date= $request['from_date'];  
$boat->to_date= $request['to_date'];  
$boat->half_day_price= $request['half_day_price'];  
$boat->full_day_price = $request['full_day_price'];  
$boat->season_name =$request['season_name'];
$boat->boat_type =$request['boat_type'];

 
$boat->save();  
$data=Boat::all();
$this->helper->flash_message('success', 'Added Successfully'); // Call flash message function
return redirect(ADMIN_URL.'/manage_boat_price');
}
else{
    return redirect(ADMIN_URL.'/manage_boat_price');  
}
 }
    public function edit($id)  
    {  
          
    }  
    public function update(Request $request, $id)  
    {  
        if((!$_POST))
        {
        $data=Boat::find($id); 
        return view('admin.boat.edit', compact('data'));
     
        }
        else{

            if($request->submit)
            {
            $request->validate([ 
                'from_date' => 'required', 
                'to_date' => 'required', 
                  'full_day_price' => 'required', 
                    'half_day_price' => 'required', 
                    'season_name' => 'required', 
                    'boat_type'=>'required',
                
            ]);
     
     
        $boat = Boat::find($id);  
        $check_condition=Boat::where('from_date', '=', $request->from_date)->where('to_date', '=', $request->to_date)->where('boat_type', '=', $request->boat_type)->where('id', '!=',$id)->get();
        if(count($check_condition)>0)
{
        $this->helper->flash_message('error', 'you have Already set price for these dates'); 
        return redirect(ADMIN_URL.'/add_boat');

}
  
$check_boat_data = Boat::where('to_date', '<=', $request->to_date)->where('from_date', '>=', $request->to_date)->where('boat_type', '=', $request->boat_type)->where('id', '!=',$id)->get();
$check_boat_data_1 = Boat::where('to_date', '<=', $request->from_date)->where('from_date', '>=', $request->from_date)->where('boat_type', '=', $request->boat_type)->where('id', '!=',$id)->get();



if(count($check_boat_data) >= 1 ){
    $this->helper->flash_message('error', 'you have Already set price for this date'); 
    return redirect(ADMIN_URL.'/add_boat');
}

if(count($check_boat_data_1) >= 1){
    $this->helper->flash_message('error', 'you have Already set price for this date'); 
    return redirect(ADMIN_URL.'/add_boat');
}
 
        $boat->from_date= $request['from_date'];  
        $boat->to_date= $request['to_date'];  
        $boat->half_day_price= $request['half_day_price'];  
        $boat->full_day_price = $request['full_day_price'];  
        $boat->season_name =$request['season_name'];
        $boat->boat_type =$request['boat_type'];


        $boat->save();  
        $this->helper->flash_message('success', 'Updated Successfully'); 
        return redirect(ADMIN_URL.'/manage_boat_price');
        }
        else{
            return redirect(ADMIN_URL.'/manage_boat_price');

        }
        } 
      
   }
   

    public function delete(Request $request)
    {
        
        Boat::find($request->id)->delete();
         $this->helper->flash_message('success', 'Deleted Successfully'); 
         return redirect(ADMIN_URL.'/manage_boat_price');
     
    

    }
    public function add()
    {
        return view('admin.boat.manage_boat_price');
    }
    
}
