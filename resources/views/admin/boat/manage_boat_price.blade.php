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
        Manage Boat Price
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
              <h3 class="box-title">Add Boat price Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
          
           <form method="POST" id="add_boat_data" class="form-horizontal" action="{{route('manage_boat_price.store')}}">
              @csrf
                
              <div class="box-body"> 
         
              <div class="col-sm-6">
                        <label for="from_date">From Date</label>
                        <input type="date" class="form-control" id="from_date"  name="from_date" placeholder="from Date" value="{{old('from_date')}}">
                        @error('from_date') 
                       <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong> 
                       </span>
                       @enderror    
              </div>
                    <div class="col-sm-6">
                        <label for="to_date">To Date</label>
                        <input type="date" class="form-control" id="to_date"  name="to_date" placeholder="to Date" value="{{old('to_date')}}">
                        @error('to_date') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                    </div>
                    <div class="col-sm-6">
                        <label for="half_day_price">Half Day Price</label>
                        <input type="number" class="form-control" id="half_day_price"  name="half_day_price" placeholder="Half day price" value="{{old('half_day_price')}}">
                        @error('half_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                    </div>
                    <div class="col-sm-6">
                        <label for="full_day_price">Full Day Price</label>
                        <input type="number" class="form-control" id="full_day_price"  name="full_day_price" placeholder="Full day price" value="{{old('full_day_price')}}">
                        @error('full_day_price') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                    </div>
                    <div class="col-sm-6">
                        <label for="boat_type">Boat Type</label>
                     
                       
                  
                    {!! Form::select('boat_type', array('Futurama' => 'Futurama', 'Rascal' => 'Rascal'), '', ['class' => 'form-control', 'id' => 'input_status', 'placeholder' => 'Select']) !!}                    
                  
                       @error('boat_type') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror    
                    </div>
                    <div class="col-sm-6">
  
                    <label for="season">Choose season</label>

                     <select name="season_name" id="season_name" value="{{old('season_name')}}" >
                     <option value="">choose season</option>
                    <option value="high season">High season</option>
                      <option value="low season">Low Season</option>
                      <option value="after season">After Season</option>
                     
                       </select>
                       <br>
                       @error('season_name') 
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong> 
                                        </span>
                                     @enderror                       
                                       </div>       
                 <div class="col-sm-12">
                 <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" name="submit" value="submit">Submit</button>
                 <button type="cancel" class="btn btn-default pull-left" name="cancel" value="cancel">Cancel</button>
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
  

