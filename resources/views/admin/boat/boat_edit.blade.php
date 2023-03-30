
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
.custom-flex {display: flex;align-items: center;justify-content: space-between;}
input[type="date"]{
max-height:34px;
}
  </style>




@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Boat Booking
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
              <h3 class="box-title">Edit Boat Booking Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
         
            {!! Form::open(['url' => ADMIN_URL.'/edit_boat_booking/'.$data[0]->id, 'class' => 'form-horizontal',  'files' => true, 'ng-cloak' => 'ng-cloak']) !!}

              <div class="box-body">
               
  <div class="custom-flex">
              <div class="col-sm-6">
                        <label for="checkin_date">Checkin Date</label>
                        <input type="date" class="form-control" id="checkIn_date"  name="checkIn_date" value={{$data[0]->checkIn_date}} placeholder="checkin Date">
                        @error('checkIn_date') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                    </div>
                  
                     <div class="col-sm-6">
                        <label for="no_of_person">no of person</label>
                        <input type="number" class="form-control" id="no_of_person"  name="no_of_person"  value={{$data[0]->no_of_person}} placeholder="no of person">
                        @error('no_of_person') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                      </div>
</div>
<div class="custom-flex">
                    <div class="col-sm-6">
                        <label for="half_day_price">Half Day Price</label>
                        <input type="number" class="form-control" id="half_day_price"  name="half_day_price" value={{$data[0]->half_day_price}} placeholder="Half day price">
                        @error('half_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                      </div>
                    <div class="col-sm-6">
                        <label for="full_day_price">Full Day Price</label>
                        <input type="number" class="form-control" id="full_day_price"  name="full_day_price"  value={{$data[0]->full_day_price}} placeholder="Full day price">
                        @error('full_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                      </div>
</div>
<div class="custom-flex">
                      <div class="col-sm-6">
                        <label for="total">Total</label>
                        <input type="number" class="form-control" id="total"  name="total"  value={{$data[0]->total}} placeholder="Total">
                        @error('total') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                      </div>
                      <div class="col-sm-6">
                        <label for="inputFirstname">Boat Type</label>
                   
                       {!! Form::select('boat_type', array('Futurama' => 'Futurama', 'Rascal' => 'Rascal'), $data[0]->boat_type, ['class' => 'form-control', 'id' => 'boat_type', 'placeholder' => 'Select']) !!}
            
                        @error('boat_type') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror  
                      </div>
</div>
                      <div class="col-sm-6">
                        <label for="status">Status</label>
                        <input type="text" readonly="true" class="form-control" id="status"  name="status"  value={{$data[0]->status}} placeholder="Status">
                     
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