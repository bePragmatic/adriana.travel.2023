<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BoatBookingInfoDataTable;
use App\Models\BoatBookingInfo;
use App\Http\Start\Helpers;
use Validator;

class BoatBookingInfoController extends Controller
{
    //
    protected $helper;  // Global variable for instance of Helpers

    public function __construct()
    {
        $this->helper = new Helpers;
    }
    public function index(BoatBookingInfoDataTable $dataTable)
    {
       
        return $dataTable->render('admin.boat.booking_info');
    }
    public function delete(Request $request)
    {
        
        BoatBookingInfo::find($request->id)->delete();
       $this->helper->flash_message('success', 'Deleted Successfully'); 
         return redirect(ADMIN_URL.'/boat_booking_info');
     
    

    }
}
