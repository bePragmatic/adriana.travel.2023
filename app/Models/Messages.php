<?php

/**
 * Messages Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Messages
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use Auth;
use Config;
use JWTAuth;
use Session;

class Messages extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $appends = ['created_time','pending_count','archived_count','reservation_count','unread_count','stared_count','all_count','host_check','guest_check','inbox_thread_count','admin_name'];

    public function setAttribute($attribute, $value)
    {
        if($attribute == 'read' || $attribute == 'star' || $attribute == 'archive')
        {
            $this->attributes[$attribute] = $value.'';
        } else {
            $this->attributes[$attribute] = $value;
        }
    }
    // Get All Messages
    public static function all_messages($user_id)
    {
        return Messages::where('user_to', $user_id)->groupby('user_from','user_to')->orderBy('id','desc')->get();
    }

    // Get Admin name
    public  function getAdminNameAttribute()
    {
        return Admin::first()->username;
    }

    // Get All Message Count
    public  function getAllCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('message_type','!=',5)->get()->count();
    }

    // Get Stared Message Count
    public  function getStaredCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('star', '1')->where('message_type','!=',5)->get()->count();
    }

    // Get Unread Message Count
    public  function getUnreadCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('read', '0')->where('message_type','!=',5)->get()->count();
    }

    // Get Reservation Message Count
    public  function getReservationCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'] )->where('reservation_id','!=', 0)->where('message_type','!=',5)->get()->count();
    }

    // Get Archived Message Count
    public  function getArchivedCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('archive', '1')->where('message_type','!=',5)->get()->count();
    }

    // Get Pending Message Count
    public function getPendingCountAttribute()
    {

       if(session('get_token')!='')
        {
            $user = JWTAuth::toUser(session('get_token'));
            $user_id=$user->id;

           return Reservation::join('messages', function($join) use($user_id)
            {
                $join->on('messages.reservation_id', '=', 'reservation.id')->where('reservation.status','=', 'Pending')->where('messages.user_to','=', $user_id)->where('message_type','!=',5);
            })->get()->count();
        }
        else
        {
           return Reservation::join('messages', function($join)
            {
                $join->on('messages.reservation_id', '=', 'reservation.id')->where('reservation.status','=', 'Pending')->where('messages.user_to','=', Auth::user()->id)->where('message_type','!=',5);
            })->get()->count();
        }

    }

    // Host Check
    public function getHostCheckAttribute()
    {
         if(session('get_token')!='')
        {
            $user = JWTAuth::toUser(session('get_token'));

             $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', $user->id)->get();

        if($check->count() !=0)
            return 1;
        else
            return 0;
        }
        else
        {
            $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', Auth::user()->id )->get();

        if($check->count() !=0)
            return 1;
        else
            return 0;
        }
    }

    // Guest Check
    public function getGuestCheckAttribute()
    {
        if(session('get_token')!='')
        {
            $user = JWTAuth::toUser(session('get_token'));

            $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id',$user->id )->get();

        if($check->count() ==0)
            return 1;
        else
            return 0;
        }
        else
        {
           $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', Auth::user()->id )->get();

        if($check->count() ==0)
            return 1;
        else
            return 0;
        }
    }

    // Join to User table
    public function user_details()
    {
        return $this->belongsTo('App\Models\User','user_from','id');
    }

    // Join to Reservation table
    public function reservation()
    {
        return $this->belongsTo('App\Models\Reservation','reservation_id','id');
    }

    // Join to Reservation Alteration table
    public function reservation_alteration()
    {
        return $this->belongsTo('App\Models\ReservationAlteration','reservation_id','reservation_id');
    }

    // Join to Rooms Address table
    public function rooms_address()
    {
        return $this->belongsTo('App\Models\RoomsAddress','room_id','room_id');
    }

    // Join to Rooms Address table
    public function rooms()
    {
        return $this->belongsTo('App\Models\Rooms','room_id','id');
    }


    // Join to Special Offer table
    public function special_offer()
    {
        return $this->belongsTo('App\Models\SpecialOffer','special_offer_id','id');
    }

    // Get Created at Time for Message
    public function getCreatedTimeAttribute()
    {
        $new_str = new DateTime($this->attributes['created_at'], new DateTimeZone(Config::get('app.timezone')));
        $format = (date('d-m-Y') == date('d-m-Y',strtotime($this->attributes['created_at']))) ? 'h:i A' : PHP_DATE_FORMAT;
        //Check user login from mobile or web.Access from payment,message controller from API
        if(session('get_token') != '') {
            $user = JWTAuth::toUser(session('get_token'));
            $timezone = $user->timezone;
        }
        else {
            if(Auth::check()) {
                $timezone = Auth::user()->timezone;
            }
        }
        if(isset($timezone)) {
            $new_str->setTimeZone(new DateTimeZone($timezone));
        }

        return $new_str->format($format);
    }

    // Get Unread Message Count for separate thread
    public  function getInboxThreadCountAttribute()
    {
        $message_count = Messages::where('user_to', $this->attributes['user_to'])->where('read', '0')->where('reservation_id',$this->attributes['reservation_id'])->get()->count();
        return $message_count;
    }

    // Get Message type reason attribue
    public  function getMessageTypeReasonAttribute()
    {
        if($this->attributes['message_type'] == 13){
            $reason_message_head = trans('messages.inbox.resubmit_id_document_head');
        }
        else{
            $reason_message_head = '';
        }
        return $reason_message_head;
    }
}
