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
use App\Models\BoatBooking;
use Auth;

class BoatBookingDataTable extends DataTable
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
            
            ->addColumn('id', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->id.'</span>';
            })
        
         
            ->addColumn('checkIn_date', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->checkIn_date.'</span>';
            })
         
          
            ->addColumn('no_of_person', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->no_of_person.'</span>';
            })

            ->addColumn('half_day_price', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->half_day_price.'</span>';
            })
            ->addColumn('full_day_price', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->full_day_price.'</span>';
            })

          ->addColumn('full_day_price', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->full_day_price.'</span>';
            })
            ->addColumn('total', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->total.'</span>';
            })
            ->addColumn('boat_type', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->boat_type.'</span>';
            })
            
            ->addColumn('status', function ($boat_booking) {
                return '<span class="notranslate">'.$boat_booking->status.'</span>';
            })
            ->addColumn('action', function ($boat_booking) {

                $edit = (Auth::guard('admin')->user()->can('edit_boat_booking')) ? '<a href="'.url(ADMIN_URL.'/edit_boat_booking/'.$boat_booking->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                $delete = (Auth::guard('admin')->user()->can('delete_boat_booking')) ? '<a data-href="'.url(ADMIN_URL.'/delete_boat_booking/'.$boat_booking->id).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>' : '';

                return $edit.'&nbsp;'.$delete;
            })
         
            ->rawColumns(['id','checkIn_date', 'no_of_person', 'half_day_price', 'full_day_price', 'total', 'boat_type', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Rooms $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BoatBooking $model)
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
            ['data' => 'id', 'name' => 'boat_booking.id', 'title' => 'Id'],

            ['data' => 'checkIn_date', 'name' => 'boat_booking.checkIn_date', 'title' => 'CheckIn Date'],
            ['data' => 'no_of_person', 'name' => 'boat_booking.no_of_person', 'title' => 'No of person'],
            ['data' => 'half_day_price', 'name' => 'boat_booking.half_day_price', 'title' => 'half day price'],
            ['data' => 'full_day_price', 'name' => 'boat_booking.full_day_price', 'title' => 'full day price'],
            ['data' => 'total', 'name' => 'boat_booking.total', 'title' => 'Total'],
            ['data' => 'boat_type', 'name' => 'boat_booking.boat_type', 'title' => 'Boat Type'],
  
            ['data' => 'status', 'name' => 'boat_booking.status', 'title' => 'Status'],
   
       
                      
        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'boat_booking_' . date('YmdHis');
    }

    /**
     * Get Rooms Steps Count.
     *
     * @return int
     */
    protected function get_steps_count($id)
    {
     
  $rs_result=BoatBooking::find($id);
  if($rs_result =='')
  {
      return 6;
  }
  return 6 - ($rs_result->date + $rs_result->date + $rs_result->capacity + $rs_result->half_day + $rs_result->full_day + $rs_result->status);

    }
}
