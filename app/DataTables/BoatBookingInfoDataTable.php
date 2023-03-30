<?php

/**
 * Rooms DataTable
 *
 * @package     Tempus media | Booking
 * @subpackage  DataTable
 * @category    Rooms
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\BoatBookingInfo;
use Auth;

class BoatBookingInfoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            
            ->addColumn('id', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->id.'</span>';
            })
            ->addColumn('boat_booking_id', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->boat_booking_id.'</span>';
            })
         
            ->addColumn('first_name', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->first_name.'</span>';
            })
         
            ->addColumn('last_name', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->last_name.'</span>';
            })
            ->addColumn('email', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->email.'</span>';
            })

            ->addColumn('phone', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->phone.'</span>';
            })
            ->addColumn('zip_code', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->zip_code.'</span>';
            })

          ->addColumn('country', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->country.'</span>';
            })
            ->addColumn('city', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->city.'</span>';
            })
            ->addColumn('address', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->address.'</span>';
            })
            ->addColumn('date_of_birth', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->date_of_birth.'</span>';
            })
            ->addColumn('message', function ($booking_info) {
                return '<span class="notranslate">'.$booking_info->message.'</span>';
            })
            ->addColumn('action', function ($booking_info) {

                $delete = (Auth::guard('admin')->user()->can('delete_boat_booking_info')) ? '<a data-href="'.url(ADMIN_URL.'/delete_boat_booking_info/'.$booking_info->id).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>' : '';

                return $delete;
            })
            
         
            ->rawColumns(['id', 'boat_booking_id','first_name','last_name', 'email', 'phone', 'zip_code', 'country', 'city', 'address', 'date_of_birth', 'message', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Rooms $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BoatBookingInfo $model)
    {

       
        return $model->select(['*']);
       
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->addAction(["printable" => false])
                    ->minifiedAjax()
                    ->dom('lBfr<"table-responsive"t>ip')
                    ->orderBy(0)
                    ->buttons(
                        ['csv','excel','print', 'reset']
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return array(
            ['data' => 'id', 'name' => 'booking_info.id', 'title' => 'Id'],
            ['data' => 'boat_booking_id', 'name' => 'booking_info.boat_booking_id', 'title' => ' Boat Booking Id'],

            ['data' => 'first_name', 'name' => 'booking_info.first_name', 'title' => 'First Name'],
            ['data' => 'last_name', 'name' => 'booking_info.last_name', 'title' => 'Last Name'],
            ['data' => 'email', 'name' => 'booking_info.email', 'title' => 'Email'],
            ['data' => 'phone', 'name' => 'booking_info.phone', 'title' => 'Phone'],
            ['data' => 'zip_code', 'name' => 'booking_info.zip_code', 'title' => 'zip code'],
            ['data' => 'country', 'name' => 'booking_info.country', 'title' => 'Country'],
            ['data' => 'city', 'name' => 'booking_info.city', 'title' => 'City'],
            ['data' => 'address', 'name' => 'booking_info.address', 'title' => 'Address'],
            ['data' => 'date_of_birth', 'name' => 'booking_info.date_of_birth', 'title' => 'date of birth'],
            ['data' => 'message', 'name' => 'booking_info.message', 'title' => 'Message'],
   
       
                      
        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'booking_info_' . date('YmdHis');
    }

    /**
     * Get Rooms Steps Count.
     *
     * @return int
     */
    protected function get_steps_count($id)
    {
     
        $rs_result=BoatBookingInfo::find($id);
        if($rs_result =='')
        {
            return 6;
        }
        return 6 - ($rs_result->id + $rs_result->boat_booking_id + $rs_result->first_name + $rs_result->last_name + $rs_result->email + $rs_result->phone+$rs_result->zip_code+$rs_result->country+$rs_result->city+$rs_result->address+$rs_result->message);
    }
}
