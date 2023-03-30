<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\RoomsDataTable;

class BoatsController extends Controller
{
    //
    public function index()
    {
      //  return $dataTable->render('admin.rooms.view');
    //  echo "hi";
    //  die;
      return view('add_boat');
    }

}
