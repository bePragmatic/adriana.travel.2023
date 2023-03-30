<?php

/**
 * Reviews DataTable
 *
 * @package     Tempus media | Booking
 * @subpackage  DataTable
 * @category    Reviews
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\DataTables;

use App\Post;
use Yajra\DataTables\Services\DataTable;
use App\Models\Reviews;
use Auth;


class PostsDataTable extends DataTable
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

            ->addColumn('action', function ($reviews) {
                $edit = '<a href="'.url(ADMIN_URL.'/posts/'.$reviews->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>';

                return $edit;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Reviews $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {

        $reviews = $model::get();
        return $reviews;
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
            ['data' => 'id', 'title' => 'title', 'title' => 'Id'],
            ['data' => 'title', 'title' => 'title', 'title' => 'Title'],

        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'posts_' . date('YmdHis');
    }
}
