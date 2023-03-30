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
use App\Models\Boat;
use Auth;

class BoatsDataTable extends DataTable
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
            ->addColumn('id', function ($boat) {
                return '<span class="notranslate">'.$boat->id.'</span>';
            })
            ->addColumn('from_date', function ($boat) {
                return '<span class="notranslate">'.$boat->from_date.'</span>';
            })
            ->addColumn('to_date', function ($boat) {
                return '<span class="notranslate">'.$boat->to_date.'</span>';
            })
            ->addColumn('full_day_price', function ($boat) {
                return '<span class="notranslate">'.$boat->full_day_price.'</span>';
            })
            ->addColumn('half_day_price', function ($boat) {
                return '<span class="notranslate">'.$boat->half_day_price.'</span>';
            })
           
            ->addColumn('season_name', function ($boat) {
                return '<span class="notranslate">'.$boat->season_name.'</span>';
            })
            ->addColumn('boat_type', function ($boat) {
                return '<span class="notranslate">'.$boat->boat_type.'</span>';
            })
            ->addColumn('action', function ($boat) {

                $edit = (Auth::guard('admin')->user()->can('edit_boat')) ? '<a href="'.url(ADMIN_URL.'/edit_boat/'.$boat->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                $delete = (Auth::guard('admin')->user()->can('delete_boat')) ? '<a data-href="'.url(ADMIN_URL.'/delete_boat/'.$boat->id).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>' : '';

                return $edit.'&nbsp;'.$delete;
            })
         
            ->rawColumns(['id','from_date', 'to_date', 'full_day_price','half_day_price', 'season_name', 'boat_type', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Rooms $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Boat $model)
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
            ['data' => 'id', 'name' => 'managing_boat_price.id', 'title' => 'Id'],
            ['data' => 'from_date', 'name' => 'managing_boat_price.from_date', 'title' => 'From Date'],
            ['data' => 'to_date', 'name' => 'managing_boat_price.to_date', 'title' => 'To Date'],
            ['data' => 'full_day_price', 'name' => 'managing_boat_price.full_day_price', 'title' => 'Full Day Price'],
            ['data' => 'half_day_price', 'name' => 'managing_boat_price.half_day_price', 'title' => 'Half Day Price'],
            ['data' => 'season_name', 'name' => 'managing_boat_price.season_name', 'title' => 'Season'],
            ['data' => 'boat_type', 'name' => 'managing_boat_price.boat_type', 'title' => 'Boat Type'],
           
           
           
           
        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'manage_boat_price_' . date('YmdHis');
    }

    /**
     * Get Rooms Steps Count.
     *
     * @return int
     */
    protected function get_steps_count($id)
    {
       
  $rs_result=Boat::find($id);
  
  if($rs_result =='')
  {
      return 6;
  }
  return 6 - ($rs_result->from_date + $rs_result->to_date + $rs_result->half_day_price + $rs_result->full_day_price + $rs_result->high_half_day_price + $rs_result->high_full_day_price+$rs_result->low_half_day_price + $rs_result->low_full_day_price+$rs_result->after_half_day_price + $rs_result->after_full_day_price);

  
    }
}
