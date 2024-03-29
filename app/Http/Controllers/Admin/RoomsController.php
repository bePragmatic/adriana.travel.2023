<?php

/**
 * Rooms Controller
 *
 * @package     Tempus media | Booking
 * @subpackage  Controller
 * @category    Rooms
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\RoomsDataTable;
use App\Models\BedType;
use App\Models\PropertyType;
use App\Models\RoomType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Amenities;
use App\Models\AmenitiesType;
use App\Models\RoomsPhotos;
use App\Models\Rooms;
use App\Models\User;
use App\Models\RoomsAddress;
use App\Models\RoomsDescription;
use App\Models\RoomsDescriptionLang;
use App\Models\RoomsPrice;
use App\Models\RoomDayPrice;
use App\Models\RoomsStepsStatus;
use App\Models\Reservation;
use App\Models\SavedWishlists;
use App\Models\SpecialOffer;
use App\Models\Reviews;
use App\Models\Payouts;
use App\Models\HostPenalty;
use App\Models\ImportedIcal;
use App\Models\Calendar;
use App\Models\Messages;
use App\Models\PayoutPreferences;
use App\Models\RoomsBeds;
use App\Http\Helper\PaymentHelper;
use App\Http\Start\Helpers;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmailController;
use Validator;
use App\Models\RoomsPriceRules;
use App\Models\RoomsAvailabilityRules;
use Session;
use DB;

class RoomsController extends Controller
{


    protected $payment_helper; // Global variable for Helpers instance

    protected $helper;  // Global variable for instance of Helpers

    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
        $this->helper = new Helpers;
    }

    /**
     * Load Datatable for Rooms
     *
     * @param array $dataTable Instance of RoomsDataTable
     * @return datatable
     */
    public function index(RoomsDataTable $dataTable)
    {
        return $dataTable->render('admin.rooms.view');
    }
	
	/**
	  * Arry of date between 2 dates*/
	  
	public function getDatesFromRange($start, $end, $format='Y-m-d') {
        return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
      },
       range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
       }

    /**
     * Add a New Room
     *
     * @param array $request Input values
     * @return redirect     to Rooms view
     */
    public function add(Request $request)
    {
        if (!$_POST) {
            $bedrooms = [];
            $bedrooms[0] = 'Studio';
            for ($i = 1; $i <= 10; $i++)
                $bedrooms[$i] = $i;

            $beds = [];
            for ($i = 1; $i <= 16; $i++)
                $beds[$i] = ($i == 16) ? $i . '+' : $i;

            $bathrooms = [];
            $bathrooms[0] = 0;
            for ($i = 0.5; $i <= 8; $i += 0.5)
                $bathrooms["$i"] = ($i == 8) ? $i . '+' : $i;

            $accommodates = [];
            for ($i = 1; $i <= 16; $i++)
                $accommodates[$i] = ($i == 16) ? $i . '+' : $i;

            $data['bedrooms'] = $bedrooms;
            $data['beds'] = $beds;
            $data['bed_type'] = BedType::active_all();
            // $data['bed_type']      = BedType::where('status','Active')->pluck('name','id');
            $data['bathrooms'] = $bathrooms;
            $data['property_type'] = PropertyType::where('status', 'Active')->pluck('name', 'id');
            $data['room_type'] = RoomType::where('status', 'Active')->pluck('name', 'id');
            $data['accommodates'] = $accommodates;
            $data['country'] = Country::pluck('long_name', 'short_name');
            $data['amenities'] = Amenities::active_all();
            $data['amenities_type'] = AmenitiesType::active_all();
            $data['users_list'] = User::select('id', DB::raw('CONCAT(id," - ",first_name) AS first_name'))->whereStatus('Active')->pluck('first_name', 'id');

            $singlebedtype = BedType::where('status', 'Active')->limit(4)->get();
            $single_bed_type = [];
            foreach ($singlebedtype as $key => $value) {
                $singlebedtype[$key]->count = 0;
                $url_array = array('id' => @$value->id, 'name' => @$value->name, 'count' => 0, 'icon' => @$value->icon);
                $single_bed_type[] = @$url_array;
            }

            $firstbedtype = BedType::where('status', 'Active')->limit(4)->get();
            $first_bed_type = [];
            foreach ($firstbedtype as $key1 => $value1) {
                $firstbedtype[$key1]->count = 0;
                $url_array1 = array('id' => @$value1->id, 'name' => @$value1->name, 'count' => 0, 'icon' => @$value1->icon);
                $first_bed_type[1][] = @$url_array1;
            }

            $bathrooms = BedType::where('status', 'Active')->limit(4)->get();
            $bath_rooms = [];
            foreach ($bathrooms as $key => $abc) {
                $bathrooms[$key]->count = 0;
                $url_array = array('bathrooms' => @$batrooms_value);
                $bath_rooms[0][@$abc->id] = @$url_array;
            }

            $commonbedtype = BedType::where('status', 'Active')->limit(4)->get();
            $common_bed_type = [];
            foreach ($commonbedtype as $key => $abc) {
                $url_array = array('id' => @$abc->id, 'name' => @$abc->name, 'count' => 0, 'icon' => @$abc->icon, 'bathrooms' => @$batrooms_value);
                $common_bed_type[] = @$url_array;
            }

            // dd($first_bed_type);

            $data['get_single_bed_type'] = $single_bed_type;
            $data['first_bed_type1'] = $first_bed_type;
            //dd($data['first_bed_type1']);
            $data['get_common_bed_type'] = $common_bed_type;
            $data['first_bed_type'] = BedType::where('status', 'Active')->limit(4)->get();

            $data['get_bathrooms'] = $bath_rooms;
            $data['get_common_bathrooms'] = $bath_rooms;
            $data['firstbedtypeid'] = BedType::where('status', 'Active')->first()->id;

            $data['length_of_stay_options'] = Rooms::getLenghtOfStayOptions();
            $data['availability_rules_months_options'] = Rooms::getAvailabilityRulesMonthsOptions();

            return view('admin.rooms.add', $data);
        } else if ($_POST) {

            //dd($request->all());
            $photos_uploaded = array();
            if (UPLOAD_DRIVER == 'cloudinary') {
                if (isset($_FILES["photos"]["name"])) {
                    foreach ($_FILES["photos"]["error"] as $key => $error) {
                        $tmp_name = $_FILES["photos"]["tmp_name"][$key];

                        $name = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);

                        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                        $name = time() . $key . '_.' . $ext;

                        if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                            $c = $this->helper->cloud_upload($tmp_name);
                            if ($c['status'] != "error") {
                                $name = $c['message']['public_id'];
                            } else {
                                flash_message('danger', $c['message']); // Call flash message function
                                // return redirect(ADMIN_URL.'/rooms');
                                return redirect()->back();

                            }
                            $photos_uploaded[] = $name;
                        }
                    }
                }
            }

            $rooms = new Rooms;

            $rooms->user_id = $request->user_id;
            $rooms->calendar_type = 'Always';
            $rooms->bedrooms = $request->bedrooms;
            $rooms->bathrooms = $request->bathrooms;
            $rooms->bathroom_shared = $request->bathroom_shared;
            $rooms->property_type = $request->property_type;
            $rooms->room_type = $request->room_type;
            $rooms->accommodates = $request->accommodates;
            $rooms->name = $request->name[0];

            $search = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
            $count = preg_match($search, $request->video);
            if ($count == 1) {
                $replace = 'https://www.youtube.com/embed/$2';
                $video = preg_replace($search, $replace, $request->video);
                $rooms->video = $video;
            } else {
                $rooms->video = $request->video;
            }

            $rooms->sub_name = RoomType::find($request->room_type)->name . ' in ' . $request->city;
            $rooms->summary = $request->summary[0];
            $rooms->amenities = ($request->amenities) ? implode(',', @$request->amenities) : $request->amenities;
            $rooms->booking_type = $request->booking_type;
            $rooms->started = 'Yes';
            $rooms->status = 'Listed';
            $rooms->verified = 'Approved';
            $rooms->cancel_policy = $request->cancel_policy;

            $rooms->save();

            $rooms_address = new RoomsAddress;

            $latt = $request->latitude;
            $longg = $request->longitude;
            if ($latt == '' || $longg == '') {
                $address = $request->address_line_1 . ' ' . $request->address_line_2 . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country;
                $latlong = $this->latlong($address);

                $latt = $latlong['lat'];
                $longg = $latlong['long'];
            }

            $rooms_address->room_id = $rooms->id;
            $rooms_address->address_line_1 = $request->address_line_1;
            $rooms_address->address_line_2 = $request->address_line_2;
            $rooms_address->city = $request->city;
            $rooms_address->state = $request->state;
            $rooms_address->country = $request->country;
            $rooms_address->postal_code = $request->postal_code;
            $rooms_address->latitude = $latt;
            $rooms_address->longitude = $longg;

            $rooms_address->save();

            $rooms_description = new RoomsDescription;
            $rooms_description->room_id = $rooms->id;
            $rooms_description->space = $request->space[0];
            $rooms_description->access = $request->access[0];
            $rooms_description->interaction = $request->interaction[0];
            $rooms_description->notes = $request->notes[0];
            $rooms_description->house_rules = $request->house_rules[0];
            $rooms_description->neighborhood_overview = $request->neighborhood_overview[0];
            $rooms_description->transit = $request->transit[0];
            $rooms_description->save();

            $count = count($request->name);

            for ($i = 1; $i < $count; $i++) {
                $lan_description = new RoomsDescriptionLang;

                $lan_description->room_id = $rooms->id;
                $lan_description->lang_code = $request->language[$i - 1];
                $lan_description->name = $request->name[$i];
                $lan_description->summary = $request->summary[$i];
                $lan_description->space = $request->space[$i];
                $lan_description->access = $request->access[$i];
                $lan_description->interaction = $request->interaction[$i];
                $lan_description->notes = $request->notes[$i];
                $lan_description->house_rules = $request->house_rules[$i];
                $lan_description->neighborhood_overview = $request->neighborhood_overview[$i];
                $lan_description->transit = $request->transit[$i];
                $lan_description->save();

            }

            if (@$request->bed_count != '') {
                foreach (@$request->bed_count as $k => $value) {
                    //dd($request->bed_types_name[$k]);
                    $alread_bed_available = RoomsBeds::where('room_id', $rooms->id)->where('bed_room_no', $value)->where('bed_id', $request->bed_id[$k])->first();
                    if ($alread_bed_available) {
                        $rooms_bedrooms = RoomsBeds::find($alread_bed_available->id);
                    } else {
                        $rooms_bedrooms = new RoomsBeds;

                    }
                    $rooms_bedrooms->room_id = $rooms->id;
                    $rooms_bedrooms->bed_room_no = $value;
                    $rooms_bedrooms->bed_id = $request->bed_id[$k];
                    $rooms_bedrooms->count = $request->bed_types_name[$k];
                    $rooms_bedrooms->save();

                }
            }

            //update Common Rooms beds
            foreach (@$request->common_bed_count as $k => $value) {
                //dd($request->bed_types_name[$k]);
                $alread_bed_available = RoomsBeds::where('room_id', $rooms->id)->where('bed_room_no', $value)->where('bed_id', $request->common_bed_id[$k])->first();
                if ($alread_bed_available) {
                    $rooms_bedrooms = RoomsBeds::find($alread_bed_available->id);
                } else {
                    $rooms_bedrooms = new RoomsBeds;

                }
                $rooms_bedrooms->room_id = $rooms->id;
                $rooms_bedrooms->bed_room_no = $value;
                $rooms_bedrooms->bed_id = $request->common_bed_id[$k];
                $rooms_bedrooms->count = $request->common_bed_types_name[$k];
                $rooms_bedrooms->save();

            }

            $rooms_price = new RoomsPrice;

            $rooms_price->room_id = $rooms->id;
            // $rooms_price->night = $request->night;
            $monthy_night_prices = array(
                'january' => $request->night,
                'february' => $request->night,
                'march' => $request->night,
                'april' => $request->night,
                'may' => $request->night,
                'june' => $request->night,
                'july' => $request->night,
                'august' => $request->night,
                'september' => $request->night,
                'october' => $request->night,
                'november' => $request->night,
                'december' => $request->night,
            );

            $monthy_night_prices = json_encode($monthy_night_prices );

            
            $rooms_price->night = $monthy_night_prices;

            // $rooms_price->week             = $request->week;
            // $rooms_price->month            = $request->month;
            $rooms_price->cleaning = $request->cleaning;
            $rooms_price->additional_guest = $request->additional_guest;
            $rooms_price->guests = ($request->additional_guest) ? $request->guests : '0';
            $rooms_price->security = $request->security;
            $rooms_price->weekend = $request->weekend;
            $rooms_price->currency_code = $request->currency_code;

            $rooms_price->save();
			
			//Room Per Day value
			
			$room = $rooms->id;
			$room_price_details = new RoomDayPrice;
			$from_room_count = array_unique($request->from_date); 
            for ($i = 0; $i < count($from_room_count); $i++){
			 $date1=date_create($from_room_count[$i]);
             $date2=date_create($request->to_date[$i]);
             $diff=date_diff($date1,$date2);
             $dif= $diff->format("%a");
              if($dif ==1){
					RoomDayPrice::create(['from_date'=>$from_room_count[$i], 'to_date'=>$request->to_date[$i],'price'=>$request->price[$i],'room_id'=>$room]);
				}
				else{ 
				$dates = $this->getDatesFromRange( $from_room_count[$i],$request->to_date[$i]);
				foreach($dates as $k => $selected_dates){
				$newdate = date("Y-m-d",strtotime ( '+1 day' , strtotime ($selected_dates) )) ;
				  //if($k % 2 == 0){
				  $check_dates=RoomDayPrice::where('from_date','=', $selected_dates)->where('to_date', '=',$newdate)->where('room_id', '=',$room)->get();
		          if(count($check_dates) == 0){
				  RoomDayPrice::create(['from_date'=>$selected_dates, 'to_date'=>$newdate,'price'=>$request->price[$i],'room_id'=>$room]);
				  }
				//}				  
		       }
		     }
			}
			// Image upload
            if (isset($_FILES["photos"]["name"])) {
                foreach ($_FILES["photos"]["error"] as $key => $error) {
                    $tmp_name = $_FILES["photos"]["tmp_name"][$key];

                    $name = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);

                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    $name = time() . $key . '_.' . $ext;

                    $filename = dirname($_SERVER['SCRIPT_FILENAME']) . '/images/rooms/' . $rooms->id;

                    if (!file_exists($filename)) {
                        mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/images/rooms/' . $rooms->id, 0777, true);
                    }

                    if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {

                        if (UPLOAD_DRIVER == 'cloudinary') {
                            $name = @$photos_uploaded[$key];
                        } else {

                            if ($ext == 'gif') {

                                move_uploaded_file($tmp_name, "images/rooms/" . $rooms->id . "/" . $name);
                            } else {

                                if (move_uploaded_file($tmp_name, "images/rooms/" . $rooms->id . "/" . $name)) {
                                    $this->helper->compress_image("images/rooms/" . $rooms->id . "/" . $name, "images/rooms/" . $rooms->id . "/" . $name, 80, 1440, 960);
                                    $this->helper->compress_image("images/rooms/" . $rooms->id . "/" . $name, "images/rooms/" . $rooms->id . "/" . $name, 80, 1349, 402);
                                    $this->helper->compress_image("images/rooms/" . $rooms->id . "/" . $name, "images/rooms/" . $rooms->id . "/" . $name, 80, 450, 250);
                                }
                            }
                        }
                        $photos = new RoomsPhotos;
                        $photos->room_id = $rooms->id;
                        $photos->name = $name;
                        $photos->save();
                    }
                }
                // $photosfeatured = RoomsPhotos::where('room_id',$rooms->id);
                // if($photosfeatured->count() != 0){
                // $photos_featured = RoomsPhotos::where('room_id',$rooms->id)->where('featured','Yes');
                //     if($photos_featured->count() == 0){
                //         $photos = RoomsPhotos::where('room_id',$rooms->id)->first();
                //         $photos->featured = 'Yes';
                //         $photos->save();
                //     }
                // }
            }

            $rooms_steps = new RoomsStepsStatus;

            $rooms_steps->room_id = $rooms->id;
            $rooms_steps->basics = 1;
            $rooms_steps->description = 1;
            $rooms_steps->location = 1;
            $rooms_steps->photos = 1;
            $rooms_steps->pricing = 1;
            $rooms_steps->calendar = 1;

            $rooms_steps->save();

            $length_of_stay_rules = $request->length_of_stay ?: array();
            foreach ($length_of_stay_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $rooms->id,
                        'type'    => 'length_of_stay',
                    ];
                } else {
                    $check = [
                        'room_id' => $rooms->id,
                        'type'    => 'length_of_stay',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $rooms->id;
                $price_rule->type = 'length_of_stay';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            $early_bird_rules = $request->early_bird ?: array();
            foreach ($early_bird_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $rooms->id,
                        'type'    => 'early_bird',
                    ];
                } else {
                    $check = [
                        'room_id' => $rooms->id,
                        'type'    => 'early_bird',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $rooms->id;
                $price_rule->type = 'early_bird';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            $last_min_rules = $request->last_min ?: array();
            foreach ($last_min_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $rooms->id,
                        'type'    => 'last_min',
                    ];
                } else {
                    $check = [
                        'room_id' => $rooms->id,
                        'type'    => 'last_min',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $rooms->id;
                $price_rule->type = 'last_min';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            $availability_rules = $request->availability_rules ?: array();
            foreach ($availability_rules as $rule) {
                if (@$rule['edit'] == 'true') {
                    continue;
                }
                $check = [
                    'id' => @$rule['id'] ?: '',
                ];
                $availability_rule = RoomsAvailabilityRules::firstOrNew($check);
                $availability_rule->room_id = $rooms->id;
                $availability_rule->start_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['start_date'], PHP_DATE_FORMAT));
                $availability_rule->end_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['end_date'], PHP_DATE_FORMAT));
                $availability_rule->minimum_stay = @$rule['minimum_stay'] ?: null;
                $availability_rule->maximum_stay = @$rule['maximum_stay'] ?: null;
                $availability_rule->type = @$rule['type'] != 'prev' ? @$rule['type'] : @$availability_rule->type;
                $availability_rule->save();
            }
            $rooms_price = RoomsPrice::find($rooms->id);
            $rooms_price->minimum_stay = $request->minimum_stay ?: null;
            $rooms_price->maximum_stay = $request->maximum_stay ?: null;
            $rooms_price->save();

            flash_message('success', 'Room Added Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else {
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        }
    }

    //update validation function
    public function update_price(Request $request)
    {

        $minimum_amount = $this->payment_helper->currency_convert(DEFAULT_CURRENCY, $request->currency_code, MINIMUM_AMOUNT);
        $currency_symbol = Currency::whereCode($request->currency_code)->first()->original_symbol;
        if (isset($request->night) || isset($request->week) || isset($request->month)) {
            $night_price = $request->night;
            $week_price = $request->week;
            $month_price = $request->month;

            // all error validation check
            if (isset($request->night) && isset($request->week) && isset($request->month)) {
                if ($night_price < $minimum_amount && $week_price < $minimum_amount && $month_price < $minimum_amount) {
                    return json_encode(['success' => 'all_error', 'msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol . $minimum_amount]), 'attribute' => 'price', 'currency_symbol' => $currency_symbol, 'min_amt' => $minimum_amount]);

                }
            }
            // night validation check
            if (isset($request->night)) {
                $night_price = $request->night;
                if ($night_price < $minimum_amount) {
                    return json_encode(['success' => 'night_false', 'msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol . $minimum_amount]), 'attribute' => 'price', 'currency_symbol' => $currency_symbol, 'min_amt' => $minimum_amount, 'val' => $night_price]);
                } else {
                    return json_encode(['success' => 'true', 'msg' => 'true']);
                }
            } // week validation check
            elseif (isset($request->week) && @$request->week != '0') {
                $week_price = $request->week;
                if ($week_price < $minimum_amount) {
                    return json_encode(['success' => 'week_false', 'msg' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => $currency_symbol . $minimum_amount]), 'attribute' => 'week', 'currency_symbol' => $currency_symbol, 'val' => $week_price]);
                } else {
                    return json_encode(['success' => 'true', 'msg' => 'true']);
                }
            } // month validation check
            elseif (isset($request->month) && @$request->month != '0') {
                $month_price = $request->month;
                if ($month_price < $minimum_amount) {
                    return json_encode(['success' => 'month_false', 'msg' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => $currency_symbol . $minimum_amount]), 'attribute' => 'month', 'currency_symbol' => $currency_symbol, 'val' => $month_price]);
                } else {
                    return json_encode(['success' => 'true', 'msg' => 'true']);
                }

            } else {
                return json_encode(['success' => 'true', 'msg' => 'true']);
            }
        }


    }

    /**
     * Update Room Details
     *
     * @param array $request Input values
     * @return redirect     to Rooms View
     */
    public function update(Request $request, CalendarController $calendar)
    {
		
		// dd( $calendar);
        $rooms_id = Rooms::find($request->id);
        if (empty($rooms_id)) abort('404');
        if (!$_POST) {
            $bedrooms = [];
            $bedrooms[0] = 'Studio';
            for ($i = 1; $i <= 10; $i++)
                $bedrooms[$i] = $i;

            $beds = [];
            for ($i = 1; $i <= 16; $i++)
                $beds[$i] = ($i == 16) ? $i . '+' : $i;

            $bathrooms = [];
            $bathrooms[0] = 0;
            for ($i = 0.5; $i <= 8; $i += 0.5)
                $bathrooms["$i"] = ($i == 8) ? $i . '+' : $i;

            $accommodates = [];
            for ($i = 1; $i <= 16; $i++)
                $accommodates[$i] = ($i == 16) ? $i . '+' : $i;

            $data['bedrooms'] = $bedrooms;
            $data['beds'] = $beds;
            $data['bed_type'] = BedType::active_all();
            // $data['bed_type']      = BedType::where('status','Active')->pluck('name','id');
            $data['bathrooms'] = $bathrooms;
            $data['property_type'] = PropertyType::where('status', 'Active')->pluck('name', 'id');
            $data['room_type'] = RoomType::where('status', 'Active')->pluck('name', 'id');
            $data['lan_description'] = RoomsDescriptionLang::where('room_id', $request->id)->get();
            $data['accommodates'] = $accommodates;
            $data['country'] = Country::pluck('long_name', 'short_name');
            $data['amenities'] = Amenities::active_all();
            $data['amenities_type'] = AmenitiesType::active_all();
            $data['users_list'] = User::pluck('first_name', 'id');
            $data['room_id'] = $request->id;
            $data['result'] = Rooms::find($request->id);

            $data['get_single_bed_type'] = $data['result']->get_single_bed_type;
            $data['first_bed_type1'] = $data['result']->get_first_bed_type;
            //dd($data['first_bed_type1']);
            $data['get_common_bed_type'] = $data['result']->get_common_bed_type;
            $data['first_bed_type'] = BedType::where('status', 'Active')->limit(4)->get();

            $data['get_bathrooms'] = $data['result']->get_bathrooms;
            $data['get_common_bathrooms'] = $data['result']->get_common_bathrooms;
            $data['firstbedtypeid'] = BedType::where('status', 'Active')->first()->id;

            $data['rooms_photos'] = RoomsPhotos::where('room_id', $request->id)->orderBy('id', 'asc')->get();
            $data['calendar'] = str_replace(['<form name="calendar-edit-form">', '</form>', url('manage-listing/' . $request->id . '/calendar')], ['', '', 'javascript:void(0);'], $calendar->generate($request->id));
            $data['prev_amenities'] = explode(',', $data['result']->amenities);

            $data['length_of_stay_options'] = Rooms::getLenghtOfStayOptions();
            $data['availability_rules_months_options'] = Rooms::getAvailabilityRulesMonthsOptions();
			$data['price_pr_day'] = RoomDayPrice::where('room_id', $request->id)->orderBy('id', 'asc')->get();
			//$data['pricePrDay']=RoomDayPrice::where('id', $request->id)->orderBy('id', 'asc')->first();
            return view('admin.rooms.edit', $data);
        } else if ($request->submit == 'basics') {
            $rooms = Rooms::find($request->room_id);

            $rooms->bedrooms = $request->bedrooms;
            /*$rooms->beds          = $request->beds;
            $rooms->bed_type      = $request->bed_type;*/
            $rooms->bathrooms = $request->bathrooms;
            $rooms->bathroom_shared = $request->bathroom_shared;
            $rooms->property_type = $request->property_type;
            $rooms->room_type = $request->room_type;
            $rooms->accommodates = $request->accommodates;
           // $rooms->sub_name = RoomType::find($request->room_type)->name . ' in ' . $request->city;


            $rooms->save();

            //update Rooms beds
            $room_beds = array();
            if (@$request->bed_count != '') {
                foreach (@$request->bed_count as $k => $value) {
                    //dd($request->bed_types_name[$k]);
                    $alread_bed_available = RoomsBeds::where('room_id', $request->room_id)->where('bed_room_no', $value)->where('bed_id', $request->bed_id[$k])->first();
                    if ($alread_bed_available) {
                        $rooms_bedrooms = RoomsBeds::find($alread_bed_available->id);
                    } else {
                        $rooms_bedrooms = new RoomsBeds;

                    }
                    $rooms_bedrooms->room_id = $request->room_id;
                    $rooms_bedrooms->bed_room_no = $value;
                    $rooms_bedrooms->bed_id = $request->bed_id[$k];
                    $rooms_bedrooms->count = $request->bed_types_name[$k];
                    $rooms_bedrooms->save();

                    $room_beds[] = $request->bed_id[$k];
                    if (!isset($request->bed_count[$k + 1]) || $request->bed_count[$k] != $request->bed_count[$k + 1]) {
                        $alread_bed_available = RoomsBeds::where('room_id', $request->room_id)->where('bed_room_no', $value)->whereNotIn('bed_id', $room_beds)->delete();
                        $room_beds = array();
                    }

                }
            }

            //update Common Rooms beds
            foreach ($request->common_bed_count as $k => $value) {
                //dd($request->bed_types_name[$k]);
                $alread_bed_available = RoomsBeds::where('room_id', $request->room_id)->where('bed_room_no', $value)->where('bed_id', $request->common_bed_id[$k])->first();
                if ($alread_bed_available) {
                    $rooms_bedrooms = RoomsBeds::find($alread_bed_available->id);
                } else {
                    $rooms_bedrooms = new RoomsBeds;

                }
                $rooms_bedrooms->room_id = $request->room_id;
                $rooms_bedrooms->bed_room_no = $value;
                $rooms_bedrooms->bed_id = $request->common_bed_id[$k];
                $rooms_bedrooms->count = $request->common_bed_types_name[$k];
                $rooms_bedrooms->save();

            }

            $rooms_status = RoomsStepsStatus::find($request->room_id);
            $rooms_status->basics = 1;
            $rooms_status->save();

            $this->roomStatusUpdate($request->room_id);

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'booking_type') {
            $rooms = Rooms::find($request->room_id);

            $rooms->booking_type = $request->booking_type;

            $rooms->save();

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'description') {
            $rooms = Rooms::find($request->room_id);

            $rooms->name = $request->name[0];
            $rooms->sub_name = RoomType::find($request->room_type)->name . ' in ' . $request->city;
            $rooms->summary = $request->summary[0];

            $rooms->save();

            $rooms_description = RoomsDescription::find($request->room_id);

            $rooms_description = RoomsDescription::find($request->room_id);
            $rooms_description->space = $request->space[0];
            $rooms_description->access = $request->access[0];
            $rooms_description->interaction = $request->interaction[0];
            $rooms_description->notes = $request->notes[0];
            $rooms_description->house_rules = $request->house_rules[0];
            $rooms_description->neighborhood_overview = $request->neighborhood_overview[0];
            $rooms_description->transit = $request->transit[0];
            $rooms_description->save();

            RoomsDescriptionLang::where('room_id', $request->id)->delete();
            $count = count($request->name);
            for ($i = 1; $i < $count; $i++) {
                $lan_description = new RoomsDescriptionLang;
                $lan_description->room_id = $rooms->id;
                $lan_description->lang_code = $request->language[$i - 1];
                $lan_description->name = $request->name[$i];
                $lan_description->summary = $request->summary[$i];
                $lan_description->space = $request->space[$i];
                $lan_description->access = $request->access[$i];
                $lan_description->interaction = $request->interaction[$i];
                $lan_description->notes = $request->notes[$i];
                $lan_description->house_rules = $request->house_rules[$i];
                $lan_description->neighborhood_overview = $request->neighborhood_overview[$i];
                $lan_description->transit = $request->transit[$i];
                $lan_description->save();
            }

            $rooms_status = RoomsStepsStatus::find($request->room_id);
            $rooms_status->description = 1;
            $rooms_status->save();

            $this->roomStatusUpdate($request->room_id);

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'location') {
            $latt = $request->latitude;
            $longg = $request->longitude;
            if ($latt == '' || $longg == '') {
                $address = $request->address_line_1 . ' ' . $request->address_line_2 . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country;
                $latlong = $this->latlong($address);

                $latt = $latlong['lat'];
                $longg = $latlong['long'];
            }

            $rooms_address = RoomsAddress::find($request->room_id);

            $rooms_address->address_line_1 = $request->address_line_1;
            $rooms_address->address_line_2 = $request->address_line_2;
            $rooms_address->city = $request->city;
            $rooms_address->state = $request->state;
            $rooms_address->country = $request->country;
            $rooms_address->postal_code = $request->postal_code;
            $rooms_address->latitude = $latt;
            $rooms_address->longitude = $longg;

            $rooms_address->save();

            $rooms_status = RoomsStepsStatus::find($request->room_id);
            $rooms_status->location = 1;
            $rooms_status->save();

            $this->roomStatusUpdate($request->room_id);

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'amenities') {
            $rooms = Rooms::find($request->room_id);

            $rooms->amenities = @implode(',', @$request->amenities);

            $rooms->save();

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'photos') {

            $delete = RoomsPhotos::where('room_id', $request->room_id)->delete();

            if ($request->hidden_image != '') {
                $i = 0;
                foreach (@$request->hidden_image as $image) {
                    if ($image != '') {
                        $rooms_photo = new RoomsPhotos;
                        $rooms_photo->room_id = $request->room_id;
                        $rooms_photo->name = $image;
                        $rooms_photo->highlights = $request->hidden_high[$i];
                        $rooms_photo->save();
                        $i++;
                    }
                }
            }
            // Image upload
            if (isset($_FILES["photos"]["name"])) {
                foreach ($_FILES["photos"]["error"] as $key => $error) {
                    $tmp_name = $_FILES["photos"]["tmp_name"][$key];

                    $name = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);

                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    $name = time() . $key . '_.' . $ext;

                    $filename = dirname($_SERVER['SCRIPT_FILENAME']) . '/images/rooms/' . $request->room_id;

                    if (!file_exists($filename)) {
                        mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/images/rooms/' . $request->room_id, 0777, true);
                    }

                    if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                        if (UPLOAD_DRIVER == 'cloudinary') {
                            $c = $this->helper->cloud_upload($tmp_name);
                            if ($c['status'] != "error") {
                                $name = $c['message']['public_id'];
                            } else {
                                flash_message('danger', $c['message']); // Call flash message function
                                // return redirect(ADMIN_URL.'/rooms');
                                return redirect()->back();

                            }
                        } else {
                            if ($ext == 'gif') {

                                move_uploaded_file($tmp_name, "images/rooms/" . $request->id . "/" . $name);
                            } else {

                                if (move_uploaded_file($tmp_name, "images/rooms/" . $request->room_id . "/" . $name)) {
                                    $this->helper->compress_image("images/rooms/" . $request->room_id . "/" . $name, "images/rooms/" . $request->room_id . "/" . $name, 80, 1440, 960);
                                    $this->helper->compress_image("images/rooms/" . $request->room_id . "/" . $name, "images/rooms/" . $request->room_id . "/" . $name, 80, 1349, 402);
                                    $this->helper->compress_image("images/rooms/" . $request->room_id . "/" . $name, "images/rooms/" . $request->room_id . "/" . $name, 80, 450, 250);
                                }
                            }
                        }
                        $photos = new RoomsPhotos;
                        $photos->room_id = $request->room_id;
                        $photos->name = $name;
                        $photos->save();

                    }
                }

                // $photos_featured = RoomsPhotos::where('room_id',$request->room_id)->where('featured','Yes');
                // if($photos_featured->count() == 0){
                //     $photos = RoomsPhotos::where('room_id',$request->room_id)->first();
                //     $photos->featured = 'Yes';
                //     $photos->save();
                // }
            }

            $rooms_status = RoomsStepsStatus::find($request->room_id);
            $rooms_status->photos = 1;
            $rooms_status->save();
            $this->roomStatusUpdate($request->room_id);

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'video') {
            $rooms = Rooms::find($request->room_id);

            $search = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
            $count = preg_match($search, $request->video);
            $rooms = Rooms::find($request->id);
            if ($count == 1) {
                $replace = 'https://www.youtube.com/embed/$2';
                $video = preg_replace($search, $replace, $request->video);
                $rooms->video = $video;
            } else {
                $rooms->video = $request->video;
            }

            $rooms->save();

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'pricing') {

           
            $rooms_price = RoomsPrice::find($request->room_id);
			$monthy_night_prices = array(
                'january' => $request->night,
                'february' => $request->night,
                'march' => $request->night,
                'april' => $request->night_april,
                'may' => $request->night_may,
                'june' => $request->night_june,
                'july' => $request->night_july,
                'august' => $request->night_august,
                'september' => $request->night_september,
                'october' => $request->night_october,
                'november' => $request->night,
                'december' => $request->night,
            );

            $monthy_night_prices = json_encode($monthy_night_prices );

            
            $rooms_price->night = $monthy_night_prices;
          
            // $rooms_price->week             = $request->week;
            // $rooms_price->month            = $request->month;
            $rooms_price->cleaning = $request->cleaning;
            $rooms_price->additional_guest = $request->additional_guest;
            $rooms_price->guests = ($request->additional_guest) ? $request->guests : '0';
            $rooms_price->security = $request->security;
            $rooms_price->weekend = $request->weekend;
            $rooms_price->currency_code = $request->currency_code;

            $rooms_price->save();

            $rooms_status = RoomsStepsStatus::find($request->room_id);
            $rooms_status->pricing = 1;
            $rooms_status->save();
            $this->roomStatusUpdate($request->room_id);

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'pricePrDay') {
			  $rooms_day_price = RoomDayPrice::find($request->room_id);
			  $room = $request->room_id;
			  $from_room_count = array_unique($request->from_date); 
			 for ($i = 0; $i < count($from_room_count); $i++){
			 $date1=date_create($from_room_count[$i]);
             $date2=date_create($request->to_date[$i]);
             $diff=date_diff($date1,$date2);
             $dif= $diff->format("%a");
              if($dif ==1){
					RoomDayPrice::create(['from_date'=>$from_room_count[$i], 'to_date'=>$request->to_date[$i],'price'=>$request->price[$i],'room_id'=>$room]);
				}
				else{ 
				$dates = $this->getDatesFromRange( $from_room_count[$i],$request->to_date[$i]);
				foreach($dates as $k => $selected_dates){
					$newdate = date("Y-m-d",strtotime ( '+1 day' , strtotime ($selected_dates) )) ;
					//if($k % 2 == 0){
					$check_dates=RoomDayPrice::where('from_date','=', $selected_dates)->where('to_date', '=',$newdate)->where('room_id', '=',$room)->get();
		          if(count($check_dates) == 0){
				  RoomDayPrice::create(['from_date'=>$selected_dates, 'to_date'=>$newdate,'price'=>$request->price[$i],'room_id'=>$room]);
				  }
			    //}
		       }
		     }
			}
            return redirect()->back();

        }else if ($request->submit == 'terms') {
            $rooms = Rooms::find($request->room_id);

            $rooms->cancel_policy = $request->cancel_policy;

            $rooms->save();

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'price_rules') {
            $length_of_stay_rules = $request->length_of_stay ?: array();
            foreach ($length_of_stay_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $request->room_id,
                        'type'    => 'length_of_stay',
                    ];
                } else {
                    $check = [
                        'room_id' => $request->room_id,
                        'type'    => 'length_of_stay',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $request->room_id;
                $price_rule->type = 'length_of_stay';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            $early_bird_rules = $request->early_bird ?: array();
            foreach ($early_bird_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $request->room_id,
                        'type'    => 'early_bird',
                    ];
                } else {
                    $check = [
                        'room_id' => $request->room_id,
                        'type'    => 'early_bird',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $request->room_id;
                $price_rule->type = 'early_bird';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            $last_min_rules = $request->last_min ?: array();
            foreach ($last_min_rules as $rule) {
                if (@$rule['id']) {
                    $check = [
                        'id'      => $rule['id'],
                        'room_id' => $request->room_id,
                        'type'    => 'last_min',
                    ];
                } else {
                    $check = [
                        'room_id' => $request->room_id,
                        'type'    => 'last_min',
                        'period'  => $rule['period']
                    ];
                }
                $price_rule = RoomsPriceRules::firstOrNew($check);
                $price_rule->room_id = $request->room_id;
                $price_rule->type = 'last_min';
                $price_rule->period = $rule['period'];
                $price_rule->discount = $rule['discount'];

                $price_rule->save();
            }

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'availability_rules') {
            $availability_rules = $request->availability_rules ?: array();
            foreach ($availability_rules as $rule) {
                if (@$rule['edit'] == 'true') {
                    continue;
                }
                $check = [
                    'id' => @$rule['id'] ?: '',
                ];
                $availability_rule = RoomsAvailabilityRules::firstOrNew($check);
                $availability_rule->room_id = $request->room_id;
                $availability_rule->start_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['start_date'], PHP_DATE_FORMAT));
                $availability_rule->end_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['end_date'], PHP_DATE_FORMAT));
                $availability_rule->minimum_stay = @$rule['minimum_stay'] ?: null;
                $availability_rule->maximum_stay = @$rule['maximum_stay'] ?: null;
                $availability_rule->type = @$rule['type'] != 'prev' ? @$rule['type'] : @$availability_rule->type;
                $availability_rule->save();
            }
            $rooms_price = RoomsPrice::find($request->room_id);
            $rooms_price->minimum_stay = $request->minimum_stay ?: null;
            $rooms_price->maximum_stay = $request->maximum_stay ?: null;
            $rooms_price->save();

            flash_message('success', 'Room Updated Successfully'); // Call flash message function
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else if ($request->submit == 'cancel') {
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        } else {
            // return redirect(ADMIN_URL.'/rooms');
            return redirect()->back();

        }
    }

    public function roomStatusUpdate($room_id)
    {
        $room = Rooms::where('id', $room_id)->first();
        $user = User::find($room->user_id);
        // if ($user->status == 'Active' && $room->steps_count == 0 && $room->verified=='Pending') {
        //     $room->status = 'Listed';
        //     $room->verified = 'Approved';
        //     $room->save();
        // }
    }

    public function delete_price_rule(Request $request)
    {
        $id = $request->id;
        RoomsPriceRules::where('id', $id)->delete();

        return json_encode(['success' => true]);
    }

    public function delete_availability_rule(Request $request)
    {
        $id = $request->id;
        RoomsAvailabilityRules::where('id', $id)->delete();

        return json_encode(['success' => true]);
    }


    public function update_video(Request $request)
    {

        $data_calendar = @json_decode($request['data']);
        $rooms = Rooms::find($data_calendar->id);

        $search = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
        $count = preg_match($search, $data_calendar->video);
        $rooms = Rooms::find($data_calendar->id);
        if ($count == 1) {
            $replace = 'http://www.youtube.com/embed/$2';
            $video = preg_replace($search, $replace, $data_calendar->video);
            $rooms->video = $video;
        } else {
            $rooms->video = $data_calendar->video;
        }

        $rooms->save();

        return json_encode(['success' => 'true', 'steps_count' => $rooms->steps_count, 'video' => $rooms->video]);
    }

    /**
     * Delete Rooms
     *
     * @param array $request Input values
     * @return redirect     to Rooms View
     */
    public function latlong($address)
    {
        $url = "http://maps.google.com/maps/api/geocode/json?address=" . urlencode($address);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson);

        if ($response->status == 'OK') {
            $latitude = $response->results[0]->geometry->location->lat;
            $longitude = $response->results[0]->geometry->location->lng;
            $add = array('lat' => $latitude, 'long' => $longitude);

            return $add;
        }

    }


    public function delete(Request $request)
    {
        $check = Reservation::whereRoomId($request->id)->count();

        if ($check) {
            flash_message('error', 'This room has some reservations. So, you cannot delete this room.'); // Call flash message function
        } else {
            $exists_rnot = Rooms::find($request->id);
            if (@$exists_rnot) {
                Rooms::find($request->id)->Delete_All_Room_Relationship();
                flash_message('success', 'Deleted Successfully');
            } else {
                flash_message('error', 'This Room Already Deleted.');
            } // Call flash message function
        }

        // return redirect(ADMIN_URL.'/rooms');
        return redirect()->back();

    }

    /**
     * Users List for assign Rooms Owner
     *
     * @param array $request Input values
     * @return json Users table
     */
    public function users_list(Request $request)
    {
        return User::where('first_name', 'like', $request->term . '%')->select('first_name as value', 'id')->get();
    }

    /**
     * Ajax function of Calendar Dropdown and Arrow
     *
     * @param array $request Input values
     * @param array $calendar Instance of CalendarController
     * @return html Calendar
     */
    public function ajax_calendar(Request $request, CalendarController $calendar)
    {
        $month = $request->month;
        $year = $request->year;
        $data['calendar'] = $calendar->generate($request->id, $year, $month);
         return $data['calendar'];
    }

    /**
     * Delete Rooms Photo
     *
     * @param array $request Input values
     * @return json success
     */
    public function delete_photo(Request $request)
    {

        $photos = RoomsPhotos::find($request->photo_id);
        if ($photos != null) {
            /*delete file from server*/
            $compress_images = ['_450x250.', '_1440x960.', '_1349x402.'];
            $this->helper->remove_image_file($photos->original_name, "images/rooms/" . $request->room_id, $compress_images);
            /*delete file from server*/
            $photos->delete();
        }

        // $photos_featured = RoomsPhotos::where('room_id',$request->room_id)->where('featured','Yes');
        // if($photos_featured->count() == 0){
        //     $photos_featured = RoomsPhotos::where('room_id',$request->room_id);
        //     if($photos_featured->count() !=0){
        //         $photos = RoomsPhotos::where('room_id',$request->room_id)->first();
        //         $photos->featured = 'Yes';
        //         $photos->save();
        //     }
        // }

        return json_encode(['success' => 'true']);
    }

    /**
     * Ajax List Your Space Photos Highlights
     *
     * @param array $request Input values
     * @return json success
     */
    public function photo_highlights(Request $request)
    {
        $photos = RoomsPhotos::find($request->photo_id);

        $photos->highlights = $request->data;

        $photos->save();

        return json_encode(['success' => 'true']);
    }

    public function popular(Request $request)
    {
        $prev = Rooms::find($request->id)->popular;

        if ($prev == 'No') {
            $room = Rooms::find($request->id);
            $user_check = User::find($room->user_id);
            if ($room->status != 'Listed') {
                flash_message('error', 'Not able to popular for unlisted listing');

                return back();
            }
            if ($user_check->status != 'Active') {
                flash_message('error', 'Not able to popular for Not Active users');

                return back();
            }
        }

        if ($prev == 'Yes')
            Rooms::where('id', $request->id)->update(['popular' => 'No']);
        else
            Rooms::where('id', $request->id)->update(['popular' => 'Yes']);

        flash_message('success', 'Updated Successfully'); // Call flash message function
        // return redirect(ADMIN_URL.'/rooms');
        return redirect()->back();

    }

    public function recommended(Request $request)
    {
        $room = Rooms::find($request->id);
        $user_check = User::find($room->user_id);
        if ($room->status != 'Listed') {
            flash_message('error', 'Not able to recommend for unlisted listing');

            return back();
        }
        if ($user_check->status != 'Active') {
            flash_message('error', 'Not able to recommend for Not Active users');

            return back();
        }

        $prev = $room->recommended;

        if ($prev == 'Yes')
            Rooms::where('id', $request->id)->update(['recommended' => 'No']);
        else
            Rooms::where('id', $request->id)->update(['recommended' => 'Yes']);

        flash_message('success', 'Updated Successfully'); // Call flash message function
        // return redirect(ADMIN_URL.'/rooms');
        return redirect()->back();

    }

    public function featured_image(Request $request)
    {

        RoomsPhotos::whereRoomId($request->id)->update(['featured' => 'No']);

        RoomsPhotos::whereId($request->photo_id)->update(['featured' => 'Yes']);

        return 'success';
    }

    /*Admin Verify Listing*/
    public function update_room_status(Request $request)
    {

        //dd($request->option);

        //dd($request->id);
        $room = Rooms::find($request->id);

        $user_check = User::find($room->user_id);

        //dd($room->user_id);

        if ($user_check->status != 'Active') {
            flash_message('error', 'Not able to ' . $request->type . ' for Not Active users');

            return back();
        }

        if ($room->status == 'Unlisted') {
            flash_message('error', 'Not able to ' . $request->type . ' for unlisted listing');

            return back();
        }

        if ($request->option == 'Approved') {

            Rooms::where('id', $request->id)->update(['status' => 'Listed']);

            //send admin approved email to host
            $email_controller = new EmailController;
            $email_controller->listing_approved_by_admin($request->id);

            //$email_controller->admin_approve_email($request->id);
            //$email_controller->admin_approve_email_host($request->id);
        } elseif ($request->option == 'Pending' && $request->type == "verified") {
            Rooms::where('id', $request->id)->update(['status' => 'Pending']);
        }


        Rooms::where('id', $request->id)->update([$request->type => $request->option]);
        flash_message('success', 'Updated Successfully'); // Call flash message function

        return redirect(ADMIN_URL . '/rooms');
    }

    /**
     * Resubmit Listing in admin
     */
    public function resubmit_listing(Request $request)
    {

        $rooms = Rooms::find($request->room_id);

        $user_check = User::find($rooms->user_id);

        if ($user_check->status != 'Active') {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Not able to verified for Not Active users');

            return "true";
        }

        if ($rooms->status == 'Unlisted') {

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Not able to verified for unlisted listing');

            return "true";
        }
        $rooms->verified = 'Resubmit';
        $rooms->status = 'Resubmit';
        $rooms->save();

        $room_detail = Rooms::find($request->room_id);
        $message = new Messages;
        $message->room_id = $request->room_id;
        $message->reservation_id = $request->room_id . '' . $room_detail->user_id; // $request->room_id;
        $message->user_from = $room_detail->user_id;
        $message->user_to = $room_detail->user_id;
        $message->message = $request->msg;
        $message->message_type = 13;
        $message->save();

        //$email_controller = new EmailController;
        //$email_controller->admin_resubmit_email($request->room_id,$request->msg);
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Resubmited Successfully');

        return "true";
    }

    public function update_subname($room, Request $request)
    {

        $room = Rooms::findOrFail($room);

        $room->update(['sub_name' => $request->subname]);
    }
	
	//  Per Day price functionality 
	
	public function editPrDay(Request $request, $room)
    {
		if((!$_POST)){
		 $data = RoomDayPrice::findOrFail($room);
		 $url = url(ADMIN_URL.'/perday/'.$data->id);  
		 $html= '<div class="alert alert-danger"></div>
		        <div class="alert alert-success"></div>
				
		<div>
		          <label for="fromDate" class="form-label">From Date</label>
			      <input type="date"
                            class="form-control" 
                            id="fromDate" 
							name="fromDate" 
							value="'.$data->from_date.'" autofocus required>
              </br>
			  <label for="fromDate" class="form-label">To Date</label>
			  <input type="date"
                            class="form-control" 
                            id="toDate" 
							name="toDate" 
							value="'.$data->to_date.'" autofocus required>
			</br>
			<label for="fromDate" class="form-label">Price</label>
			  <input type="number"
                            class="form-control"  
                            id="price" 
							name="price" 
							value="'.$data->price.'" autofocus required>
			 <input type="hidden"
                            class="form-control"  
                            id="room_id" 
							name="room_id" 
							value="'.$data->room_id.'" autofocus>
             
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-danger stop" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary save_pass" value="save_pr_day_priceing" type="submit" name="submit" data="'.$url.'">Save changes</button>
             </div>';
		     $result['html'] = $html;
             return response()->json($result);}
      }
	  public function updatePrDay(Request $request, $room) 
    {
		
		 $fromDate = $request->get('formData');
		 $toDate= $request->get('toData');
		 $price= $request->get('price');
		 if($price == 0){
           return response()->json(['errors' => 'Price should be greater than zero.']);}
		 if($fromDate == $toDate){
           return response()->json(['errors' => 'From date should be different To date.']);}
		 $room_id= $request->get('room_id');
		 $data = RoomDayPrice::find($room);
		 $check_condition=RoomDayPrice::where('from_date', '=', $fromDate)->where('to_date', '=', $toDate)->where('room_id', '=',$room_id)->where('id', '!=',$room)->get();
		 if(count($check_condition)>0){
           return response()->json(['errors' => 'Room price already exist for selected date.']);}
		 
		 $checkdates=RoomDayPrice::where('from_date','=', $fromDate)->where('room_id', '=',$room_id)->where('id', '!=',$room)->get();
		 if(count($checkdates)>0){
           return response()->json(['errors' => 'Room price already exist for from date.']);}
		 
		 $checkdate=RoomDayPrice::where('to_date','=', $toDate)->where('room_id', '=',$room_id)->where('id', '!=',$room)->get();
		 if(count($checkdate)>0){
           return response()->json(['errors' => 'Room price already exist for to date.']);}
		 
		 $data->from_date= $fromDate;  
         $data->to_date= $toDate;  
         $data->price= $price;
		 $data->room_id =$room_id;
		 $data->save();
         return response()->json(['success' => 'Price for selected date Added successfully.']);
    }
	
	public function deletePrDay(Request $request, $room)
    {
		  
       if((!$_POST)){
		 $delete = RoomDayPrice::where('id', $room)->delete();}
	}

		
}
