@extends('rogoznica.layout.master')
@section('content')

  <div>
    @include('rogoznica.includes.header')
  </div>
  
<div class="white-bg__blog padding__bottom__custom padding__top__7 margin__bottom__minus60">
  <div class="wrapper__blogpost__uska">
    <div class="permission--height permission--layout">
      <div class="registerww__column padding__bottom__3">
   
 
       
          <h2 class="text__align  font__large__36 font-style__oops">
            {{ trans('messages.errors.connection') }}!
           
          </h2>
          <br/>
          <div class="mt-3 padding__top__1 padding__bottom__1 ">
            <p>{{ trans('messages.errors.date') }}</p>
          </div>
       
    

    
    </div>
  </div>
</div>
</div>
</main>
@stop





