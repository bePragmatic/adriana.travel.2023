<?php

/**
 * Calendar Controller
 *
 * @package     Tempus media | Booking
 * @subpackage  Controller
 * @category    Calendar
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IcalController;
use App\Models\RoomsPrice;
use App\Models\Rooms;
use App\Models\RoomDayPrice;
use App\Models\Calendar;
use App\Models\ImportedIcal;
use App\Models\Reservation;
use Validator;
use Form;
use App\Http\Helper\PaymentHelper;
use App\Http\Start\Helpers;
use Request as HttpRequest; 

class CalendarController extends Controller
{
    public $start_day = 'monday';   // Global Variable for Start Day of Calendar

    protected $payment_helper;

    /**
     * Get a Calendar HTML
     *
     * @param int $room_id  Room Id for get the Calendar data 
     * @param int $year     Year of Calendar
     * @param int $month    Month of Calendar
     * @return html
     */
    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
        $this->helper = new Helpers;
    }

    /**
     * Get a Calendar HTML
     *
     * @param int $room_id  Room Id for get the Calendar data 
     * @param int $year     Year of Calendar
     * @param int $month    Month of Calendar
     * @return html
     */
    public function generate($room_id, $year = '', $month = '')
    {
        $rooms = Rooms::find($room_id);
        $rooms_price = RoomsPrice::find($room_id);
		$room_prdays = RoomDayPrice::where('room_id', $room_id)->get();
		$this_start_day = 'monday';
		if($year == '') {
            $year  = date('Y');
        }
        if($month == '') {
            $month = date('m');
        }

        $calendar_data = array();

        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $start_days = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $start_day  = ( ! isset($start_days[$this_start_day])) ? 0 : $start_days[$this_start_day];
        $today_time = mktime(12, 0, 0, $month, 1, $year);
        $today_date = getdate($today_time);
        $day        = $start_day + 1 - $today_date["wday"];

        $prev_time  = mktime(12, 0, 0, $month-1, 1, $year);
        $next_time  = mktime(12, 0, 0, $month+1, 1, $year);
        
        $last_time  = mktime(12, 0, 0, $month, $total_days, $year);
        $last_date  = getdate($last_time);
        $total_dates= $total_days + ($last_date["wday"] != ($start_day-1) ? ( 6 + $start_day - $last_date["wday"] ) : 0);

        $current_date= date('Y-m-d');
        $current_time= time();
       
        if ($day > 1) {
            $day -= 7;
        }

        $k = 0;
		if(count($room_prdays) > 0){
		 foreach($room_prdays as $room_prday){
        while($day <= $total_dates) {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $current_month = strtolower(date('F'));
			$monthly_prices  = json_decode( $rooms_price);
            
            $monthly_prices = json_decode($monthly_prices->original_night, true);
           // dd($monthly_prices[$current_month]);
            $calendar_data[$k]['start'] = $this_date;
			$Price_date   = '';
		    $Price_pr_day = '';
            foreach($room_prdays as $room_prday){
				if($this_date == $room_prday['from_date'] ){
				$Price_date= $room_prday['from_date'];
				$Price_pr_day = $room_prday['price'];
			  }
			  if($Price_pr_day){
			 $calendar_data[$k]['title'] = $rooms_price->currency->original_symbol.$Price_pr_day; 
			 $calendar_data[$k]['Price_date'] = $Price_date;
			}
			else{
				$calendar_data[$k]['title'] = '';
			 
			}
			}
			
            //$calendar_data[$k]['title'] = html_string($rooms_price->currency->original_symbol).''.$monthly_prices[$current_month] ;
            $calendar_data[$k]['spots_left'] = $rooms_price->spots_left($this_date);
            $calendar_data[$k]['price'] =$rooms_price->price($this_date);
            $calendar_data[$k]['notes'] = $rooms_price->notes($this_date);
            $calendar_data[$k]['currency'] = $rooms_price->currency->original_symbol;
            $is_reservation = Reservation::whereRoomId($room_id)->where('type', 'reservation')->whereRaw('status!="Declined"')->whereRaw('status!="Expired"')->whereRaw('status!="Cancelled"')->whereRaw('(checkin = "'.$this_date.'" or (checkin < "'.$this_date.'" and checkout > "'.$this_date.'")) ')->count();

            $calendar_data[$k]['description'] = "Available";
            $calendar_data[$k]['className']   = '';

            if($is_reservation > 0) {
                $calendar_data[$k]['description'] = "Not available";
                $calendar_data[$k]['className']   = "status-r";
            }
            else if($rooms_price->status($this_date) == 'Not available') {
                $calendar_data[$k]['description'] = "Not available";
                $calendar_data[$k]['className']   = "status-b";
            }

            if(date('Ymd') == date('Ymd',strtotime($this_date)))
            {
                $calendar_data[$k]['className'] .= ' cal-today';
            }

            $has_calendar_data = Calendar::where('room_id', $room_id)->where('date', $this_date)->count();
            $calendar_data[$k]['rendering'] = 'background';
            $calendar_data[$k]['has_calendar'] = ( $has_calendar_data > 0) ? 'true': 'false';

            $day++;
            $k++;
        }
			}
		}
		else{
			while($day <= $total_dates) {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $current_month = strtolower(date('F'));
			$monthly_prices  = json_decode( $rooms_price);
            
            $monthly_prices = json_decode($monthly_prices->original_night, true);
           // dd($monthly_prices[$current_month]);
            $calendar_data[$k]['start'] = $this_date;
			$calendar_data[$k]['title'] = html_string($rooms_price->currency->original_symbol).''.$monthly_prices[$current_month] ;
            $calendar_data[$k]['spots_left'] = $rooms_price->spots_left($this_date);
            $calendar_data[$k]['price'] =$rooms_price->price($this_date);
            $calendar_data[$k]['notes'] = $rooms_price->notes($this_date);
            $calendar_data[$k]['currency'] = $rooms_price->currency->original_symbol;
            $is_reservation = Reservation::whereRoomId($room_id)->where('type', 'reservation')->whereRaw('status!="Declined"')->whereRaw('status!="Expired"')->whereRaw('status!="Cancelled"')->whereRaw('(checkin = "'.$this_date.'" or (checkin < "'.$this_date.'" and checkout > "'.$this_date.'")) ')->count();

            $calendar_data[$k]['description'] = "Available";
            $calendar_data[$k]['className']   = '';

            if($is_reservation > 0) {
                $calendar_data[$k]['description'] = "Not available";
                $calendar_data[$k]['className']   = "status-r";
            }
            else if($rooms_price->status($this_date) == 'Not available') {
                $calendar_data[$k]['description'] = "Not available";
                $calendar_data[$k]['className']   = "status-b";
            }

            if(date('Ymd') == date('Ymd',strtotime($this_date)))
            {
                $calendar_data[$k]['className'] .= ' cal-today';
            }

            $has_calendar_data = Calendar::where('room_id', $room_id)->where('date', $this_date)->count();
            $calendar_data[$k]['rendering'] = 'background';
            $calendar_data[$k]['has_calendar'] = ( $has_calendar_data > 0) ? 'true': 'false';

            $day++;
            $k++;
        }
		}

      return $calendar_data;
    }

    /**
     * Get a Small Calendar HTML
     *
     * @param int $room_id          Room Id for get the Calendar data 
     * @param int $year             Year of Calendar
     * @param int $month            Month of Calendar
     * @param int $reservation_id   Reservation Id of Calendar
     * @return html
     */
    public function generate_small($room_id, $year = '', $month = '', $reservation_id = '')
    {
        $rooms = Rooms::find($room_id);
        $rooms_price = RoomsPrice::find($room_id);

        $reservation_details = Reservation::where('room_id', $room_id)->where('list_type', 'Rooms')->where('id',$reservation_id)->get();

        if($reservation_details->count() > 0)
            $dates = $this->get_days_reservation($reservation_details[0]->checkin, $reservation_details[0]->checkout);

        $this_start_day = 'monday';
        if ($year == '')
        {
            $year  = date('Y');
        }
        if ($month == '')
        {
            $month = date('m');
        }
        $calendar_data = array();

        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $start_days = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $start_day  = ( ! isset($start_days[$this_start_day])) ? 0 : $start_days[$this_start_day];

        $today_time = mktime(12, 0, 0, $month, 1, $year);
        $today_date = getdate($today_time);
        $day        = $start_day + 1 - $today_date["wday"];

        $prev_time  = mktime(12, 0, 0, $month-1, 1, $year);
        $next_time  = mktime(12, 0, 0, $month+1, 1, $year);

        $last_time  = mktime(12, 0, 0, $month, $total_days, $year);
        $last_date  = getdate($last_time);
        $total_dates= $total_days + ($last_date["wday"] != ($start_day-1) ? ( 6 + $start_day - $last_date["wday"] ) : 0);

        $current_date= date('Y-m-d');
        $current_time= time();

        if ($day > 1) {
            $day -= 7;
        }

        $k = 0;
        while($day <= $total_dates)
        {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $calendar_data[$k]['date'] = $this_date;
            $calendar_data[$k]['day'] = date('d', $this_time);
            $class = '';
            $final_class = '';
            $calendar_data[$k]['class'] = '';

            if(date('Ymd', $this_time) < date('Ymd',$current_time))
            {
                $class .= ' tile-previous';
            }
            elseif(date('Ymd', $this_time) == date('Ymd',$current_time))
            {
                $class .= ' today';   
            }
            
            if($class == '' || $class == ' today')
            {
                if($rooms_price->status($this_date) == 'Not available')
                    $class .= ' status-r';

                if($reservation_details->count())
                {
                    if($rooms_price->status($this_date) == 'Not available' && in_array($this_date, $dates))
                    $class .= " status-r tile-status active";
                }
            }

            $final_class = ' '.$class.' no-tile-status both';

            if($reservation_details->count())
            {
            if($rooms_price->status($this_date) == 'Not available' && in_array($this_date, $dates))
                $final_class = 'tile '.$class;
            }
            $calendar_data[$k]['class'] = $final_class;

            $day++;
            $k++;
        }
        $data['calendar_data'] = $calendar_data;
        $data['today_time']    = $today_time;
        $data['local_date']    = mktime(12, 0, 0, $month, 1, $year);
        $data['prev_month']    = date('m', $prev_time);
        $data['prev_year']     = date('Y', $prev_time);
        $data['next_month']    = date('m', $next_time);
        $data['next_year']     = date('Y', $next_time);
        $data['room_id']       = $room_id;
        $data['year_month']    = $this->year_month();
        $data['rooms_price']   = $rooms_price;
        $data['rooms']         = $rooms;
        $data['minimum_amount']= $this->payment_helper->currency_convert(DEFAULT_CURRENCY, $rooms_price->currency_code, MINIMUM_AMOUNT);

        return view('list_your_space.calendar_sm',$data)->render();
    }

    /**
     * Get a Calendar Month & Year Dropdown
     *
     * @return Month with Year
     */
    public function year_month()
    {
        $year_month = array();

        $this_time = mktime(0, 0, 0, date('m'), 1, date('Y'));
        for($i=-2;$i<35;$i++)
        {
          $time               = strtotime("+$i months", $this_time);
          $value              = date('Y-m', $time);
          $label              = trans('messages.lys.'.date('F', $time)).' '.date('Y', $time);
          $year_month[$value] = $label; 
        }
        return $year_month;
    }

    /**
     * iCal Export
     *
     * @param array $request    Input values
     * @return iCal file
     */
    public function ical_export(Request $request)
    {
        $explode_id = explode('.', $request->id);

        // 1. Create new calendar
        $vCalendar  = new \Eluceo\iCal\Component\Calendar(url('/'));
        
        $result     = Calendar::where('room_id', $explode_id[0])->where('status','Not available')->get();

        foreach($result as $row)
        {
            // 2. Create an event
            $vEvent = new \Eluceo\iCal\Component\Event();
            
            $vEvent
                ->setDtStart(new \DateTime($row->date))
                ->setDtEnd(new \DateTime($row->date))
                ->setDescription($row->notes)
                ->setNoTime(true)
                ->setSummary($row->status);

            // 3. Add event to calendar
            $vCalendar->addComponent($vEvent);
        }
        
        // 4. Set headers
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="listing-'.$explode_id[0].'.ics"');
        
        // 5. Output
        echo $vCalendar->render();
    }

    /**
     * Import iCal
     *
     * @param array $request    Input values
     * @return redirect to Edit Calendar
     */
    public function ical_import(Request $request)
    {
        // Validation for iCal import fields
        $rules = array(
            'url'  => 'required|url',
            'name' => 'required'
        );

        $attributes = array(
            'url'  => 'URL',
            'name' => 'Name'
        );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($attributes); 

        if ($validator->fails()) {
            // Back with Error code 4 to show import calendar popup
            return back()->withErrors($validator)->withInput()->with('error_code',4);
        }

        ini_set('max_execution_time', 300);

        $ical_data = [
            'room_id'   => $request->id,
            'url'       => $request->url,
            'name'      => $request->name,
            'last_sync' => date('Y-m-d H:i:s')
        ];

        // Update or Create a iCal imported data        
        ImportedIcal::updateOrCreate(['room_id' => $request->id, 'url' => $request->url], $ical_data);

        // Create a new instance of IcalController
        $ical = new IcalController($request->url);
        $events= $ical->events();
        $rooms_price = RoomsPrice::where('room_id',$request->id)->first();
        
        //checking the curent month
        //$month = date('m');
// dd($price);
         $price = $rooms_price->original_night;
        //$price = $month;

        // Get events from IcalController
        for($i=0; $i<$ical->event_count; $i++) {
            if(!isset($events[$i]['DTSTART']) || !isset($events[$i]['DTEND'])) {
                continue;
            }
            $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
            $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
            $days       = $this->get_days($start_date, $end_date);



            // Update or Create a events
            if(count($days)==1) {
                $calendar_data = [
                    'room_id' => $request->id,
                    'date'    => $days[0],
                    'notes'   => @$events[0]['DESCRIPTION'],
                    'source'  => 'Sync',
                    'price'   => $price,
                    'status'  => 'Not available',
                ];
                if($rooms_price->has_reservation($days[0])) {
                    Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[0]], $calendar_data);
                }
            }
            else { 
                for($j=0; $j<=count($days)-1; $j++) {
                    $calendar_data = [
                        'room_id' => $request->id,
                        'date'    => $days[$j],
                        'notes'   => @$events[$i]['DESCRIPTION'],
                        'source'  => 'Sync',
                        'price'   => $price,
                        'status'  => 'Not available',
                    ];
                    if($rooms_price->has_reservation($days[$j])) {
                        Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[$j]], $calendar_data);
                    }
                }
            }
        }

        return redirect('manage-listing/'.$request->id.'/calendar');
    }

    /**
     * iCal Synchronization
     *
     * @param array $request    Input values
     * @return redirect to Edit Calendar
     */
    public function ical_sync(Request $request)
    {
        // Get all imported iCal URLs for give Room ID
        $result = ImportedIcal::where('room_id', $request->id)->get();

        if($result->count() > 0){
            Calendar::where('room_id',$request->id)->where('source','Sync')->delete();
            foreach($result as $row) {
                // Create a new instance of IcalController
                $ical   = new IcalController($row->url);
                $events = $ical->events();
                // Get Rooms Original Night Price
                $rooms_price = RoomsPrice::where('room_id',$request->id)->first();
                // $price = $rooms_price->original_night;
                $price = 1;

                // Get events from IcalController
                for($i=0; $i<$ical->event_count; $i++) {
                    if(!isset($events[$i]['DTSTART']) || !isset($events[$i]['DTEND'])) {
                        continue;
                    }
                    $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
                    $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);

                    $days       = $this->get_days($start_date, $end_date);

                    // Update or Create a events
                    if(count($days)==1) {
                        $calendar_data = [
                            'room_id' => $request->id,
                            'date'    => $days[0],
                            'notes'   => @$events[0]['DESCRIPTION'],
                            'source'  => 'Sync',
                            'price'   => $price,
                            'status'  => 'Not available',
                        ];
                        if($rooms_price->has_reservation($days[0])) {
                            Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[0]], $calendar_data);
                        }
                    }
                    else {
                        for($j=0; $j<=count($days)-1; $j++) {
                            $calendar_data = [
                                'room_id' => $request->id,
                                'date'    => $days[$j],
                                'notes'   => @$events[$i]['DESCRIPTION'],
                                'source'  => 'Sync',
                                'price'   => $price,
                                'status'  => 'Not available',
                            ];

                            if($rooms_price->has_reservation($days[$j])) {
                                Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[$j]], $calendar_data);
                            }
                        }
                    }
                }

                // Update last synchronization DateTime
                $imported_ical = ImportedIcal::find($row->id);

                $imported_ical->last_sync = date('Y-m-d H:i:s');

                $imported_ical->save();
            }
        }

        return redirect('manage-listing/'.$request->id.'/calendar');
    }

    /**
     * Get days between two dates
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
     */
    public function get_days($sStartDate, $sEndDate)
    {
        $sStartDate   = date("Y-m-d", $sStartDate);        
        $sEndDate   = date("Y-m-d", $sEndDate);        
        $aDays[]      = $sStartDate;  

        $sCurrentDate = strtotime($sStartDate);
        $checkEndDate = strtotime($sEndDate);

        while($checkEndDate!='' && $sCurrentDate!='' && $sCurrentDate < $checkEndDate) {
            $sCurrentDate = date("Y-m-d",$sCurrentDate);  
            $aDays[]      = $sCurrentDate;
            $sCurrentDate = strtotime($sCurrentDate . '+1 day');
        }
        return $aDays;
    }

    /**
     * Get days between two dates for reservation
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
     */
    public function get_days_reservation($sStartDate, $sEndDate)
    {
        $aDays[]      = $sStartDate;  

        $sCurrentDate = strtotime($sStartDate);  

        while($sCurrentDate < $sEndDate) {
            $sCurrentDate = date("Y-m-d", $sCurrentDate);  
            $aDays[]      = $sCurrentDate;  
        }

        return $aDays;  
    }

    /**
     * Get already synced calendar for room
     *
     * @return array $days      Between two dates
     */
    public function get_synced_calendar()
    {
        $room_id = request()->room_id;
        $ical_details = ImportedIcal::where('room_id',$room_id)->get();
        return $ical_details->toJson();
    }

    /**
     * Remove already synced calendar for room
     *
     * @return array $days      Between two dates
     */
    public function remove_sync_calendar()
    {
        $ical_id = request()->ical_id;
        $ical_details = ImportedIcal::find($ical_id);
        $room_id = $ical_details->room_id;
        if(!empty($ical_details)) {
            $ical_details->delete();
        }
        return ImportedIcal::where('room_id',$room_id)->count();
    } 
}
