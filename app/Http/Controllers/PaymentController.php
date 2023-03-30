<?php

/**
 * Payment Controller
 *
 * @package     Tempus media | Booking
 * @subpackage  Controller
 * @category    Payment
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

 namespace App\Http\Controllers;
 use App\Mail\MailQueue;
 use Exception;
 use App\Http\Controllers\EmailController;
 use App\Http\Requests;
 use App\Http\Controllers\Controller;
 use Redirect;
 use App\Http\Requests\BookingRequest;
 use App\Models\Language;
 use App\Models\ProfilePicture;
 use App\Models\ReferralSettings;
 use App\Models\User;
 use App\Models\UsersVerification;
 use App\Order;
 use Carbon\Carbon;
 use Illuminate\Http\Request;
 use Omnipay\Omnipay;
 use App\Models\Rooms;
 use App\Models\Boat;
 use App\Models\BoatBooking;
 use App\Models\BoatBookingInfo;
 
 use App\Models\RoomsPrice;
 use App\Models\Currency;
 use App\Models\Country;
 use App\Models\PaymentGateway;
 use App\Models\Reservation;
 use App\Models\Calendar;
 use App\Models\Messages;
 use App\Models\Payouts;
 use App\Models\CouponCode;
 use App\Models\Referrals;
 use App\Models\AppliedTravelCredit;
 use App\Models\HostPenalty;
 use App\Models\SpecialOffer;
 use App\Models\Fees;
 use Validator;
 use App\Http\Helper\PaymentHelper;
 use App\Http\Start\Helpers;
 use DateTime;
 use Session;
 use Auth;
 use DB;
 use JWTAuth;
 use Mail;
 use App\Mail\DemoMail;
 
 use App\Repositories\StripePayment;

class PaymentController extends Controller
{

    protected $omnipay; // Global variable for Omnipay instance

    protected $payment_helper; // Global variable for Helpers instance

    /**
     * Constructor to Set PaymentHelper instance in Global variable
     *
     * @param array $payment Instance of PaymentHelper
     */
    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
        $this->helper = new Helpers;
    }


    public function payment(Request $request, $id){

    //    return encrypt($id);

        $data['encrypted_id'] = $id;

        $id = decrypt($id);

        $reservation = Reservation::with('users')->where('id', $id)->first();
        $reservation->update(['status' => 'Checkout']);

        if(!$reservation)
            abort(404);

        Auth::loginUsingId($reservation->user_id);


        $read_count   = Messages::where('reservation_id',$id)->where('user_to',Auth::user()->id)->where('read','0')->count();

        if($read_count !=0)
            Messages::where('reservation_id',$id)->where('user_to',Auth::user()->id)->update(['read' =>'1']);

        $data['messages'] = Messages::with('user_details','reservation')->where('reservation_id',$id)->orderBy('created_at','desc')->get();

        $data['special_offer'] = SpecialOffer::where('id',@$data['messages'][0]['special_offer_id'])->get();


        if(@$data['messages'][0]->reservation->rooms->user_id == Auth::user()->id)
            abort('404');
        // check avablity in special offer
        $data['avablity']=0;
        if(@$data['messages'][0]->special_offer_id!='')
        {
            $checkin_guest=$data['messages'][0]->special_offer->checkin;
            $checkout_guest=$data['messages'][0]->special_offer->checkout;
            $data['price_list'] = json_decode($this->payment_helper->price_calculation($data['messages'][0]->special_offer->room_id, $data['messages'][0]->special_offer->checkin,$data['messages'][0]->special_offer->checkout, $data['messages'][0]->special_offer->number_of_guests, $data['messages'][0]->special_offer_id,'',''));
            $data['checkin']=date(PHP_DATE_FORMAT,strtotime($checkin_guest));
            $data['checkout']=date(PHP_DATE_FORMAT,strtotime($checkout_guest));
            $from                       = new DateTime(date('Y-m-d', $this->helper->custom_strtotime($data['messages'][0]->special_offer->checkin)));
            $to                         = new DateTime(date('Y-m-d', $this->helper->custom_strtotime($data['messages'][0]->special_offer->checkout)));
            $data['special_offer_nights'] =  $to->diff($from)->format("%a");
        }

        $data["guest_percentage"]            = Fees::find(1)->value;
        $data['title'] = 'Conversation ';
        $data['result'] =  Rooms::findOrFail($reservation->room_id);



         if($request->has('edo'))
             return $data;

        return view('rogoznica.checkout', $data);
    }


    /**
     * Setup the Omnipay PayPal API credentials
     *
     * @param string $gateway PayPal Payment Gateway Method as PayPal_Express/PayPal_Pro
     * PayPal_Express for PayPal account payments, PayPal_Pro for CreditCard payments
     */
    public function setup($gateway = 'PayPal_Express')
    {
        // Create the instance of Omnipay
        $this->omnipay = Omnipay::create($gateway);
        // Get PayPal credentials from payment_gateway table
        $paypal_credentials = PaymentGateway::where('site', 'PayPal')->get();

        $this->omnipay->setUsername($paypal_credentials[0]->value);
        $this->omnipay->setPassword($paypal_credentials[1]->value);
        $this->omnipay->setSignature($paypal_credentials[2]->value);
        $this->omnipay->setTestMode(($paypal_credentials[3]->value == 'sandbox') ? true : false);
        $this->omnipay->setLandingPage('Login');
    }

    /**
     * Load Payment view file
     *
     * @param $request  Input values
     * @return payment page view
     */
    public function index(Request $request)
    {
        

        if (session('get_token') != '') {
            // $user = @JWTAuth::authenticate(session('get_token'));
            $user = JWTAuth::parseToken()->authenticate();
            \App::setLocale(session('language'));
            $mobile_web_auth_user_id = $user->id;
            $currency_details = @Currency::where('code', $user->currency_code)->first();
            session(['currency_symbol' => $currency_details->original_symbol]); //mobile  currency_symbol
            session(['currency' => $currency_details->code]);
        } else {
            $mobile_web_auth_user_id = @Auth::user()->id;
        }
        $s_key = request()->s_key ?: time() . request()->id . str_random(4);
        $data = array();
        $data['user_id'] = $mobile_web_auth_user_id;
        $data['s_key'] = $s_key;
        $data['special_offer_id'] = '';
        $data['special_offer_type'] = '';

        if (request()->s_key) {
            $payment = session('payment.' . request()->s_key);
        } else if (request()->method() == 'POST') {
            $payment = [
                'payment_room_id'          => request()->id,
                'payment_checkin'          => request()->checkin,
                'payment_checkout'         => request()->checkout,
                'payment_number_of_guests' => request()->number_of_guests,
                'payment_booking_type'     => request()->booking_type,
                'payment_special_offer_id' => @request()->special_offer_id,
                'payment_reservation_id'   => request()->reservation_id,
                'payment_cancellation'     => request()->cancellation,
            ];
            Session::put('payment.' . $s_key, $payment);
        } else if (request()->method() == 'GET') {
            $payment = [
                'payment_room_id'          => request()->room_id,
                'payment_checkin'          => date('Y-m-d', strtotime(@request()->checkin)),
                'payment_checkout'         => date('Y-m-d', strtotime(@request()->checkout)),
                'payment_number_of_guests' => request()->number_of_guests,
                'payment_special_offer_id' => request()->special_offer_id,
                'payment_booking_type'     => 'instant_book',
                'payment_reservation_id'   => request()->reservation_id,
                'payment_cancellation'     => request()->cancellation,
            ];
            Session::put('payment.' . $s_key, $payment);
        }

        if (!$payment) {
            return redirect('/');
        }

        if (@$payment['payment_special_offer_id'] != '') {
            $special_offer_id = $payment['payment_special_offer_id'];
            $special_offer_data = SpecialOffer::where('id', $special_offer_id)->where('user_id', $mobile_web_auth_user_id)->first();
            if (!$special_offer_data) {
                $host_name = Rooms::find($payment['payment_room_id'])->host_name;

                flash_message('danger', trans('messages.inbox.type_removed_by_host', ['type' => trans('messages.inbox.special_offer'), 'host_name' => $host_name]), url('inbox'));
                if (\URL::previous() && !strrpos(\URL::previous(), 'pcss')) {
                    return back();
                }

                return redirect('inbox');
            }

            $already = Reservation::where('special_offer_id', $special_offer_id)->where('status', 'Accepted')->first();

            if ($already) {
                flash_message('danger', trans('messages.inbox.already_booked'));
                Session::forget('payment.' . $s_key);
                if (\URL::previous() && !strrpos(\URL::previous(), 'pcss')) {
                    return back();
                }

                return redirect('trips/current');
            }
            $data['special_offer_id'] = $special_offer_id;
            $data['special_offer_type'] = $special_offer_data->type;
        } else if (@$payment['payment_reservation_id'] != '') {
            $reservation_id = $payment['payment_reservation_id'];
            $reservation = Reservation::where('id', $reservation_id)->where('user_id', $mobile_web_auth_user_id)->first();
            if (!$reservation) {
                if (session('get_token') == '') {
                    flash_message('danger', trans('messages.rooms.dates_not_available')); // Call flash message function

                    return redirect('trips/current');
                } else {
                    return response()->json(['success_message' => 'Rooms Dates Not Available', 'status_code' => '0']);
                }
            } else {
                /* check reservation status is already booked or cancelled
                * if Accepted - redirect user to rooms detail page with dates not available flash
                * if Cancelled - redirect user to search page with your reservation has been cancelled flash
                */
                if ($reservation->status == 'Accepted') {
                    flash_message('danger', trans('messages.rooms.dates_not_available'));

                    return redirect('rooms/' . $reservation->room_id);
                } else if ($reservation->status == 'Cancelled' && $reservation->cancelled_by == 'Host') {
                    flash_message('danger', trans('messages.email.sorry_book_some_other_dates'));

                    return redirect('s');
                } else if ($reservation->status == 'Cancelled' && $reservation->cancelled_by == 'Guest') {
                    flash_message('danger', trans('messages.email.sorry_book_some_other_dates_guest'));

                    return redirect('s');
                }
            }

            if (request()->segment(1) != 'api_payments') {
                $payment = array(
                    'payment_room_id'          => $reservation->room_id,
                    'payment_checkin'          => date('d-m-Y', strtotime($reservation->checkin)),
                    'payment_checkout'         => date('d-m-Y', strtotime($reservation->checkout)),
                    'payment_number_of_guests' => $reservation->number_of_guests,
                    'payment_special_offer_id' => $reservation->special_offer_id,
                    'payment_booking_type'     => 'instant_book',
                    'payment_reservation_id'   => $reservation->id,
                    'payment_cancellation'     => $reservation->cancellation,
                    'payment_card_type'        => $reservation->paymode,
                );
                Session::put('payment.' . $s_key, $payment);
            }
        }

        if (!@$payment['payment_checkin']) {
            return redirect('rooms/' . request()->id);
        }
        if (!@$payment['payment_room_id']) {
            return redirect('404');
        }

        $payment_room = Rooms::find(@$payment['payment_room_id']);

        if (!$payment_room) {
            return redirect('404');
        }

        $data['result'] = Rooms::find(session('payment')[$s_key]['payment_room_id']);
        $data['room_id'] = session('payment')[$s_key]['payment_room_id'];
        $data['checkin'] = session('payment')[$s_key]['payment_checkin'];
        $data['checkout'] = session('payment')[$s_key]['payment_checkout'];
        $data['number_of_guests'] = session('payment')[$s_key]['payment_number_of_guests'];
        $data['special_offer_id'] = session('payment')[$s_key]['payment_special_offer_id'];
        $data['booking_type'] = session('payment')[$s_key]['payment_booking_type'];
        $data['reservation_id'] = session('payment')[$s_key]['payment_reservation_id'];
        $data['cancellation'] = session('payment')[$s_key]['payment_cancellation'];
        $data['s_key'] = $s_key;
        $from = new DateTime($data['checkin']);
        $to = new DateTime($data['checkout']);
        $data['nights'] = $to->diff($from)->format("%a");

        $travel_credit_result = Referrals::whereUserId($mobile_web_auth_user_id)->get();
        $travel_credit_friend_result = Referrals::whereFriendId($mobile_web_auth_user_id)->get();

        $travel_credit = 0;

        foreach ($travel_credit_result as $row) {
            $travel_credit += $row->credited_amount;
        }

        foreach ($travel_credit_friend_result as $row) {
            $travel_credit += $row->friend_credited_amount;
        }

        if ($travel_credit && session('remove_coupon') != 'yes' && session('manual_coupon') != 'yes' && ($data['reservation_id'] != '' || $data['booking_type'] == 'instant_book')) {
            Session::put('coupon_code', 'Travel_Credit');
            Session::put('coupon_amount', $travel_credit);
        }

        $data['travel_credit'] = $travel_credit;
        $data['price_list'] = json_decode($this->payment_helper->price_calculation($data['room_id'], $data['checkin'], $data['checkout'], $data['number_of_guests'], $data['special_offer_id'], '', $data['reservation_id']));
        $pending_reservation_check = Reservation::where(['room_id' => $data['room_id'], 'id' => $data['reservation_id'], 'checkin' => date('Y-m-d', strtotime($data['checkin'])), 'checkout' => date('Y-m-d', strtotime($data['checkout'])), 'user_id' => $mobile_web_auth_user_id, 'status' => 'Pending'])->get();

        if (@$data['price_list']->status == 'Not available' || $pending_reservation_check->count() > 0) {
            flash_message('danger', trans('messages.rooms.dates_not_available')); // Call flash message function
            Session::forget('payment.' . $s_key);
            if (\URL::previous() && !strrpos(\URL::previous(), 'pcss') && \URL::full() != \URL::previous()) {
                return back();
            }

            return redirect('rooms/' . $data['room_id']);
        }

        if ($data['result']->user_id == $data['user_id']) {
            return redirect('rooms/' . $data['room_id']);
        }

        Session::put('payment.' . $s_key . '.payment_price_list', $data['price_list']);

        $data['paypal_price'] = $this->payment_helper->currency_convert($data['result']->rooms_price->code, PAYPAL_CURRENCY_CODE, $data['price_list']->total);

        $from_rate = @Currency::whereCode($data['result']->rooms_price->currency_code)->first()->rate;
        $to_rate = @Currency::whereCode(PAYPAL_CURRENCY_CODE)->first()->rate;

        $data['paypal_price_rate'] = number_format(($from_rate / $to_rate), 2);

        // Get First Default Currency from currency table
        // $data['currency']         = Currency::where('default_currency', 1)->take(1)->get();
        $data['country'] = Country::all()->pluck('long_name', 'short_name');

        if ($data['booking_type'] == 'instant_book') {
            $data['form_url'] = url('payments/create_booking');
        } else {
            $data['form_url'] = url('payments/pre_accept');
        }

        if (request()->has('edo')) {
            return $data;
        }

        //return $data;
        $data['form_url'] = url('payments/pre_accept');

        return view('rogoznica.payment', $data);

      //  return view('payment.payment', $data);
    }

    //

    /**
     * Pre Accept send to Host
     *
     * @param array $request Input values
     * @return redirect to Rooms Detail page
     */
    public function pre_accept(BookingRequest $request, EmailController $email_controller)
    {


        $date_check = checkdate(request()->birthday_month, request()->birthday_day, request()->birthday_year);

        if ($date_check != true) {
            return back()->withErrors(['birthday_day' => trans('messages.login.invalid_dob'), 'birthday_month' => trans('messages.login.invalid_dob'), 'birthday_year' => trans('messages.login.invalid_dob')])->withInput()->with('error_code', 1);
        }

        if (time() < strtotime(request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day)) {
            return back()->withErrors(['birthday_day' => trans('messages.login.invalid_dob'), 'birthday_month' => trans('messages.login.invalid_dob'), 'birthday_year' => trans('messages.login.invalid_dob')])->withInput()->with('error_code', 1);
        }

        $from = new DateTime(request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day);
        $to = new DateTime('today');
        $age = $from->diff($to)->y;

        if ($age < 18) {
            return back()->withErrors(['minor' => trans('messages.login.below_age')])->withInput()->with('error_code', 1);
        }

        $s_key = request()->session_key;
        $user = $this->create_user();

        // User (Log In)
        Auth::guard()->loginUsingId($user->id);

        $user_id = $user->id;

        if (request()->session_key && request()->session_key != '') {
            if (session('get_token') != '') {
                $user = JWTAuth::toUser(session('get_token'));

                $mobile_web_auth_user_id = $user->id;
            } else {
                $mobile_web_auth_user_id = @Auth::user()->id;
            }

            $country = @session('payment.' . $s_key . '.mobile_payment_counry_code') == '' ? 'US' : session('payment.' . $s_key . '.mobile_payment_counry_code');
            $country_data = Country::where('short_name', $country)->first();

            if (!$country_data) {
                $message = trans('messages.lys.service_not_available_country');
                if (session('get_token') == '') {
                    flash_message('danger', $message); // Call flash message function

                    return back();
                } else {
                    return response()->json(['success_message' => $message, 'status_code' => '0']);
                }
            }


            if (!isset(session('payment')[$s_key])) {
                return redirect(404);
            }

            $booking_room = Rooms::find(session('payment')[$s_key]['payment_room_id']);
            if (!$booking_room) {
                return redirect('404');
            }

            // to prevent host book their own list
            if (session('payment')[$s_key]['payment_room_id']) {
                $user_id = Rooms::find(session('payment')[$s_key]['payment_room_id'])->user_id;

                if ($user_id == @$mobile_web_auth_user_id) {
                    return redirect('rooms/' . session('payment')[$s_key]['payment_room_id']);
                }
            }
            // to prevent host book their own list

            $data['price_list'] = json_decode($this->payment_helper->price_calculation(request()->room_id, request()->checkin, request()->checkout, request()->number_of_guests, request()->special_offer_id));
            if (@$data['price_list']->status == 'Not available') {
                flash_message('danger', trans('messages.rooms.dates_not_available')); // Call flash message function

                return redirect('rooms/' . request()->id);
            }

            //session and request value are equal or not
            $room_id = @session('payment')[$s_key]['payment_room_id'];
            $payment_checkin = @session('payment')[$s_key]['payment_checkin'];
            $payment_checkout = @session('payment')[$s_key]['payment_checkout'];
            $number_of_guests = @session('payment')[$s_key]['payment_number_of_guests'];
            $cancellation = @session('payment')[$s_key]['payment_cancellation'];

            // TODO: provjerit host penalty
            $host_penalty = Fees::find(3)->value;
            $rooms = Rooms::find($room_id);


            $reservation = new Reservation;

            $reservation->room_id = $room_id;
            $reservation->host_id = Rooms::find($room_id)->user_id;
            $reservation->user_id = $mobile_web_auth_user_id;
            $reservation->checkin = date('Y-m-d', strtotime($payment_checkin));
            $reservation->checkout = date('Y-m-d', strtotime($payment_checkout));
            $reservation->number_of_guests = $number_of_guests;
            $reservation->nights = $data['price_list']->total_nights;
            $reservation->per_night = $data['price_list']->per_night;
            $reservation->subtotal = $data['price_list']->subtotal;
            $reservation->cleaning = $data['price_list']->cleaning_fee;
            $reservation->additional_guest = $data['price_list']->additional_guest;
            $reservation->security = $data['price_list']->security_fee;
            $reservation->service = $data['price_list']->service_fee;
            $reservation->host_fee = $data['price_list']->host_fee;
            $reservation->total = $data['price_list']->total;
            $reservation->currency_code = $data['price_list']->currency;
            $reservation->host_penalty = $host_penalty;
            $reservation->type = 'reservation';
            $reservation->status = 'Pending';
            $reservation->cancellation = $cancellation;
            $reservation->country = $country;//'US'; mobile change
            $reservation->paymode = @session('payment.' . $s_key . '.payment_card_type');//mobile change

            $reservation->base_per_night = $data['price_list']->base_rooms_price;
            $reservation->length_of_stay_type = $data['price_list']->length_of_stay_type;
            $reservation->length_of_stay_discount = $data['price_list']->length_of_stay_discount;
            $reservation->length_of_stay_discount_price = $data['price_list']->length_of_stay_discount_price;
            $reservation->booked_period_type = $data['price_list']->booked_period_type;
            $reservation->booked_period_discount = $data['price_list']->booked_period_discount;
            $reservation->booked_period_discount_price = $data['price_list']->booked_period_discount_price;

            $reservation->save();

            $replacement = "[removed]";

            $dots = ".*\..*\..*";

            $email_pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
            $url_pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
            $phone_pattern = "/\+?[0-9][0-9()\s+]{4,20}[0-9]/";

            $find = array($email_pattern, $phone_pattern);
            $replace = array($replacement, $replacement);

            $question = preg_replace($find, $replace, request()->message_to_host);

            if ($question == $dots) {
                $question = preg_replace($url_pattern, $replacement, $question);
            } else {
                $question = preg_replace($find, $replace, request()->message_to_host);
            }

            $message = new Messages;

            $message->room_id = $room_id;
            $message->reservation_id = $reservation->id;
            $message->user_to = $rooms->user_id;
            $message->user_from = $mobile_web_auth_user_id;
            $message->message = $question;
            $message->message_type = 1;
            $message->read = 0;

            $message->save();

            $email_controller->inquiry($reservation->id, $question);

            if (session('get_token') != '') {
                $result = array('success_message' => 'Request Booking Send to Host', 'status_code' => '1');

                return view('json_response.json_response', array('result' => json_encode($result)));
            }
            //end mobile changes
            flash_message('success', trans('messages.rooms.pre-accept_request', ['first_name' => $rooms->users->first_name])); // Call flash message function

            Session::forget('s_key');
            Session::forget('payment.' . $s_key);

            return redirect()->route('payments.requested', encrypt($reservation->id));

            //return redirect('/z/q/' . $reservation->id . '?status=requested');
            //return redirect('trips/current');

        } else {
            return redirect('404');
            if (empty(session('payment'))) return redirect('404');
            $session_key = array_keys(session('payment'));
            $s_key = end($session_key);

            Session::put('s_key', $s_key);

            return redirect('payments/book/' . session('payment')[$s_key]['payment_room_id']);
        }
    }

    /**
     * @return User
     */
    public function create_user()
    {

        $country = request()->payment_country;
        $country_data = Country::where('short_name', $country)->first();


        //get timezone from ip address
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipInfo = file_get_contents_curl('http://www.geoplugin.net/php.gp?ip=' . $ip);
        $ipInfo = json_decode($ipInfo);

        $timezone = !empty($ipInfo) && @$ipInfo->timezone != '' ? $ipInfo->timezone : 'UTC';

        $user = new User;
        $user->first_name = request()->first_name;
        $user->last_name = request()->last_name;
        $user->email = request()->email;
        $user->phone = request()->phone;
        $user->zip = request()->zip;
        $user->address = request()->address;
        $user->city = request()->city;
        $user->country_id = $country_data->id;
        $user->password = \Hash::make(request()->password);
        $user->dob = request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day; // Date format - Y-m-d
        $user->timezone = $timezone;
        $user->email_language = app()->getLocale();
        $user->save();  // Create a new user

        $user_pic = new ProfilePicture;
        $user_pic->user_id = $user->id;
        $user_pic->src = "";
        $user_pic->photo_source = 'Local';
        $user_pic->save();  // Create a profile picture record

        $user_verification = new UsersVerification;
        $user_verification->user_id = $user->id;
        $user_verification->save();  // Create a users verification record

        return $user;
    }

    /**
     * Appy Coupen Code Function
     *
     * @param array $request Input values
     * @return redirect to Payemnt Page
     */
    public function apply_coupon(Request $request)
    {
        $coupon_code = request()->coupon_code;
        $s_key = request()->s_key;
        $result = CouponCode::where('coupon_code', $coupon_code)->where('status', 'Active')->get();
        $coupon_status = "Invalid_coupon";

        if ($result->count()) {
            // get user id
            $user_id = @Auth::user()->id;

            // check if coupon already used by the user
            $reservation_result = Reservation::where('user_id', $user_id)->where('coupon_code', $coupon_code)->get();
            if ($reservation_result->count()) {
                $data['message'] = trans('messages.payments.coupon_already_used');

                return json_encode($data);
            }

            $datetime1 = new DateTime(date('Y-m-d'));
            $datetime2 = new DateTime(date('Y-m-d', $this->helper->custom_strtotime($result[0]->expired_at)));

            $coupon_status = "Expired_coupon";
            if ($datetime1 <= $datetime2) {
                $coupon_status = "Valid_coupon";
            }
        }

        if ($coupon_status == "Valid_coupon") {
            $id = session('payment')[$s_key]['payment_room_id'];
            $price_list = session('payment')[$s_key]['payment_price_list'];
            $code = session('currency');

            $data['coupon_amount'] = $this->payment_helper->currency_convert($result[0]->currency_code, $code, $result[0]->amount);
            $coupon_applied_total = ($price_list->subtotal + $price_list->service_fee) - $data['coupon_amount'];
            $data['coupen_applied_total'] = $coupon_applied_total > 0 ? $coupon_applied_total : 0;
            Session::forget('coupon_code');
            Session::forget('coupon_amount');
            Session::forget('remove_coupon');
            Session::forget('manual_coupon');
            Session::put('coupon_code', $coupon_code);
            Session::put('coupon_amount', $data['coupon_amount']);
            Session::put('manual_coupon', 'yes');
        } else {
            $data['message'] = trans('messages.payments.invalid_coupon');
            if ($coupon_status == "Expired_coupon") {
                $data['message'] = trans('messages.payments.expired_coupon');
            }
        }

        return json_encode($data);
    }

    public function remove_coupon(Request $request)
    {
        Session::forget('coupon_code');
        Session::forget('coupon_amount');
        Session::forget('manual_coupon');
        Session::put('remove_coupon', 'yes');
    }

    /**
     * Payment Submit Function
     *
     * @param array $request Input values
     * @return redirect to Dashboard Page
     */
    public function create_booking(Request $request)
    {
        //   return request()->all();

        // Email signup validation rules
        $rules = array(
            'first_name'     => 'required|max:255',
            'last_name'      => 'required|max:255',
            'email'          => 'required|max:255|email|unique:users',
            'password'       => 'required|min:8',
            'birthday_day'   => 'required',
            'birthday_month' => 'required',
            'birthday_year'  => 'required',
        );

        $messages = array(//
        );

        // Email signup validation custom Fields name
        $attributes = array(
            'first_name'     => trans('messages.login.first_name'),
            'last_name'      => trans('messages.login.last_name'),
            'email'          => trans('messages.login.email_address'),
            'password'       => trans('messages.login.password'),
            'birthday_month' => trans('messages.login.birthday') . ' ' . trans('messages.header.month'),
            'birthday_day'   => trans('messages.login.birthday') . ' ' . trans('messages.header.day'),
            'birthday_year'  => trans('messages.login.birthday') . ' ' . trans('messages.header.year'),
        );
        // Validate Request

        $validator = Validator::make(request()->all(), $rules, $messages);
        $validator->setAttributeNames($attributes);

        if ($validator->fails()) {
            // Form calling with Errors and Input values and error_code 1 for show Signup popup
            return back()->withErrors($validator)->withInput()->with('error_code', 1);
        }

        $date_check = checkdate(request()->birthday_month, request()->birthday_day, request()->birthday_year);

        if ($date_check != true) {
            return back()->withErrors(['birthday_day' => trans('messages.login.invalid_dob'), 'birthday_month' => trans('messages.login.invalid_dob'), 'birthday_year' => trans('messages.login.invalid_dob')])->withInput()->with('error_code', 1);
        }

        if (time() < strtotime(request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day)) {
            return back()->withErrors(['birthday_day' => trans('messages.login.invalid_dob'), 'birthday_month' => trans('messages.login.invalid_dob'), 'birthday_year' => trans('messages.login.invalid_dob')])->withInput()->with('error_code', 1);
        }

        $from = new DateTime(request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day);
        $to = new DateTime('today');
        $age = $from->diff($to)->y;

        if ($age < 18) {
            return back()->withErrors(['birthday_day' => trans('messages.login.below_age'), 'birthday_month' => trans('messages.login.below_age'), 'birthday_year' => trans('messages.login.below_age')])->withInput()->with('error_code', 1);
        }

        //get timezone from ip address
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipInfo = file_get_contents_curl('http://www.geoplugin.net/php.gp?ip=' . $ip);
        $ipInfo = json_decode($ipInfo);

        $timezone = !empty($ipInfo) && @$ipInfo->timezone != '' ? $ipInfo->timezone : 'UTC';

        $user = new User;
        $user->first_name = request()->first_name;
        $user->last_name = request()->last_name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->dob = request()->birthday_year . '-' . request()->birthday_month . '-' . request()->birthday_day; // Date format - Y-m-d
        $user->timezone = $timezone;
        $user->email_language = app()->getLocale();
        $user->save();  // Create a new user

        $user_pic = new ProfilePicture;
        $user_pic->user_id = $user->id;
        $user_pic->src = "";
        $user_pic->photo_source = 'Local';
        $user_pic->save();  // Create a profile picture record

        $user_verification = new UsersVerification;
        $user_verification->user_id = $user->id;
        $user_verification->save();  // Create a users verification record

        // TODO: provjerit $email_controller->welcome_email_confirmation($user);

        // User Auth (Log In)
        Auth::guard()->loginUsingId($user->id);

        $user_id = $user->id;

        $room_details = Rooms::findOrFail(request()->room_id);

        if ($room_details->status != "Listed" && !isset(request()->session_key) && request()->session_key == '' && !isset(session('payment')[request()->session_key])) {
            return redirect('404');
        }

        $s_key = request()->session_key;

        if (session('get_token') != '') {
            $user = JWTAuth::toUser(session('get_token'));
            $mobile_web_auth_user_id = $user->id;
        } else {
            $mobile_web_auth_user_id = Auth::user()->id;
        }

        $reservation_id = $i_id = @session('payment')[$s_key]['payment_reservation_id'];
        $room_id = request()->room_id;
        $checkin = request()->checkin;
        $checkout = request()->checkout;

        // to prevent host book their own list
        if (session('payment')[$s_key]['payment_room_id']) {
            $user_id = Rooms::find(session('payment')[$s_key]['payment_room_id'])->user_id;
            if ($user_id == $mobile_web_auth_user_id) {
                return redirect('rooms/' . session('payment')[$s_key]['payment_room_id']);
            }
        }
        // to prevent host book their own list


        $price_list = json_decode($this->payment_helper->price_calculation(request()->room_id, request()->checkin, request()->checkout, request()->number_of_guests, request()->special_offer_id, '', $reservation_id));

        if ($price_list->status == 'Not available') {
            flash_message('danger', trans('messages.rooms.dates_not_available'));

           // return redirect('trips/current');
            return redirect()->back();
        }

        $amount = $this->payment_helper->currency_convert(request()->currency, PAYPAL_CURRENCY_CODE, $price_list->payment_total);

        $country = request()->payment_country;
        $country_data = Country::where('short_name', $country)->first();

        if (!$country_data && $price_list->coupon_code != 'Travel_Credit') {
            $message = trans('messages.lys.service_not_available_country');
            if (session('get_token') == '') {
                flash_message('danger', $message); // Call flash message function

                return back();
            } else {
                return response()->json(['success_message' => $message, 'status_code' => '0']);
            }
        }
        $message_to_host = request()->message_to_host;

        $room_id = session('payment')[$s_key]['payment_room_id'];
        $checkin = session('payment')[$s_key]['payment_checkin'];
        $checkout = session('payment')[$s_key]['payment_checkout'];
        $number_of_guests = session('payment')[$s_key]['payment_number_of_guests'];
        $reservation_id = @session('payment')[$s_key]['payment_reservation_id'];
        $room = Rooms::find($room_id);

        $payment_description = $room->name . ' ' . $checkin . ' - ' . $checkout;


        //mobile /web redirect
        if (session('get_token') != '') {
            $purchaseData['returnUrl'] = url('api_payments/success?s_key=' . $s_key);
            $purchaseData['cancelUrl'] = url('api_payments/cancel?s_key=' . $s_key);
        } else {
            $purchaseData['returnUrl'] = url('payments/success?s_key=' . $s_key);
            $purchaseData['cancelUrl'] = url('payments/cancel?s_key=' . $s_key);
        }

        session(['payment.' . $s_key . '.amount' => $amount]);
        session(['payment.' . $s_key . '.payment_country' => $country]);
        session(['payment.' . $s_key . '.message_to_host_' . $mobile_web_auth_user_id => $message_to_host]);
        Session::save();

        $data = [
            'room_id'          => request()->room_id,
            'checkin'          => request()->checkin,
            'checkout'         => request()->checkout,
            'number_of_guests' => request()->number_of_guests,
            'price_list'       => $price_list,
            'transaction_id'   => 1233,
            'paymode'          => 'Credit Card',
            'first_name'       => request()->first_name,
            'last_name'        => request()->last_name,
            'postal_code'      => request()->zip,
            'country'          => request()->payment_country,
            'message_to_host'  => session('payment')[$s_key]['message_to_host_' . $mobile_web_auth_user_id],
            's_key'            => $s_key,
        ];
        session(['currency' => request()->currency]);
        $data['price_list']->currency = request()->currency;

        $code = $this->store($data);

        return redirect('reservation/requested?code=' . $code);


        if ($amount > 0) {

            if (request()->payment_type == 'cc') {

                if (request()->payment_intent_id != '') {
                    $stripe_response = $stripe_payment->CompletePayment(request()->payment_intent_id);
                } else {
                    $payment_method = $stripe_payment->createPaymentMethod($stripe_card);
                    if ($payment_method->status != 'success') {
                        flash_message('danger', $payment_method->status_message);

                        return back();
                    }
                    $purchaseData['payment_method'] = $payment_method->payment_method_id;
                    $stripe_response = $stripe_payment->CreatePayment($purchaseData);
                }

                if ($stripe_response->status == 'success') {
                    $data = [
                        'room_id'          => request()->room_id,
                        'checkin'          => request()->checkin,
                        'checkout'         => request()->checkout,
                        'number_of_guests' => request()->number_of_guests,
                        'transaction_id'   => $stripe_response->transaction_id,
                        'price_list'       => $price_list,
                        'paymode'          => 'Credit Card',
                        'first_name'       => request()->first_name,
                        'last_name'        => request()->last_name,
                        'postal_code'      => request()->zip,
                        'country'          => request()->payment_country,
                        'message_to_host'  => session('payment')[$s_key]['message_to_host_' . $mobile_web_auth_user_id],
                        's_key'            => $s_key,
                    ];
                    session(['currency' => request()->currency]);
                    $data['price_list']->currency = request()->currency;
                    $code = $this->store($data);

                    if (session('get_token') != '') {
                        $result = array('success_message' => 'Payment Successfully Paid', 'status_code' => '1');

                        return view('json_response.json_response', array('result' => json_encode($result)));
                    }

                    flash_message('success', trans('messages.payments.payment_success'));

                    return redirect('reservation/requested?code=' . $code);
                }
            }
        }
    }

    /**
     * Callback function for bbooking requested
     *
     * @param array $request Input values
     * @return redirect to Payment Success Page
     */
    public function requested($reservation, Request $request)
    {
        $reservation = decrypt($reservation);
        $reservation = Reservation::findOrFail($reservation);

        if ($reservation->status != 'Pending')
            abort('404');

        return view('rogoznica.request-sent', compact('reservation'));
    }
    /**
     * Callback function for Payment Success
     *
     * @param array $request Input values
     * @return redirect to Payment Success Page
     */
    public function success($reservationHash, $transaction, Request $request)
    {
        $reservation = decrypt($reservationHash);

        $reservation = Reservation::with('rooms')->findOrFail($reservation);


        // $payment_type = $reservation->transactions()->sum('price') >= $reservation->total

        if ($this->payment_helper->verifyWsPaySignature() and $reservation->status != Reservation::COMPLETED) {
            $reservation->transactions()->findOrFail($transaction)
                ->update(['status'                => Reservation::COMPLETED,
                          'payment_message'       => $request->SuccessMessage,
                          'shopping_cart_id'      => $request->ShoppingCartID,
                          'approval_code'         => $request->ApprovalCode,
                          'ws_pay_order_id'       => $request->WsPayOrderId,
                          'transaction_date_time' => Carbon::parse($request->DateTime)->toDateTime(),
                          'ECI'                   => $request->ECI,
                          'STAN'                  => $request->STAN,
                          'payment_partner'       => $request->Partner,
                          'payment_type'          => $request->PaymentType,
                        //  'payment_card'          => $request->PaymentType,
                          'payment_plan'          => $request->PaymentPlan,
                          'credit_card_number'    => $request->CreditCardNumber,
                          'ws_pay_signature'      => $request->Signature,
                ]);

            $reservation->update([
                'status' => Reservation::COMPLETED,
                'code'   => $this->getCode(6, $reservation->id)
            ]);

            $this->update_calendar($reservation);
        } else {
           return $this->error($reservationHash, $transaction, $request);
        }

        flash_message('success', trans('messages.payments.payment_success'));

        return view('rogoznica.payment_success', ['status' => 'success'], compact('reservation'));

    }

    public function error($reservation, $transaction, Request $request)
    {

        $reservation = decrypt($reservation);

        $reservation = Reservation::findOrFail($reservation);

        if ($request->ShoppingCartID) {
            $reservation->transactions()->findOrFail($transaction)
                ->update(['status'             => 'error',
                          'payment_message'    => $request->ErrorMessage,
                          'payment_type'       => $request->PaymentType,
                          'shopping_cart_id'   => $request->ShoppingCartID,
                          'ws_pay_signature'   => $request->Signature,
                          'payment_plan'       => $request->PaymentPlan,
                          'credit_card_number' => $request->CreditCardNumber,
                ]);
        }

        // Call flash message function
        flash_message('danger', 'We were unable to process your credit card payment; If the problem persists, contact us to complete your order.');

        return redirect()->route('payments.payment', [
            'id'      => encrypt($reservation->id),
            'status'  => 'error',
            'message' => $request->ErrorMessage]);

    }

    /**
     * Callback function for Payment Failed
     *
     * @param array $request Input values
     * @return redirect to Payments Booking Page
     */
    public function cancel($reservation, $transaction, Request $request)
    {

        $reservation = decrypt($reservation);


        $reservation = Reservation::findOrFail($reservation);



        if ($request->ShoppingCartID) {

            $reservation->transactions()->findOrFail($transaction)
                ->update(['status' => 'Cancelled',
                          'ws_pay_signature' => $request->Signature,
                ]);
        }

        flash_message('danger', trans('messages.payments.payment_cancelled')); // Call flash message function

        return redirect()->route('payments.payment', [
            'id'      => encrypt($reservation->id),
            'status'  => 'Ca',
            'message' => trans('messages.payments.payment_cancelled')]);

    }


    /**
     * Create Reservation After paypal refund Done when same time booking
     *
     * @param array $data Payment Data
     * @return string $code  Reservation Code
     */
    public function decline_store($data)
    {
        $s_key = $data['s_key'];
        $special_offer_ids = @session('payment')[$s_key]['payment_special_offer_id'];

        //change the contact data status after the contact moved to reservation - For calendar purpose
        if ($special_offer_ids != "" && $special_offer_ids != "0") {
            $get_contact_id = SpecialOffer::find($special_offer_ids);
            if ($get_contact_id) {
                $contact_id = $get_contact_id->reservation_id;
            }
        }

        $mobile_web_auth_user_id = @Auth::user()->id;
        if (session('get_token') != '') {
            $user = JWTAuth::toUser(session('get_token'));
            $mobile_web_auth_user_id = $user->id;
        }

        if (@session('payment')[$s_key]['payment_reservation_id'])
            $reservation = Reservation::find(session('payment')[$s_key]['payment_reservation_id']);
        else
            $reservation = new Reservation;

        $reservation->room_id = $data['room_id'];
        $reservation->host_id = Rooms::find($data['room_id'])->user_id;
        $reservation->user_id = $mobile_web_auth_user_id;
        $reservation->checkin = date('Y-m-d', strtotime($data['checkin']));
        $reservation->checkout = date('Y-m-d', strtotime($data['checkout']));
        $reservation->number_of_guests = $data['number_of_guests'];
        $reservation->nights = $data['price_list']->total_nights;
        $reservation->per_night = $data['price_list']->per_night;
        $reservation->subtotal = $data['price_list']->subtotal;
        if ($data['price_list']->special_offer == '') {
            $reservation->cleaning = $data['price_list']->cleaning_fee;
            $reservation->additional_guest = $data['price_list']->additional_guest;
            $reservation->security = $data['price_list']->security_fee;
        } else {
            $reservation->cleaning = 0;
            $reservation->additional_guest = 0;
            $reservation->security = 0;
        }
        $reservation->service = $data['price_list']->service_fee;
        $reservation->host_fee = $data['price_list']->host_fee;
        $reservation->total = $data['price_list']->total;
        $reservation->currency_code = $data['price_list']->currency;
        $reservation->paypal_currency = PAYPAL_CURRENCY_CODE;

        $reservation->base_per_night = $data['price_list']->base_rooms_price;
        $reservation->length_of_stay_type = $data['price_list']->length_of_stay_type;
        $reservation->length_of_stay_discount = $data['price_list']->length_of_stay_discount;
        $reservation->length_of_stay_discount_price = $data['price_list']->length_of_stay_discount_price;
        $reservation->booked_period_type = $data['price_list']->booked_period_type;
        $reservation->booked_period_discount = $data['price_list']->booked_period_discount;
        $reservation->booked_period_discount_price = $data['price_list']->booked_period_discount_price;

        if ($data['price_list']->coupon_amount) {
            $reservation->coupon_code = $data['price_list']->coupon_code;
            $reservation->coupon_amount = $coupon_amount = $data['price_list']->coupon_amount;
        }
        if (@session('payment')[$s_key]['payment_special_offer_id']) {
            $reservation->special_offer_id = $special_offer_ids;
        }

        $reservation->transaction_id = $data['transaction_id'];
        $reservation->paymode = $data['paymode'];
        $reservation->type = 'reservation';

        if ($data['paymode'] == 'Credit Card') {
            $reservation->first_name = $data['first_name'];
            $reservation->last_name = $data['last_name'];
            $reservation->postal_code = $data['postal_code'];
        }

        $reservation->country = $data['country'];

        if (@session('payment')[$s_key]['payment_reservation_id'] == '') {
            $reservation->cancellation = Rooms::find($data['room_id'])->cancel_policy;
        }

        $reservation->status = @$reservation->id ? $reservation->status : "Declined";
        $reservation->save();

        $messages = new Messages;
        $messages->room_id = $reservation->room_id;
        $messages->reservation_id = $reservation->id;
        $messages->user_to = Auth::user()->id;
        $messages->user_from = $reservation->host_id;
        $messages->message = '';
        $messages->message_type = 10;

        $messages->save();

        Session::forget('coupon_code');
        Session::forget('coupon_amount');
        Session::forget('remove_coupon');
        Session::forget('manual_coupon');
        Session::forget('s_key');
        Session::forget('payment.' . $s_key);

        return true;
    }

    /**
     * Create Reservation After Payment Successfully Done
     *
     * @param array $data Payment Data
     * @return string $code  Reservation Code
     */
    public function store($data)
    {
        \Log::info('data', ['data' => $data]);
        $s_key = $data['s_key'];
        $special_offer_ids = @session('payment')[$s_key]['payment_special_offer_id'];

        //change the contact data status after the contact moved to reservation - For calendar purpose
        if ($special_offer_ids != "" && $special_offer_ids != "0") {
            $get_contact_id = SpecialOffer::find($special_offer_ids);
            if ($get_contact_id) {
                $contact_id = $get_contact_id->reservation_id;
                // Reservation::where('id',$contact_id)->update(['status'=>'Cancelled']);
            }
        }

        if (session('get_token') != '') {
            $user = JWTAuth::toUser(session('get_token'));
            $mobile_web_auth_user_id = $user->id;
        } else {
            $mobile_web_auth_user_id = @Auth::user()->id;
        }

        if (@session('payment')[$s_key]['payment_reservation_id'])
            $reservation = Reservation::find(session('payment')[$s_key]['payment_reservation_id']);
        else
            $reservation = new Reservation;

        $days = $this->get_days(date('Y-m-d', strtotime($data['checkin'])), date('Y-m-d', strtotime($data['checkout'])));

        // Update Calendar
        for ($j = 0; $j < count($days) - 1; $j++) {

            $special_price = Calendar::where('room_id', $data['room_id'])->where('date', $days[$j])->first();
            if ($special_price)
                $price = $special_price->price;
            else
                $price = RoomsPrice::find($data['room_id'])->original_night;

            $calendar_data = [
                'room_id' => $data['room_id'],
                'date'    => $days[$j],
                'status'  => 'Not available',
                'price'   => $price,
            ];
            $calendar = Calendar::updateOrCreate(['room_id' => $data['room_id'], 'date' => $days[$j]], $calendar_data);
            $calendar->spots_booked = $calendar->spots_booked + $data['number_of_guests'];
            $calendar->source = 'Reservation';
            $calendar->save();
        }

        $reservation->room_id = $data['room_id'];
        $reservation->host_id = Rooms::find($data['room_id'])->user_id;
        $reservation->user_id = $mobile_web_auth_user_id;
        $reservation->checkin = date('Y-m-d', strtotime($data['checkin']));
        $reservation->checkout = date('Y-m-d', strtotime($data['checkout']));
        $reservation->number_of_guests = $data['number_of_guests'];
        $reservation->nights = $data['price_list']->total_nights;
        $reservation->per_night = $data['price_list']->per_night;
        $reservation->subtotal = $data['price_list']->subtotal;
        if ($data['price_list']->special_offer == '') {
            $reservation->cleaning = $data['price_list']->cleaning_fee;
            $reservation->additional_guest = $data['price_list']->additional_guest;
        } else {
            $reservation->cleaning = 0;
            $reservation->additional_guest = 0;
        }

        $reservation->security = $data['price_list']->security_fee;
        $reservation->service = $data['price_list']->service_fee;
        $reservation->host_fee = $data['price_list']->host_fee;
        $reservation->total = $data['price_list']->total;
        $reservation->currency_code = $data['price_list']->currency;
        $reservation->paypal_currency = PAYPAL_CURRENCY_CODE;

        $reservation->base_per_night = $data['price_list']->base_rooms_price;
        $reservation->length_of_stay_type = $data['price_list']->length_of_stay_type;
        $reservation->length_of_stay_discount = $data['price_list']->length_of_stay_discount;
        $reservation->length_of_stay_discount_price = $data['price_list']->length_of_stay_discount_price;
        $reservation->booked_period_type = $data['price_list']->booked_period_type;
        $reservation->booked_period_discount = $data['price_list']->booked_period_discount;
        $reservation->booked_period_discount_price = $data['price_list']->booked_period_discount_price;

        if ($data['price_list']->coupon_amount) {
            $reservation->coupon_code = $data['price_list']->coupon_code;
            $reservation->coupon_amount = $coupon_amount = $data['price_list']->coupon_amount;
        }
        if (@session('payment')[$s_key]['payment_special_offer_id']) {
            $reservation->special_offer_id = $special_offer_ids;
        }

        $reservation->transaction_id = $data['transaction_id'];
        $reservation->paymode = $data['paymode'];
        $reservation->type = 'reservation';

        if ($data['paymode'] == 'Credit Card') {
            $reservation->first_name = $data['first_name'];
            $reservation->last_name = $data['last_name'];
            $reservation->postal_code = $data['postal_code'];
        }

        $reservation->country = $data['country'];
        $reservation->status = (@session('payment')[$s_key]['payment_booking_type'] == 'instant_book') ? 'Accepted' : 'Pending';

        if (@session('payment')[$s_key]['payment_reservation_id'] == '') {
            $reservation->cancellation = Rooms::find($data['room_id'])->cancel_policy;
            $reservation->host_penalty = Fees::find(3)->value;
        }

        $reservation->save();

        if (@$data['price_list']->coupon_code == 'Travel_Credit') {
            $coupon_amount = $data['price_list']->coupon_amount;
            $referral_friend = Referrals::whereFriendId($mobile_web_auth_user_id)->get();
            foreach ($referral_friend as $row) {
                $friend_credit = $row->friend_credited_amount;
                if ($coupon_amount != 0) {
                    if ($friend_credit <= $coupon_amount) {
                        $referral = Referrals::find($row->id);
                        $referral->friend_credited_amount = 0;
                        $referral->save();
                        $coupon_amount = $coupon_amount - $friend_credit;

                        $applied_referral = new AppliedTravelCredit;
                        $applied_referral->reservation_id = $reservation->id;
                        $applied_referral->referral_id = $row->id;
                        $applied_referral->amount = $friend_credit;
                        $applied_referral->type = 'friend';
                        $applied_referral->currency_code = $data['price_list']->currency;
                        $applied_referral->save();
                    } else {
                        $referral = Referrals::find($row->id);
                        $remain = $friend_credit - $coupon_amount;
                        $referral->friend_credited_amount = $referral->convert($remain);
                        $referral->save();

                        $applied_referral = new AppliedTravelCredit;
                        $applied_referral->reservation_id = $reservation->id;
                        $applied_referral->referral_id = $row->id;
                        $applied_referral->amount = $coupon_amount;
                        $applied_referral->type = 'friend';
                        $applied_referral->currency_code = $data['price_list']->currency;
                        $applied_referral->save();
                        $coupon_amount = 0;
                    }
                }
            }
            $referral_user = Referrals::whereUserId($mobile_web_auth_user_id)->get();
            foreach ($referral_user as $row) {
                $user_credit = $row->credited_amount;
                if ($coupon_amount != 0) {
                    if ($user_credit <= $coupon_amount) {
                        $referral = Referrals::find($row->id);
                        $referral->credited_amount = 0;
                        $referral->save();
                        $coupon_amount = $coupon_amount - $user_credit;

                        $applied_referral = new AppliedTravelCredit;
                        $applied_referral->reservation_id = $reservation->id;
                        $applied_referral->referral_id = $row->id;
                        $applied_referral->amount = $user_credit;
                        $applied_referral->type = 'main';
                        $applied_referral->currency_code = $data['price_list']->currency;
                        $applied_referral->save();
                    } else {
                        $referral = Referrals::find($row->id);
                        $referral->credited_amount = $user_credit - $coupon_amount;
                        $referral->save();

                        $applied_referral = new AppliedTravelCredit;
                        $applied_referral->reservation_id = $reservation->id;
                        $applied_referral->referral_id = $row->id;
                        $applied_referral->amount = $coupon_amount;
                        $applied_referral->type = 'main';
                        $applied_referral->currency_code = $data['price_list']->currency;
                        $applied_referral->save();
                        $coupon_amount = 0;
                    }
                }
            }
        }

        do {
            $code = $this->getCode(6, $reservation->id);
            $check_code = Reservation::where('code', $code)->get();
        } while (empty($check_code));

        $reservation_code = Reservation::find($reservation->id);
        $reservation_code->code = $code;
        $reservation_code->save();

        if ($reservation_code->status == 'Accepted') {
            $reservation_details = Reservation::find($reservation_code->id);

            $host_payout_amount = $reservation_details->host_payout;

            $this->payment_helper->payout_refund_processing($reservation_details, 0, $host_payout_amount);
        }

        $message = new Messages;
        $messages = '';
        if (@$data['message_to_host'])
            $messages = $this->helper->phone_email_remove($data['message_to_host']);

        $message->room_id = $data['room_id'];
        $message->reservation_id = $reservation->id;
        $message->user_to = $reservation->host_id;
        $message->user_from = $reservation->user_id;
        $message->message = $messages;
        $message->message_type = 2;
        $message->read = 0;

        $message->save();

        $email_controller = new EmailController;
        $email_controller->accepted($reservation->id);
        $email_controller->booking_confirm_host($reservation->id);
        $email_controller->booking_confirm_admin($reservation->id);

        Session::forget('coupon_code');
        Session::forget('coupon_amount');
        Session::forget('remove_coupon');
        Session::forget('manual_coupon');
        Session::forget('s_key');
        Session::forget('payment.' . $s_key);

        return $code;
    }

    /**
     * Get days between two dates
     *
     * @param date $sStartDate Start Date
     * @param date $sEndDate End Date
     * @return array $days      Between two dates
     */
    public
    function get_days($sStartDate, $sEndDate)
    {
        $aDays[] = $sStartDate;
        $sCurrentDate = $sStartDate;

        while ($sCurrentDate < $sEndDate) {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
            $aDays[] = $sCurrentDate;
        }

        return $aDays;
    }

    public function get_days_search($sStartDate, $sEndDate)
    {
        $aDays[] = $sStartDate;
        $sCurrentDate = $sStartDate;
        while ($sCurrentDate < $sEndDate) {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
            $aDays[] = $sCurrentDate;
        }

        return $aDays;
    }

    /**
     * Generate Reservation Code
     *
     * @param date $length Code Length
     * @param date $seed Reservation Id
     * @return string Reservation Code
     */
    public function getCode($length, $seed)
    {
        $code = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";

        mt_srand($seed);

        for ($i = 0; $i < $length; $i++) {
            $code .= $codeAlphabet[mt_rand(0, strlen($codeAlphabet) - 1)];
        }

        return $code;
    }

    /**
     * Generate Reservation Code
     *
     * @param date $length Code Length
     * @param date $seed Reservation Id
     * @return string Reservation Code
     */
    public function getSignature()
    {
       // return request()->all();
        return $this->payment_helper->signature();
    }

    /**
     * Generate Reservation Code
     *
     * @param date $length Code Length
     * @param date $seed Reservation Id
     * @return string Reservation Code
     */
    public function currency_convert(Request $request)
    {
        return $this->payment_helper->currency_convert('EUR', 'HRK', $request->price);
    }

    /**
     * Generate Reservation Code
     *
     * @param date $length Code Length
     * @param date $seed Reservation Id
     * @return string Reservation Code
     */
    public function update_calendar(Reservation $reservation)
    {
        $days = $this->get_days(date('Y-m-d', strtotime($reservation->checkin)), date('Y-m-d', strtotime($reservation->checkout)));

        // Update Calendar
        for ($j = 0; $j < count($days) - 1; $j++) {

            $special_price = Calendar::where('room_id', $reservation->room_id)->where('date', $days[$j])->first();
            if ($special_price)
                $price = $special_price->price;
            else
                $price = RoomsPrice::find($reservation->room_id)->original_night;

            $calendar_data = [
                'room_id' => $reservation->room_id,
                'date'    => $days[$j],
                'status'  => 'Not available',
                'price'   => $price,
            ];
            $calendar = Calendar::updateOrCreate(['room_id' => $reservation->room_id, 'date' => $days[$j]], $calendar_data);
            $calendar->spots_booked = $calendar->spots_booked + $reservation->number_of_guests;
            $calendar->source = 'Reservation';
            $calendar->save();
        }
    }
    public function indexboat(Request $request){
        $boat_type = $request->boat_type;
        if($boat_type == "rent-a-boat-one"){
            $boat_type_data = "Futurama";
        } 
        else{
            $boat_type_data = "Rascal";
        }
      //  dd($request->all());
       // echo "<pre>";
       // print_r($request);   die;
      //$a=$request->boat_type;
      // echo $a; die;
    
      if (session('get_token') != '') {
        $user = JWTAuth::parseToken()->authenticate();
        \App::setLocale(session('language'));
        $mobile_web_auth_user_id = $user->id;
        $currency_details = @Currency::where('code', $user->currency_code)->first();
        session(['currency_symbol' => $currency_details->original_symbol]); //mobile  currency_symbol
        session(['currency' => $currency_details->code]);
      } else {
        $mobile_web_auth_user_id = @Auth::user()->id;
      }
      $s_key = request()->s_key ?: time() . request()->boat_id . str_random(4);
      $data = array();
    
      $data['user_id'] = $mobile_web_auth_user_id;
      $data['s_key'] = $s_key;
    
      if (request()->method() == 'POST') {
        $data['checkin']         = $request->checkin;
        $data['checkout']        = $request->checkout;
        $data['number_of_guests']= $request->number_of_guests;
        $data['half_day_price']  = $request->half_day_price;
        $data['full_day_price']  = $request->full_day_price;
        $data['total']           = $request->total;
        $data['boat_id']         = $request->boat_id;
        $data['room_id']         = $request->boat_id;
        $data['boat_type']  = $boat_type_data;
    
        Session::put('paymentData', $data);
      }
      if (request()->method() == 'GET') {
        $paymentData = Session::get('paymentData');
        if(!$paymentData){
            return redirect('/');
        }
        $data['checkin']         = $paymentData['checkin'];
        $data['checkout']        = $paymentData['checkout'];
        $data['number_of_guests']= $paymentData['number_of_guests'];
        $data['half_day_price']  = $paymentData['half_day_price'];
        $data['full_day_price']  = $paymentData['full_day_price'];
        $data['total']           = $paymentData['total'];
        $data['boat_id']         = $paymentData['boat_id'];
        $data['room_id']         = $paymentData['boat_id'];
        $data['boat_type']  = $boat_type_data;
    
      }
      
      $data['result'] = Boat::find($data['boat_id']);
      $data['booking_type']    ='';
      $data['special_offer_id']='';
      $data['cancellation'] = "";
      $data['nights'] = "";
      $data['reservation_id'] = "";
      $data['country'] = Country::all()->pluck('long_name', 'short_name');
    
      $travel_credit_result = Referrals::whereUserId($mobile_web_auth_user_id)->get();
      $travel_credit_friend_result = Referrals::whereFriendId($mobile_web_auth_user_id)->get();
    
      $travel_credit = 0;
    
      foreach ($travel_credit_result as $row) {
        $travel_credit += $row->credited_amount;
      }
    
      foreach ($travel_credit_friend_result as $row) {
          $travel_credit += $row->friend_credited_amount;
      }
    
      if ($travel_credit && session('remove_coupon') != 'yes' && session('manual_coupon') != 'yes' && ($data['reservation_id'] != '' || $data['booking_type'] == 'instant_book')) {
          Session::put('coupon_code', 'Travel_Credit');
          Session::put('coupon_amount', $travel_credit);
      }
      $data['title'] = 'boatreservation';
      $data['travel_credit'] = $travel_credit;
    
      $data['form_url'] = url('payments/boatpayment');
      
      return view('rogoznica.payment_boat', $data);
    }    
    public function indexboatOld(Request $request){
         
      $checkIn_date= $request->checkin;
    
      $checkOut_date=$request->checkout;
      $no_of_persons=$request->number_of_guests;
      $half_day_price=$request->half_day_price;
      $full_day_price=$request->full_day_price;
      $total=$request->total;
      $id=$request->boat_id;
      $boat_type = $boat_type_data; 
          
      if (session('get_token') != '') {
        $user = JWTAuth::parseToken()->authenticate();
        \App::setLocale(session('language'));
        $mobile_web_auth_user_id = $user->id;
        $currency_details = @Currency::where('code', $user->currency_code)->first();
        session(['currency_symbol' => $currency_details->original_symbol]); //mobile  currency_symbol
        session(['currency' => $currency_details->code]);
      } else {
        $mobile_web_auth_user_id = @Auth::user()->id;
      }
      $s_key = request()->s_key ?: time() . request()->boat_id . str_random(4);
      $data = array();
      $data['user_id'] = $mobile_web_auth_user_id;
      $data['s_key'] = $s_key;
      $data['special_offer_id'] = '';
      $data['special_offer_type'] = '';
        
    
      if (request()->s_key) {
        $payment = session('payment.' . request()->s_key);
      } else if (request()->method() == 'POST') {
        $payment = [
        'payment_room_id'          => request()->boat_id,
        'payment_checkin'          => request()->checkin,
        'payment_checkout'         => request()->checkout,
        'payment_number_of_guests' => request()->number_of_guests,
        'payment_full_day_price' => request()->full_day_price,
        'payment_half_day_price' => request()->half_day_price,
        'payment_total' => request()->total,
        'payment_boat_type' => $boat_type_data,
        'payment_booking_type'     => "",
        'payment_special_offer_id' => "",
        'payment_reservation_id'   => "",
        'payment_cancellation'     => "",
    
        ];
        Session::put('payment.' . $s_key, $payment);
      } else if (request()->method() == 'GET') {
        $payment = [
        'payment_room_id'          => request()->boat_id,
        'payment_checkin'          => date('Y-m-d', strtotime(@request()->checkin)),
        'payment_checkout'         => date('Y-m-d', strtotime(@request()->checkout)),
        'payment_number_of_guests' => request()->number_of_guests,
        'payment_full_day_price' => request()->full_day_price,
        'payment_half_day_price' => request()->half_day_price,
        'payment_total' => request()->total,
        'payment_boat_type' => $boat_type_data,
        'payment_special_offer_id' => "",
        'payment_booking_type'     => 'instant_book',
        'payment_reservation_id'   => "",
        'payment_cancellation'     => "",
    
        ];
        Session::put('payment.' . $s_key, $payment);
      }
    
      if (!$payment) {
        return redirect('/');
      } 
    
      if (request()->segment(1) != 'api_payments') {
        $payment = array(
          'payment_id'          => request()->boat_id,
          'payment_checkin'          => date('d-m-Y', strtotime(request()->checkin)),
          'payment_checkout'         => date('d-m-Y', strtotime(request()->checkout)),
          'payment_number_of_guests' => request()->number_of_guests,
          'payment_full_day_price' => request()->full_day_price,
          'payment_half_day_price' => request()->half_day_price,
          'payment_total' => request()->total,
          'payment_boat_type' => $boat_type_data,
         
          'payment_card_type'        => "",
        );
        Session::put('payment.' . $s_key, $payment);
      }
            
    
      $data['result'] = Boat::find(request()->boat_id);
      $data['full_day_price']=$request->full_day_price;
      $data['half_day_price']=$request->half_day_price;
    
    
      $data['room_id'] = request()->boat_id;
      $data['checkin'] = $checkIn_date;
      $data['checkout'] = $checkIn_date;
      $data['boat_type'] = $boat_type_data;
    
      $data['number_of_guests'] = session('payment')[$s_key]['payment_number_of_guests'];
      $data['total'] = session('payment')[$s_key]['payment_total'];
    
      $data['special_offer_id'] = "";
      $data['booking_type'] = "";
      $data['reservation_id'] = "";
      $data['cancellation'] = "";
      $data['s_key'] = $s_key;
      $from = "";
      $to = "";
      $data['nights'] = "";
    
        
    
      $travel_credit_result = Referrals::whereUserId($mobile_web_auth_user_id)->get();
      $travel_credit_friend_result = Referrals::whereFriendId($mobile_web_auth_user_id)->get();
    
      $travel_credit = 0;
    
      foreach ($travel_credit_result as $row) {
          $travel_credit += $row->credited_amount;
      }
    
      foreach ($travel_credit_friend_result as $row) {
          $travel_credit += $row->friend_credited_amount;
      }
    
      if ($travel_credit && session('remove_coupon') != 'yes' && session('manual_coupon') != 'yes' && ($data['reservation_id'] != '' || $data['booking_type'] == 'instant_book')) {
          Session::put('coupon_code', 'Travel_Credit');
          Session::put('coupon_amount', $travel_credit);
      }
      
      $data['travel_credit'] = $travel_credit;
      
      $data['country'] = Country::all()->pluck('long_name', 'short_name');
    
      if ($data['booking_type'] == 'instant_book') {
      } else {
    
      }
    
      if (request()->has('edo')) {
          return $data;
      }
      $data['form_url'] = url('payments/boatpayment');
      return view('rogoznica.payment_boat', $data);
    }
    
    
    
    public function rentboatformsubmita(Request $request)
    {
      //  dd($request->all());
        $request->validate([ 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'email' => 'required', 
            'password' => 'required', 
            'phone' => 'required', 
            'zip' => 'required', 
            'payment_country' => 'required', 
            'city' => 'required', 
            'address' => 'required', 
            'birthday_month' => 'required', 
            'birthday_day' => 'required',
            'birthday_year'=> 'required',
          ]);
        
       
     // save data into a boat booking table
    try{
        $boat_booking = new BoatBooking();
        $boat_booking->boat_id = $request->room_id;
        $boat_booking->checkIn_date = $request->checkin;
        $boat_booking->checkOut_date = $request->checkout;
        $boat_booking->no_of_person = $request->number_of_guests;
        $boat_booking->half_day_price = $request->half_day_price;
        $boat_booking->full_day_price  = $request->full_day_price;
        $boat_booking->total = $request->total;
        $boat_booking->boat_type = $request->boat_type;
    
        $boat_booking->status = "book";
        $boat_booking->save();
        $boat_booking->id;
        $boot_booking_info = new BoatBookingInfo();
        $boot_booking_info->boat_booking_id = $boat_booking->id;
        $boot_booking_info->first_name =$request->first_name;
        $boot_booking_info->last_name =$request->last_name;
        $boot_booking_info->email =$request->email;
        $boot_booking_info->phone=$request->phone;
        $boot_booking_info->zip_code=$request->zip;
        $boot_booking_info->country=$request->payment_country;
        $boot_booking_info->city=$request->city;
        $boot_booking_info->address=$request->address;
        $birthday_day=$request->birthday_day;
        $birthday_month=$request->birthday_month;
        $birthday_year=$request->birthday_year;
        $dob= $birthday_year."-". $birthday_month. "-". $birthday_day;
        $boot_booking_info->date_of_birth=$dob;
        $boot_booking_info->message=$request->msg;
     
       if(  $boot_booking_info->save())
       {
       
       
    try{
        $data['subject'] = "Boat Reservation success ";
        
        $data['title'] = "boat reservation confirmation email";
       
        $data['booking_id']= $boat_booking->id;
        $data['name']=$request->first_name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['zip']= $request->zip;
        $data['country']=$request->payment_country;
        $data['city']=$request->city;
        $data['address']=$request->address; 
        $data['half_day_price']=$request->half_day_price;
        $data['full_day_price']=$request->full_day_price;
        $data['total']=$request->total;
        $data['no_of_people']=$request->number_of_guests;
        $data['checkin_date']= $request->checkin;
        $data['boat_type']=$request->boat_type;
       
        
       
        Mail::send(['text'=>'email.demoMail'], $data, function($message) {
            $message->to('kirti_sharma@softprodigy.com', 'Boat Reservation ')->subject
               ('Boat Booking Confirmation');
            $message->from('info@adriana.travel','Adriana Travel');
         });
         echo "Email Sent";
    
    
    
    
    
    
    
      }
      catch(\Exception $e){
        echo "<pre>";print_r($e->getMessage());echo "<br>";
      }
    
    
        Session::flush('paymentData');
    
    
         return redirect()->route('payments.requestedboat', encrypt($boat_booking->id));
    
    
    
       }
       else{
           echo "error";
       }
    
    }
    catch(\Exception $e){
      
    }
     
    
      
    }
    
    public function requestedboat($reservation, Request $request)
        {
            //echo "hi"; die;
    
            $reservation = decrypt($reservation);
          //  echo $reservation;  
          //  $reservation = BoatBookingInfo::findOrFail($reservation);
    //echo "<pre>"; print_r($reservation);
    //echo $reservation;  
        //  $data['title'] = 'Conversation';
    
            return view('rogoznica.request-sent', compact('reservation'));
        }
    
    
    
    
    
    // public function emailtesting()
    // {
    //  try{
    //      $data['name']='neha';
       
    //     Mail::send(['text'=>'email.demoMail'], $data, function($message) {
    //         $message->to('neha_khandelwal@softprodigy.com', 'Tutorials Point')->subject
    //            ('Laravel Basic Testing Mail');
    //         $message->from('sales@softprodigy.com','Virat Gandhi');
    //      });
    //      echo "Basic Email Sent. Check your inbox.";
    //     }
    //     catch(Exception $e)
    //     {
    //         echo "<pre>";
    //         print_r($e);
    //     }
    
    
    
    
    
    
    
    
    
    
    
    
        //////////
    
    //}
    
    }
