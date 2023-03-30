<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use App\Models\Rooms;
use App\Models\Boat;
use App\Models\BoatBooking;
use App\Models\BoatBookingInfo;

use App\Models\Rating;
use App\Post;
use App\PostTranslation;
use Illuminate\Http\Request;
use DB;
use Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PagesController extends Controller
{

    /**
     * Returns Home Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $popularRooms = Rooms::wherePopular('Yes')->get();

        $rooms = $popularRooms->count() < 9
            ? Rooms::whereStatus('Listed')->get()->shuffle()->take(9)
            : Rooms::whereStatus('Listed')->wherePopular('Yes')->get()->shuffle()->take(9);

        $posts = Post::latest()->get()->take(3);


        return view('rogoznica.home', compact('rooms', 'posts'));
    }


    /**
     * Returns Home Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function explore()
    {
        return view('rogoznica.explore');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post_single($slug)
    {
        $post = PostTranslation::whereSlug($slug)->first();

        $parent = Post::findOrFail($post->post_id);

        return view('rogoznica.blog-single', compact('post', 'parent'));
    }

    public function rogoznica()
    {
        return view('rogoznica.rogoznica');
    }

    public function blog()
    {

        // $posts = Post::with('translations')->latest()->get();

        $posts = Post::paginate(6);

        // $posts = $posts->translate(app()->getLocale(), 'fallbackLocale');

        //return $posts;
        //  $paginate = $this->paginate($posts);
        //  $posts = $this->paginate($posts)->values();


        return view('rogoznica.blog', compact('posts'));
    }

    public function blog_single()
    {
        return view('rogoznica.blog-single');
    }

    public function service_and_activities()
    {
        return view('rogoznica.serviceandactivities');
    }

    public function contact_us()
    {
        return view('rogoznica.contact');
    }

    public function transfers()
    {
        return view('rogoznica.transfers');
    }
    public function checkout_success()
    {
        return view('rogoznica.checkout_success');
    }
    public function rentaboatOne()
    {
        $ratings=Rating::where('boat','one')->latest()->simplePaginate(25);
        return view('rogoznica.rent-a-boat-one', compact('ratings'));
    }
    public function rentaboatTwo()
    {
        $ratings=Rating::where('boat','two')->latest()->simplePaginate(25);
        return view('rogoznica.rent-a-boat-two', compact('ratings'));
    }
    public function rentboatform(Request $request)
    {
  //   $a  =  Boat::select('*');
    //  echo "<pre>";
    //  print_r($a);   die;
        
         // dd($request->all());die;
        $no_of_person = $request->guests;
        $checkIn_date = $request->date;
        $boat_type = $request->boat_type;
        if($boat_type == "rent-a-boat-one"){
            $boat_type_data = "Futurama";
        }
        else{
            $boat_type_data = "Rascal";
        }
 $booking_info   = BoatBooking::where('checkIn_date' , $checkIn_date)->join('managing_boat_price', 'managing_boat_price.id', '=', 'boat_booking.boat_id')->where('managing_boat_price.boat_type', $boat_type_data)->get();
    //dd($booking_info);
    if(count($booking_info) > 0)
    {
        return Response::json(array(
            'error'     => "true",
            'code'      =>  200,
            'message'   => "already booked"
        ), 200); 
       
    }
   
     $data = Boat::where('from_date', $checkIn_date)->where('to_date',$checkIn_date)->where('boat_type',$boat_type_data)->get();
       if(count($data)>=1)
        {


            return response()->json($data);
            
        }
        
        else{
       
            $data = DB::table('managing_boat_price')->select('*')->where(function ($query) use ($checkIn_date,$boat_type_data) {$query->where('from_date', '<=' , $checkIn_date)->where('to_date', '>=' , $checkIn_date)->where('boat_type', '=', $boat_type_data);})->get();

            return response()->json($data);
        }

       
       
    }
      public function rentboatformsubmit(Request $request)
       {
     
    // save data into a booking info table

     $boot_booking_info = new BootBookingInfo();
     $boot_booking_info->boat_booking_id	= $request->boat_booking_id;
     $boot_booking_info->first_name =$request->first_name;
     $boot_booking_info->last_name =$request->last_name;
     $boot_booking_info->email =$request->email;
     $boot_booking_info->phone=$request->phone;
     $boot_booking_info->zip_code=$request->zip_code;
     $boot_booking_info->country=$request->country;
     $boot_booking_info->city=$request->city;
     $boot_booking_info->address=$request->address;
     $boot_booking_info->date_of_birth=$request->date_of_birth;
     $boot_booking_info->message=$request->message; 
     $boot_booking_info->save();


     // save data into a boat booking table

     $boat_booking = new BoatBooking();
     $boat_booking->boat_id = $request->boat_id;
     $boat_booking->checkIn_date = $request->checkIn_date;
     $boat_booking->checkOut_date = $request->checkOut_date;
     $boat_booking->no_of_person = $request->no_of_person;
     $boat_booking->half_day_price = $request->half_day_price;
     $boat_booking->full_day_price	 = $request->full_day_price;
     $boat_booking->total = $request->total;
     $boat_booking->status = $request->status;
     $boat_booking->save();


   }
public function disabledate()
{
  //  echo "hi"; die;
 $data= Boat::select('*')->orderBy('from_date', 'Asc')->get();
 return response()->json($data);

}
   
}

