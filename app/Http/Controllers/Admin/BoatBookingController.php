<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Start\Helpers;
use App\Http\Controllers\Controller;
use App\DataTables\BoatBookingDataTable;
use App\Models\BoatBooking;
use Validator;

class BoatBookingController extends Controller
{
    //
    protected $helper;  // Global variable for instance of Helpers

    public function __construct()
    {
        $this->helper = new Helpers;
    }
    public function index(BoatBookingDataTable $dataTable)
    {
      //  echo "hi";
      //  die;
       
        return $dataTable->render('admin.boat.booking_view');
    }
    public function delete(Request $request)
    {
        
        BoatBooking::find($request->id)->delete();
        $this->helper->flash_message('success', 'Deleted Successfully'); 
        return redirect(ADMIN_URL.'/boat_booking');
     
    

    }
    public function update(Request $request, $id)
    {
      if((!$_POST))
      {
     
      $data=BoatBooking::where('id', $id)->get(); 
      return view('admin.boat.boat_edit', compact('data'));
      }
      else{
        if($request->submit)
        {
          $request->validate([ 
          'checkIn_date' => 'required', 
          'no_of_person' => 'required', 
          'total' => 'required', 
          'boat_type' =>'required'
            
        ]);
       

          $boatbooking = BoatBooking::find($id);  
        
          $boatbooking->checkIn_date= $request['checkIn_date'];
          $boatbooking->no_of_person= $request['no_of_person'];  
          $boatbooking->half_day_price= $request['half_day_price'];  
          $boatbooking->full_day_price = $request['full_day_price'];  
          $boatbooking->total =$request['total'];
          $boatbooking->boat_type =$request['boat_type'];

    
          $boatbooking->save();  
          $this->helper->flash_message('success', 'Added Successfully'); // Call flash message function
          return redirect(ADMIN_URL.'/boat_booking');
        }
        else{
          return redirect(ADMIN_URL.'/boat_booking');

      }
      }
    }
}
