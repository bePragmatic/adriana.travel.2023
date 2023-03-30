<!-- -------------- -->
@extends('rogoznica.layout.master')
@section('content')
<div class="quality-bg-white">
  <div class="explore__hero">
    @include('rogoznica.includes.header')
  </div>

  <div class="wrapper">
    <section class="quality-standards--top">
      <div class="py-4 py-md-5 text-wrap h1-styler">
        {!! $content !!}
      </div>
    </section>


  </div>

</div>

@push('scripts')
<script type="text/javascript">
  $( document ).ready(function() {
 
 var base_url = '{!! url("/") !!}';
 var user_token = '{!! Session::get('get_token') !!}';

 if(user_token!='')
 {

  $('a[href*="'+base_url+'"]').attr('href' , 'javascript:void(0)');
 
 }

});

</script>
@endpush
@stop