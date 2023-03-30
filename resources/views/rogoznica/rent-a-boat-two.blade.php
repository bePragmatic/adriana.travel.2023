<style>
.component {
    display: grid;
    grid-template-columns: 25% 1fr;
    background-color: #fff;
    border-radius: 24px;
    padding-top: 60px;
}

.new {
    overflow-x: hidden;
}

.calender--setting {
    padding-left: 4vw;
}

.component .accommodation__list {
    margin-top: 0;
    padding: 0;
}

p.already_book {
    background-color: #F44336;
    color: #ffff !important;
    padding: 10px;
    border-radius: 8px;
}

.already_book {
    margin-top: 15px;
}

.guest_select .guest-title {
    font-size: 14px;
    color: rgba(0, 0, 0, .8);
}

.guest_select {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.component .homepage__row__container {
    padding-top: 0;
}

.calender--setting p {
    font-size: 16px;
    margin-bottom: 15px;
    text-transform: capitalize;
    color: #000;
}

.calender--setting div span {
    width: 80px;
    display: inline-block;
    text-align: center;
}

.calender--setting h4 {
    font-size: 20px;
    font-weight: 500;
    text-transform: capitalize;
    margin-bottom: 10px;
}

.calender--setting .quantity {
    background: transparent;
    width: 25px;
    height: 25px;
    padding: 0;
    display: inline-block;
    border-radius: 100px;
    line-height: 20px;
    font-size: 23px;
    color: #009fda;
    border: 1px solid #009fda;
}

.full_day {
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-transform: capitalize;
}

.full_day label {
    font-size: 14px;
    color: #000;
}

.calender--setting .full_day span {
    width: auto;
    margin-left: 5px;
}

.calender--setting .price p {
    padding-bottom: 20px;
    border-bottom: 1px solid rgb(0 0 0 / 12%);
}

.price {
    padding:20px 0;
    margin: 20px 0 0 0;
    border-top: 1px solid rgb(0 0 0 / 12%);
}
.price input{
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border: 1px solid #ddd;
    border-radius: 100%;
    margin: 0;
    position: relative;
    cursor: pointer !important;
}
.price input:checked:after{
    content: "";
    background: #009fda;
    width: 80%;
    height: 80%;
    position: absolute;
    border-radius: 100%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.guest--row {
    padding: 20px 0;
    border-bottom: 1px solid rgb(0 0 0 / 12%);
    border-top: 1px solid rgb(0 0 0 / 12%);
    margin-bottom: 10px
}
.calender--setting .btn{
    text-transform:capitalize;
}
.cell {
     
    
    border-radius: 8px; 
    border: none!important;
    
    font-size: 12px;
    width:100% !important;
}
.cell.day{
    background: #f6f6f6!important;
}
.cell.day.selected{
    background: #009fda!important;
    color:#fff;
}
.vdp-datepicker__calendar{
    box-shadow: 0 15px 30px 10px rgb(0 0 0 / 8%);
    border: none !important;
    width: auto !important;
    padding: 10px;
    min-width:380px;
}
.vdp-datepicker__calendar > div{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    gap:6px;
    clear: both;
}
.services-box--item-img-grid{
    display: grid !important;
    grid-template-columns: auto 1fr;
    grid-gap: 20px;
    margin-top: 35px;
}
.services-box--item h2{
    padding-bottom: 10px;
}
@media (max-width:767px){
    .services-box--item h2{
font-size:28px;
}
    .services-box--item {
    padding: 15px 0 !important;
}
    .wrapper-service.padding-top--4.main-div {
    padding-top: 0;
}
    .calender--setting {
    padding-left: 0vw;
}
    .pts-wrapper .owl-carousel .owl-item {
    margin-bottom: 20px !important;
}
.stars {
    margin-top: 10px;
}
    .first-div {
    padding: 1rem !important;
}
    .services-box--item-img-grid {
    grid-template-columns: auto;
}
    .component{
        grid-template-columns: auto;
        padding-left: 20px;
    padding-right: 20px;
    }
    .new .wrapper.wrapper--sml-rounded.wrapper-service {
        padding-left: 0;
        padding-right: 0;
        padding-top: 20px;
    }
    .new .services__wrapper {
        padding: 0 0px 0 0;
    }
    .component .vdp-datepicker__calendar{
        min-width: auto;
    }
    .wrapper.wrapper--sml-rounded.wrapper-service.padding-top--4 {
    padding-top: 20px;
    padding-left: 0;
    padding-right: 0;
}
}
.calender--setting > div:nth-child(2) {
    border-bottom: 1px solid;
    border-bottom: 1px solid rgba(16,48,76,.2);
    margin-bottom: 20px;
    padding-bottom: 20px;
}
</style>
@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in serviceandactivities.css -->
    <div class="rentaboat__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper accommodation__header padding__top__3 media-to-header">
            <div style="display: flex; justify-content: center">
                <h1 class="accommodation__header__title padding__bottom__xs service__title" style="max-width: 680px">
                    {{-- @lang('messages.transfers.transfers') --}}

                    @lang('messages.services-activities.rent_a_boat_main')
                </h1>
            </div>

        </div>
    </div>
    <div class="component">
    <boat-calculator token="{{ csrf_token() }}" boat_type="Rascal" screen="desktop" class="calender--setting"></boat-calculator>
 <div class="new">
    <div class="wrapper wrapper--sml-rounded wrapper-service">
        <div class="accommodation__list padding__bottom__0 padding__top__0">
            <section class="services__wrapper">
                <div class="accommodation__list">
                    <div class="homepage__row__container media__to__column padding__top__bottom2e"
                        style="flex-direction: column">
                        <!-- title -->
                        <div div class="services-box--item" style="max-width: 451px; padding-bottom: 1em">

                            <h2>Rascala Bluline 19 Open</h2>

                        </div>
                        <div>
                            <p class="t-eta dark__blue">
                                @lang('messages.services-activities.rent_a_boat_sub')

                            </p>
                        </div>
                        <!--van img -->


                    </div>

                    <div class="services-box--item" style="gap: 20px; display: flex; padding-top: 3em; padding-bottom: 2em">
                        <div style="flex: 1">
                            <img src=" ./assets/IMG-20220612-WA0001.jpg" class="border-radius--16"
                                style="width: 100%; max-width: 450px;">
                        </div>
                        <div class="transfer-svg-init media-to-hide--sml" style="flex-direction: column;">

                            {{-- <img src="./assets/illustration-transfer.svg"> --}}
                            {{-- <div class="transfer-boat-img"></div> --}}

                            <p class="mb-3 text-center">
                                @lang('messages.services-activities.welcome_to_our_modern_sporty')    
                            </p><br>
                            <p>
                                @lang('messages.services-activities.this_is_a_new_boat')   
                                @lang('messages.services-activities.this_boat_has_excellent_maritime_characteristics') <br>  
                                @lang('messages.services-activities.you_have_free_parking_in_our_bay')   
                                @lang('messages.services-activities.if_you_dont_have_any_nautical_knowledge')<br>
                                @lang('messages.services-activities.if_you_have_any_other_questions')   

                            </p>
                        </div>

                    </div>


                    {{-- 
                    <div>
                        <!-- illustration -->
    <div class="services-box--item" style="margin-top: 4em; margin-bottom: 2em">
                            <div class="van-img-container">
                                <img src="./assets/van01.jpg" style="width: 100%; border-radius: 16px;">
                            </div>
                            <div class="transfer-image-container media-to-hide--sml">
                                <img class="media-to-hide--sml" src=" ./assets/illustration-transfer.svg">
                            </div>
                        </div>
                    </div> --}}
                    <div class="homepage__row__container transfer-to-column transfer-media">

                        <!-- airport-split-->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottomb__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.rent_a_boat') --}}
                                    239,00 € @lang('messages.services-activities.per_day')
                                </p>
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.rent_a_boat') --}}
                                    179 ,00 € @lang('messages.services-activities.half_day')
                                </p>

                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">
                                        @lang('messages.services-activities.july_august')
                                    </p>

                                </div>
                            </div>
                        </div>

                        <!-- airport-zadar -->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    229,00 € @lang('messages.services-activities.per_day')
                                </p>
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    169,00 € @lang('messages.services-activities.half_day')
                                </p>
                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">@lang('messages.services-activities.june_september')</p>

                                </div>
                            </div>
                        </div>
                        <!-- airport-zadar -->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.minivan_tours') --}}
                                    189,00 € @lang('messages.services-activities.per_day')
                                </p>
                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">@lang('messages.services-activities.may_october')</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>




    </div>



    
            </div>
            </div>








            <div class="wrapper wrapper--sml-rounded wrapper-service padding-top--4">
        <div class="wrapper homepage__body__row">


            {{-- <h3 class="homepage__lightblue__title" style="padding-bottom: 1em">Our transportation
                </h3> --}}

            <div>
                <sac-carousel>
                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0001.jpg')}}" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0002.jpg')}}" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0003.jpg')}}" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0004.jpg')}}" />
                    </div>

                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0005.jpg')}}" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="{{asset('/assets/IMG-20220612-WA0006.jpg')}}" />
                    </div>

                </sac-carousel>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper--sml-rounded wrapper-service padding-top--4 main-div">
        <section class="productView__block  first-div">
            <section id="global-review" class="globalReviewComp">

                <h2 class="globalReviewComp__title">Overall rating</h2>

                <div class="globalReviewComp__criteriaContainer">

                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.compliance_of_the_boat')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('compliance_of_the_boat'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('compliance_of_the_boat'), 1))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.comfort_on_board')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('comfort_on_board'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('comfort_on_board'), 1))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.standard_of_maintenance')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('standard_of_maintenance'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('standard_of_maintenance'), 1))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.cleanliness')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('cleanliness'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('cleanliness'), 1))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.welcome_and_communication')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('welcome_and_communication'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('welcome_and_communication'), 1))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="globalReviewComp__criteriaAvg">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.value_for_money')}}</div>
                        <div class="globalReviewComp__criteriaStars">
                            <div class="newRatingStarsContainer--medium">
                                {!! str_repeat('<i class="fa fa-star checked"></i>', ceil(round($ratings->avg('value_for_money'), 1))) !!}
                                {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - ceil(round($ratings->avg('value_for_money'), 1))) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="commentaires" class="reviewsComp js-reviewsEventBinder ">
                <div class="reviewsComp__titleContainer">
                    <h2 class="reviewsComp__title">{{count($ratings)}} comments </h2>
                </div>
                @if (count($ratings) > 0)
                @foreach ($ratings as $rating)
                @php
                    $total=ceil(($rating->cleanliness+$rating->comfort_on_board+$rating->compliance_of_the_boat+$rating->standard_of_maintenance+$rating->value_for_money+$rating->welcome_and_communication)/6);
                @endphp
                <div class="reviewsComp__reviewsContainer">
                    <div class="reviewComp">
                        <div class="reviewComp__infosContainer">
                            <div class="reviewComp__userInfos">
                                <div class="reviewComp__imgContainer">
                                    <img class="reviewComp__img"
                                        src="{{asset('images/user_pic-50x50.png')}}" alt="{{$rating->name}}">
                                </div>

                                <div class="reviewComp__infos">
                                    <div class="reviewComp__author">{{$rating->name}}</div>

                                    <div class="reviewComp__info">
                                        {{$rating->created_at->format('M Y')}} </div>
                                </div>
                            </div>

                            <div class="reviewComp__rating">
                                <div class="newRatingStarsContainer--medium">
                                    {!! str_repeat('<i class="fa fa-star checked"></i>', $total) !!}
                                    {!! str_repeat('<i class="fa fa-star-o" aria-hidden="true"></i>', 5 - $total) !!}
                                </div>
                            </div>
                        </div>

                        <div class="reviewComp__reviewContainer">{{$rating->feedback}}</div>
                    </div>
                </div> 
                @endforeach
                
                @else
                <p>{{ trans('messages.feedback.no_feedback_yet') }}</p>
                @endif
                
                {!! $ratings->links() !!}
            </section>
        </section>
        <section class="productView__block second-div">
            <form method="POST" action="{{route('ratings')}}">
                @csrf
                <input type="hidden" name="boat" value="two">
                <div>
                    @if(session()->has('message'))
                    <div class="alert alert-success success-msg__container">
                        {{ session()->get('message') }}
                        <div class="x--exit" onclick="this.parentElement.style.display='none';">&times;</div>
                    </div>

                    <script>
                        window.dataLayer.push({'event': 'upit-poslan'})
                    </script>
                    @endif
                </div>
            <div class="field">
                    <label for="input" class="field__lbl">{{ trans('messages.contactus.name') }}</label>
                    {!! Form::text('name', '', ['class' => $errors->has('name') ? 'input input--text
                    input--text--error'
                    : 'input
                    input--text focus',
                    'placeholder' => trans('messages.contactus.name')]) !!}
                    @error('name')
                    <span class="payment-error-msg">{{ $message }}</span>
                    @enderror

            </div> 
            <div class="field">
                <label for="input" class="field__lbl">{{  trans('messages.contactus.email_address') }}
                </label>
                {!! Form::email('email', '', ['class' => $errors->has('email') ? 'input input--text
                input--text--error' : 'input
                input--text focus', 'placeholder' => trans('messages.contactus.email_address')]) !!}
                @error('email')
                <span class="payment-error-msg">{{ $message }}</span>
                @enderror
            </div> 
            <div class="field">
                <label for="input" class="field__lbl">@lang('messages.contactus.inquiry')</label>
                            {!! Form::textarea('feedback', '', ['class' => $errors->has('feedback') ? 'input input--text
                            input--text--error' :
                            'input input--text focus ', 'placeholder' =>
                            trans('messages.contactus.feedback')]) !!}
                            @error('feedback')
                            <span class="payment-error-msg">{{ $message }}</span>
                            @enderror
            </div> 
            <div class="field">
                <div class="stars">
                <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.compliance_of_the_boat')}}</div>
                <div id="wrapper">
                <input type="radio" name="compliance_of_the_boat" value="5" id="compliance_of_the_boat1">
                <label for="compliance_of_the_boat1"></label>
                <input type="radio" name="compliance_of_the_boat" value="4" id="compliance_of_the_boat2">
                <label for="compliance_of_the_boat2"></label>
                <input type="radio" name="compliance_of_the_boat" value="3" id="compliance_of_the_boat3">
                <label for="compliance_of_the_boat3"></label>
                <input type="radio" name="compliance_of_the_boat" value="2" id="compliance_of_the_boat4">
                <label for="compliance_of_the_boat4"></label>
                <input type="radio" name="compliance_of_the_boat" value="1" id="compliance_of_the_boat5" checked>
                <label for="compliance_of_the_boat5"></label>
                </div>
                </div>

                <div class="stars">
                    <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.comfort_on_board')}}</div>
                    <div id="wrapper">
                    <input type="radio" name="comfort_on_board" value="5" id="comfort_on_board1">
                    <label for="comfort_on_board1"></label>
                    <input type="radio" name="comfort_on_board" value="4" id="comfort_on_board2">
                    <label for="comfort_on_board2"></label>
                    <input type="radio" name="comfort_on_board" value="3" id="comfort_on_board3">
                    <label for="comfort_on_board3"></label>
                    <input type="radio" name="comfort_on_board" value="2" id="comfort_on_board4">
                    <label for="comfort_on_board4"></label>
                    <input type="radio" name="comfort_on_board" value="1" id="comfort_on_board5" checked>
                    <label for="comfort_on_board5"></label>
                    </div>
                    </div>

                    <div class="stars">
                        <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.standard_of_maintenance')}}</div>
                        <div id="wrapper">
                        <input type="radio" name="standard_of_maintenance" value="5" id="standard_of_maintenance1">
                        <label for="standard_of_maintenance1"></label>
                        <input type="radio" name="standard_of_maintenance" value="4" id="standard_of_maintenance2">
                        <label for="standard_of_maintenance2"></label>
                        <input type="radio" name="standard_of_maintenance" value="3" id="standard_of_maintenance3">
                        <label for="standard_of_maintenance3"></label>
                        <input type="radio" name="standard_of_maintenance" value="2" id="standard_of_maintenance4">
                        <label for="standard_of_maintenance4"></label>
                        <input type="radio" name="standard_of_maintenance" value="1" id="standard_of_maintenance5" checked>
                        <label for="standard_of_maintenance5"></label>
                        </div>
                        </div>

                        <div class="stars">
                            <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.cleanliness')}}</div>
                            <div id="wrapper">
                            <input type="radio" name="cleanliness" value="5" id="cleanliness1">
                            <label for="cleanliness1"></label>
                            <input type="radio" name="cleanliness" value="4" id="cleanliness2">
                            <label for="cleanliness2"></label>
                            <input type="radio" name="cleanliness" value="3" id="cleanliness3">
                            <label for="cleanliness3"></label>
                            <input type="radio" name="cleanliness" value="2" id="cleanliness4">
                            <label for="cleanliness4"></label>
                            <input type="radio" name="cleanliness" value="1" id="cleanliness5" checked>
                            <label for="cleanliness5"></label>
                            </div>
                            </div>

                            <div class="stars">
                                <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.welcome_and_communication')}}</div>
                                <div id="wrapper">
                                <input type="radio" name="welcome_and_communication" value="5" id="welcome_and_communication1">
                                <label for="welcome_and_communication1"></label>
                                <input type="radio" name="welcome_and_communication" value="4" id="welcome_and_communication2">
                                <label for="welcome_and_communication2"></label>
                                <input type="radio" name="welcome_and_communication" value="3" id="welcome_and_communication3">
                                <label for="welcome_and_communication3"></label>
                                <input type="radio" name="welcome_and_communication" value="2" id="welcome_and_communication4">
                                <label for="welcome_and_communication4"></label>
                                <input type="radio" name="welcome_and_communication" value="1" id="welcome_and_communication5" checked>
                                <label for="welcome_and_communication5"></label>
                                </div>
                                </div>

                                <div class="stars">
                                    <div class="globalReviewComp__criteriaLabel">{{trans('messages.feedback.value_for_money')}}</div>
                                    <div id="wrapper">
                                    <input type="radio" name="value_for_money" value="5" id="value_for_money1">
                                    <label for="value_for_money1"></label>
                                    <input type="radio" name="value_for_money" value="4" id="value_for_money2">
                                    <label for="value_for_money2"></label>
                                    <input type="radio" name="value_for_money" value="3" id="value_for_money3">
                                    <label for="value_for_money3"></label>
                                    <input type="radio" name="value_for_money" value="2" id="value_for_money4">
                                    <label for="value_for_money4"></label>
                                    <input type="radio" name="value_for_money" value="1" id="value_for_money5" checked>
                                    <label for="value_for_money5"></label>
                                    </div>
                                    </div>
                
            </div>
            <div class="homepage__row__container flex__end__img padding__top__custom">
                {!! Form::submit( trans('messages.contactus.send') , ['class' => 'btn btn--primary
                            btn--med']) !!}
            </div>
        </form>
        </section>       
    </div>

    <div class="wrapper transfer--padding-top-3 transfer--padding-bottom-4">
        <newsletter color="white"></newsletter>

    </div>




                



@stop