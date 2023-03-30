
<style>
  .box-footer {
    display: flex;
    justify-content: center;
}

.box-footer .btn-info {
    margin-right: 10px;
}
select#season_name {
    width: 100%;
    border: 1px solid #ccc;
    background: white;
    padding: 10px 5px;
}
  </style>




@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Boat Price
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    
      </ol>
    </section>
    @error('msg')
    <div class="alert alert-danger">
        {{ $message }}
    </div>
    @enderror
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-8 col-sm-offset-2">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Boat price Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


            {!! Form::open(['url' => ADMIN_URL.'/edit_boat/'.$data->id, 'class' => 'form-horizontal',  'files' => true, 'ng-cloak' => 'ng-cloak']) !!}

              <div class="box-body">
               
              <?php //echo $data->boat_type;    die;  ?>
              <div class="col-sm-6">
                        <label for="inputFirstname">From Date</label>
                        <input type="date" class="form-control" id="from_date"  name="from_date" value={{$data->from_date}} placeholder="from Date">
                        @error('from_date') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                    </div>
                    <div class="col-sm-6">
                        <label for="inputFirstname">To Date</label>
                        <input type="date" class="form-control" id="to_date"  name="to_date"  value={{$data->to_date}} placeholder="to Date">
                        @error('to_date') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                      </div>
                    <div class="col-sm-6">
                        <label for="inputFirstname">Half Day Price</label>
                        <input type="number" class="form-control" id="half_day_price"  name="half_day_price" value={{$data->half_day_price}} placeholder="Half day price">
                        @error('half_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                      </div>
                    <div class="col-sm-6">
                        <label for="inputFirstname">Full Day Price</label>
                        <input type="number" class="form-control" id="full_day_price"  name="full_day_price"  value={{$data->full_day_price}} placeholder="Falf day price">
                        @error('full_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                      </div>
                      <div class="col-sm-6">
                        <label for="inputFirstname">Boat Type</label>
                   
                       {!! Form::select('boat_type', array('Futurama' => 'Futurama', 'Rascal' => 'Rascal'), $data->boat_type, ['class' => 'form-control', 'id' => 'boat_type', 'placeholder' => 'Select']) !!}
            
                        @error('boat_type') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                      </div>
                     
                    <div class="col-sm-6">
  
                    <label for="cars">Choose season</label>

                   <!-- <select name="season_name" id="season_name" value={{$data->season_name}}>
                   <option value="high season">High season</option>
                   <option value="low season">Low Season</option>
                   <option value="after season">After Season</option>
   
                   </select> -->
                   {!! Form::select('season_name', array('high season' => 'high season', 'low season' => 'low season', 'after season' => 'after season'), $data->season_name, ['class' => 'form-control', 'id' => 'boat_type', 'placeholder' => 'Select']) !!}

                   @error('season_name') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror 
                    </div>      
                    <div class="col-sm-12">
                    <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" name="submit" value="submit">Submit</button>
                 <button type="submit" class="btn btn-default pull-left" name="cancel" value="cancel">Cancel</button>
              </div>
</div>
   
              <!-- /.box-body -->
            
              <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</form>
  </div>
 
  <!-- /.content-wrapper -->
@stop