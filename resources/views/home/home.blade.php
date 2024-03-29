@extends('template')

@section('main')
<main id="site-content" role="main" ng-controller="home_owl" ng-cloak>
	<div class="home-banner-wrap">
		<p class="site-desc d-block d-lg-none">
			@lang('messages.home.desc')
		</p>
		<ul class="home-banner-slider owl-carousel">
			@foreach($sliders as $slider)
			<li class="home-banner-img">
				<img class="owl-lazy" data-src="{{ $slider->image_url }}" />
				<div class="home-banner-info">
					<h2 class="slider-caption">
						{{ $slider->name }}
					</h2>
					<p class="slider-caption-desc">
						{{ $slider->description }}
					</p>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="home-info-wrap">
			<div class="container">
				<div class="home-info">
					<p class="site-desc d-none d-lg-block">
						@lang('messages.home.desc')
					</p>
					<div class="banner-search">
						<div class="search-bar m-auto" data-reactid=".1">
							<form action="{{ url('s') }}" method="get">
								<div class="form-wrap">
									<div class="search_location">
										<label>
											@lang('messages.header.where')
										</label>
										<div class="location-input-wrap">
											<input class="location" placeholder="@lang('messages.header.anywhere')" type="text" name="location" id="header-search-form" aria-autocomplete="both" value="">
										</div>
										<span class="search_location_error set_location d-none"> @lang('messages.home.please_set_location') </span>
										<span class="search_location_error invalid_location d-none"> @lang('messages.home.search_validation') </span>
									</div>
									<div class="select-date d-flex flex-column">
										<label>
											@lang('messages.header.when')
										</label>
										<div class="webcot-lg-datepicker d-flex align-items-center flex-grow-1">
											<div class="DateInput">
												<input aria-label="Check In" class="d-none" id="checkin" name="checkin" value="" placeholder="@lang('messages.header.checkin')" autocomplete="off" type="text">
												<div class="check-date">
													@lang('messages.header.checkin')
												</div>
											</div>
											<span class="d-inline-block mx-3">-</span>
											<div class="DateInput">
												<input aria-label="Check Out" class="d-none" id="checkout" name="checkout" value="" placeholder="@lang('messages.header.checkout')" autocomplete="off" type="text">
												<div class="check-date">
													@lang('messages.header.checkout')
												</div>
											</div>
											<button type="button" class="check-date-btn">
												@lang('messages.header.anytime')
											</button>
										</div>
									</div>
									<div class="search-guests">
										<label>
											@lang('messages.header.guest')
										</label>
										<div class="select">
											<select id="guests" name="guests">
												@for($i=1;$i<=16;$i++)
												<option value="{{ $i }}"> {{ $i.' '.trans_choice('messages.home.guest',$i) }} </option>
												@endfor
											</select>
										</div>
									</div>
									<div class="search-submit text-right">
										<button id="submit_location" type="submit" class="btn btn-primary">
											@lang('messages.home.search')
										</button>
									</div>
								</div>
							</form>
						</div>

						<div class="search-modal-trigger d-none" data-toggle="modal" data-target="#search-modal-sm">
							<span class="search-btn-field d-flex align-items-center flex-grow-1">
								{{ trans('messages.header.anywhere') }} · {{ trans('messages.header.anytime') }} · 1 {{ trans('messages.header.guest') }}
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="whole-slider-wrap" ng-cloak 
		ng-init="home_city_explore = {{$home_city}};
            featured_host_experience_categories = {{$featured_host_experience_categories}};
            just_booked = {{$just_booked}};
            most_viewed = {{$most_viewed}};
            host_experiences = {{$host_experiences}};
            our_community = {{$our_community_banners}};">
		<div class="container">
			<div class="my-4 my-md-5">
				<ul class="home-menu d-flex flex-wrap">
					<li>
						<a class="d-md-flex align-items-center homes" href="{{ url('/s?current_refinement=Homes') }}">
							<div class="home-menu-img">
								<img lazy-src="{{$home_page_stay_image}}">
							</div>
							<div class="home-menu-name">
								{{ trans('messages.home.stays') }} 
							</div>
						</a>
					</li>
					{{--HostExperienceBladeCommentStart
					<li>
						<a class="d-md-flex align-items-center experiences" href="{{ url('/s?current_refinement=Experiences') }}">
							<div class="home-menu-img">
								<img lazy-src="{{$home_page_experience_image}}">
							</div>
							<div class="home-menu-name">
								{{ trans('experiences.home.experiences') }} 
							</div>
						</a>
					</li>
					HostExperienceBladeCommentEnd--}}
				</ul>
			</div>

			<div class="my-4 my-md-5">
				<div class="mb-4">
					<h2 class="title-sm m-0">
						{{ trans('messages.home.recommend_for_you') }}
					</h2>
				</div>

				<ul id="explore-slider" class="explore-slider owl-carousel">
					<li ng-repeat="explore in home_city_explore">
						<div class="explore-img">
							<a href="@{{explore.search_url}}">
								<img class="owl-lazy" data-src="@{{explore.image_url}}" />
								<div class="explore-info d-flex flex-column justify-content-end">
									<h4>
										@{{ explore.display_name }}
									</h4>
									<span ng-bind-html="explore.average_price"></span>
								</div>
							</a>
						</div>
					</li>
				</ul>
			</div>

			<div class="my-4 d-flex justify-content-between align-items-center" ng-if="just_booked.length > 0">
				<h2 class="title-sm m-0">
					{{ trans('messages.header.justbooked') }}
				</h2>
			</div>
			<ul id="booked" class="rooms-wrap d-flex flex-wrap">
				<li ng-repeat="(key, fetch_data) in just_booked">
					<div class="pro-img">
						<a href="@{{fetch_data.rooms.link}}">
							<img lazy-src="@{{fetch_data.rooms.original_image}}" />
						</a>
					</div>
					<div class="pro-info">
						<h4 class="text-truncate">
							<span> @{{ fetch_data.rooms.room_type_name }} </span>
							<span>·</span>
							<span> @{{ fetch_data.rooms.beds }} @{{ fetch_data.rooms.bed_lang }} </span>
						</h4>
						<a href="@{{fetch_data.rooms.link}}" title="@{{ fetch_data.rooms.name}}">
							<h5 class="text-truncate">
								@{{ fetch_data.rooms.name}}
							</h5>
						</a>
						<p class="price">
							<span ng-bind-html="fetch_data.currency.symbol"></span> @{{ fetch_data.rooms.rooms_price.night }}
							{{ trans("messages.rooms.per_night") }}
							<span ng-if="fetch_data.rooms.booking_type == 'instant_book'"> 
								<i class="icon icon-instant-book"></i>
							</span>
						</p>

						<div class="d-flex align-items-center">
							<span ng-bind-html="fetch_data.rooms.overall_star_rating"> </span>
							<span class="review-count mx-2" ng-if="fetch_data.rooms.reviews_count > 0">
								@{{ fetch_data.rooms.reviews_count }}
							</span>
							<span class="review-label" ng-if="fetch_data.rooms.overall_star_rating">
								@{{ fetch_data.rooms.reviews_count_lang }}
							</span>
						</div>
					</div>
				</li>
			</ul>
			<div class="mt-3 mt-md-0 mb-5" ng-if="just_booked.length > 8">
				<a class="see-all-link d-md-inline-flex align-items-center" href="{{ url('s') }}">
					<span>
						{{ trans('messages.header.seeall') }}
					</span>
					<i class="icon icon-chevron-right ml-2"></i>
				</a>
			</div>
			{{--
				<div class="my-4 d-flex justify-content-between align-items-center" ng-if="recommended.length > 0">
					<h2 class="title-sm m-0">
						{{ trans('messages.header.recommend') }}
					</h2>
				</div>
				<ul id="recommended" class="rooms-wrap d-flex flex-wrap">
					<li ng-repeat="room in recommended">
						<div class="pro-img">
							<a href="@{{room.link}}">
								<img lazy-src="@{{room.original_image}}" />
							</a>
						</div>
						<div class="pro-info">
							<h4 class="text-truncate">
								<span>@{{ room.room_type_name }}</span>
								<span>·</span>
								<span>@{{ room.beds }} @{{ room.bed_lang }} </span>
							</h4>
							<a href="@{{ room.link }}" title="@{{ room.name }}">
								<h5 class="text-truncate"> @{{ room.name }} </h5>
							</a>
							<p class="price">							
								<span ng-bind-html="room.rooms_price.currency.symbol"></span> @{{ room.rooms_price.night }}
								{{ trans("messages.rooms.per_night") }}
								<span ng-if="room.booking_type == 'instant_book'"> 
									<i class="icon icon-instant-book"></i>
								</span>
							</p>
							<div class="d-flex align-items-center">                                              
								<span ng-bind-html="room.overall_star_rating"> </span>
								<span class="review-count mx-2" ng-if="room.reviews_count > 0">
									@{{ room.reviews_count }}
								</span>
								<span class="review-label" ng-if="room.overall_star_rating">
									@{{ room.reviews_count_lang }}
								</span>
							</div>
						</div>
					</li>
				</ul>
				<div class="mt-3 mt-md-0 mb-5" ng-if="recommended.length > 8">
					<a class="see-all-link d-md-inline-flex align-items-center" href="{{ url('s') }}">
						<span> {{ trans('messages.header.seeall') }} </span>
						<i class="icon icon-chevron-right ml-2"></i>
					</a>
				</div>
				--}}

				<div class="my-4 d-flex justify-content-between align-items-center" ng-if="most_viewed.length > 0">
					<h2 class="title-sm m-0">
						{{ trans('messages.header.most_viewed') }}
					</h2>
				</div>
				<ul id="most-viewed" class="rooms-wrap d-flex flex-wrap">
					<li ng-repeat="room in most_viewed">
						<div class="pro-img">
							<a href="@{{room.link}}">
								<img lazy-src="@{{room.original_image}}" />
							</a>
						</div>
						<div class="pro-info">
							<h4 class="text-truncate">
								<span>@{{ room.room_type_name }}</span>
								<span>·</span>
								<span>@{{ room.beds }} @{{ room.bed_lang }} </span>
							</h4>
							<a href="@{{room.link}}" title="@{{ room.name }}">
								<h5 class="text-truncate"> @{{ room.name}} </h5>
							</a>
							<p class="price">
								<span ng-bind-html="room.rooms_price.currency.symbol"></span> @{{ room.rooms_price.night }}
								{{ trans("messages.rooms.per_night") }}
								<span ng-if="room.booking_type == 'instant_book'"> 
									<i class="icon icon-instant-book"></i>
								</span>
							</p>
							<div class="d-flex align-items-center">
								<span ng-bind-html="room.overall_star_rating"> </span>
								<span class="review-count mx-2" ng-if="room.reviews_count > 0">
									@{{ room.reviews_count }}
								</span>
								<span class="review-label" ng-if="room.overall_star_rating">
									@{{ room.reviews_count_lang }}
								</span>
							</div>
						</div>
					</li>
				</ul>
				<div class="mt-3 mt-md-0 mb-5" ng-if="most_viewed.length > 8">
					<a class="see-all-link d-md-inline-flex align-items-center" href="{{ url('s') }}">
						<span>
							{{ trans('messages.header.seeall') }}
						</span>
						<i class="icon icon-chevron-right ml-2"></i>
					</a>
				</div>
				<div class="explore-wrap" style="height: 100px">
					
				</div>
				{{--HostExperienceBladeCommentStart
				@include('host_experiences.home_slider', ['title_text'=> trans('experiences.home.experiences')])
				HostExperienceBladeCommentEnd--}}
				<!-- Featured Category Slider -->
				{{--
					@include('host_experiences.home_category_slider')
					--}}
				</div>
			</div>

			<div class="our-community" ng-if="our_community.length > 0">
				<div class="container">
					<div class="my-4">
						<h2 class="title text-center"> {{trans('messages.home.our_community')}} </h2>
					</div>
					<ul id="community-slider" class="community-content owl-carousel d-md-flex justify-content-center pb-5">
						<li ng-repeat="our_community in our_community">
							<a href="@{{our_community.link}}" target="_blank">
								<img class="owl-lazy" data-src="@{{our_community.image_url}}">
								<div class="our-community-info d-flex flex-column justify-content-end">
									<h2> @{{ our_community.title }} </h2>
									<p ng-bind-html="our_community.description"></p>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="support-info mx-md-auto mt-md-4">
				<div class="d-md-flex support-row">
					<div class="col-md-4 d-md-flex">
						<div class="iconContainer d-inline-block my-3 my-md-0 mr-md-4">
							<svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display:block; fill:currentColor; height:33px; width:33px;" data-reactid="431">
								<path fill-rule="evenodd" d="M22.786 18.264l-3.44-3.44a1.65 1.65 0 0 0-2.34.004l-.519.518-1.225 1.225a.657.657 0 0 1-.937-.007L7.526 9.766a.658.658 0 0 1-.007-.937l1.743-1.743c.647-.647.65-1.695.004-2.34l-3.44-3.44a1.648 1.648 0 0 0-2.337 0L.893 3.9c-.59.59-.83 1.646-.54 2.425.009.032.042.133.092.276.083.236.183.506.3.806a33.12 33.12 0 0 0 1.235 2.762c1.399 2.788 3.15 5.372 5.28 7.504 2.346 2.344 4.818 4.008 7.265 5.106.86.386 1.656.673 2.37.877.436.124.75.193.926.22.752.185 1.793-.105 2.37-.681l1.366-1.367.707-.707.522-.521a1.652 1.652 0 0 0 0-2.337zM4.196 2.013a.648.648 0 0 1 .922 0l3.44 3.44a.654.654 0 0 1-.003.926l-.518.518-.069-.07-4.225-4.224-.069-.069.522-.521zm15.287 20.476c-.33.33-1.012.52-1.464.41a8.24 8.24 0 0 1-.849-.204 16.65 16.65 0 0 1-2.236-.827c-2.339-1.05-4.71-2.645-6.966-4.901-2.048-2.048-3.74-4.546-5.094-7.246a32.023 32.023 0 0 1-1.197-2.677 23.004 23.004 0 0 1-.379-1.042c-.16-.433-.014-1.078.302-1.394l1.367-1.367.069.07L7.26 7.534l.069.069-.518.518a1.658 1.658 0 0 0 .007 2.35l6.799 6.799a1.657 1.657 0 0 0 2.35.007l.519-.518 4.363 4.362-1.367 1.367zm2.596-2.596l-.522.522-4.363-4.362.518-.518a.65.65 0 0 1 .926-.004l3.44 3.44a.652.652 0 0 1 0 .922z" data-reactid="432"></path>
							</svg>
						</div>
						<div class="textContainer">
							<h5> @lang('messages.home.24_7_support') </h5>
							<p> @lang('messages.home.24_7_support_desc',['support_number' => $support_number]) </p>
						</div>
					</div>
					<div class="col-md-4 d-md-flex">
						<div class="iconContainer d-inline-block my-3 my-md-0 mr-md-4">
							<svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display:block;fill:currentColor;height:33px;width:33px;" data-reactid="441">
								<path d="M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 15a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm10.334-4.27c.02-.074.04-.147.07-.222.013-.032.027-.068.039-.094.058-.123.124-.236.206-.327.073-.062.469-.39.536-.45.555-.486.815-.935.815-1.628 0-.682-.253-1.13-.79-1.612-.067-.061-.478-.409-.596-.518a1.014 1.014 0 0 1-.103-.147c-.006-.012-.006-.024-.012-.035a1.955 1.955 0 0 1-.116-.257c-.01-.026-.015-.05-.023-.077a1.885 1.885 0 0 1-.105-.513 1.373 1.373 0 0 1 .01-.367c.01-.019.036-.094.068-.181-.039.105.14-.38.179-.496.067-.199.111-.368.136-.538a1.876 1.876 0 0 0-.251-1.26c-.385-.668-.827-.883-1.75-1.052-.395-.072-.377-.069-.515-.1-.056-.018-.12-.057-.183-.093l-.008-.007a1.671 1.671 0 0 1-.185-.128l-.025-.02a2.524 2.524 0 0 1-.193-.175 2.453 2.453 0 0 1-.203-.241c-.03-.042-.062-.086-.08-.118a1.304 1.304 0 0 1-.123-.253l-.075-.434c-.16-.939-.374-1.385-1.05-1.775a1.883 1.883 0 0 0-1.227-.257 3.008 3.008 0 0 0-.549.13c-.1.033-.468.163-.514.18a5.07 5.07 0 0 1-.247.082c-.086.016-.185.007-.282.002-.07-.003-.15-.01-.24-.026a2.208 2.208 0 0 1-.218-.057 1.957 1.957 0 0 1-.222-.07c-.032-.013-.068-.027-.094-.039a1.366 1.366 0 0 1-.327-.206c-.062-.073-.39-.469-.45-.536C13.153.26 12.703 0 12.01 0c-.682 0-1.13.253-1.612.79-.06.067-.409.478-.518.596a1.011 1.011 0 0 1-.147.103c-.012.006-.024.006-.035.012-.043.025-.136.07-.258.116-.025.01-.05.015-.075.023a2.2 2.2 0 0 1-.353.089 2.132 2.132 0 0 1-.161.016 1.371 1.371 0 0 1-.367-.01c-.019-.01-.094-.036-.181-.068.105.039-.38-.14-.496-.179a3.066 3.066 0 0 0-.538-.136 1.876 1.876 0 0 0-1.26.251c-.668.385-.883.827-1.052 1.75-.072.395-.069.377-.1.515-.018.056-.057.12-.093.183l-.007.008a1.677 1.677 0 0 1-.128.185l-.02.025c-.049.06-.11.127-.175.193a2.45 2.45 0 0 1-.24.202c-.043.031-.087.063-.12.082a1.3 1.3 0 0 1-.252.122l-.434.075c-.939.16-1.385.374-1.775 1.05a1.883 1.883 0 0 0-.257 1.227c.022.173.065.346.13.549.033.1.163.468.18.514.032.09.059.17.083.247.015.086.006.185 0 .282-.002.07-.01.15-.025.24a2.204 2.204 0 0 1-.057.218c-.02.074-.04.147-.07.222-.013.032-.027.068-.039.094a1.368 1.368 0 0 1-.206.327c-.073.062-.469.39-.536.45C.26 10.847 0 11.297 0 11.99c0 .682.253 1.13.79 1.612.067.06.478.409.596.518.032.036.067.087.103.147.006.011.006.024.012.035.025.043.07.136.116.257.01.026.015.05.023.077a1.901 1.901 0 0 1 .105.513c.009.126.013.252-.01.367-.01.019-.036.094-.068.181.039-.105-.14.38-.179.496a3.052 3.052 0 0 0-.136.538c-.064.436.01.843.251 1.26.385.667.827.883 1.75 1.052.395.072.377.069.515.1.056.018.12.056.183.093l.008.007c.048.027.113.072.185.128l.025.02c.06.048.126.11.193.175a2.486 2.486 0 0 1 .203.24c.03.043.062.087.08.119.05.083.095.167.123.253l.075.434c.16.939.374 1.385 1.05 1.775.405.234.803.311 1.227.257.173-.022.346-.065.549-.13.1-.033.468-.163.514-.18.09-.032.17-.059.247-.083.086-.015.185-.006.282 0 .07.002.15.01.24.025.072.014.145.034.218.057.074.02.147.04.222.07.032.013.068.027.094.039.123.058.236.124.327.206.062.073.39.469.45.536.485.555.935.815 1.628.815.682 0 1.13-.253 1.612-.79.06-.067.409-.478.518-.596.036-.032.087-.067.147-.103.011-.006.024-.006.035-.012a1.96 1.96 0 0 1 .257-.116c.026-.01.05-.015.076-.023a1.891 1.891 0 0 1 .514-.105c.126-.009.252-.013.367.01.019.01.094.036.181.068-.105-.039.38.14.496.179.199.067.368.111.538.136.436.064.843-.01 1.26-.251.668-.385.883-.827 1.052-1.75.072-.395.069-.377.1-.515.018-.056.057-.12.093-.183l.007-.008a1.674 1.674 0 0 1 .148-.21c.048-.06.11-.126.175-.193a2.51 2.51 0 0 1 .241-.203c.042-.03.086-.062.118-.08.083-.05.167-.095.253-.123l.434-.075c.939-.16 1.385-.374 1.775-1.05.234-.405.311-.803.257-1.227a3.006 3.006 0 0 0-.13-.549c-.033-.1-.163-.468-.18-.514a7.81 7.81 0 0 1-.083-.247c-.015-.086-.006-.185 0-.282.002-.07.01-.15.025-.24a2.21 2.21 0 0 1 .057-.219zm-.392-1.348c-.125.137-.217.27-.297.405-.002.005-.007.007-.009.01a2.412 2.412 0 0 0-.086.166c-.012.025-.028.048-.04.073-.01.026-.012.049-.023.074-.018.043-.035.08-.053.128a3.324 3.324 0 0 0-.129.445l-.006.034a2.414 2.414 0 0 0-.024.954l.012.056c.04.133.07.225.108.331.253.72.234.664.258.85a.887.887 0 0 1-.131.6c-.204.352-.405.448-1.078.564-.381.065-.376.064-.525.096-.15.048-.274.116-.401.183-.024.01-.05.01-.072.024a.528.528 0 0 0-.042.029c-.04.023-.076.05-.113.076-.09.06-.184.135-.289.225-.028.025-.061.044-.089.07-.02.019-.03.036-.05.055-.027.026-.053.044-.08.072-.042.043-.071.093-.11.138a3.07 3.07 0 0 0-.15.188 2.472 2.472 0 0 0-.137.202l-.011.016c-.005.008-.004.017-.008.025a2.17 2.17 0 0 0-.188.4c-.046.2-.043.182-.119.596-.12.662-.219.862-.568 1.064-.22.126-.4.16-.615.128-.184-.027-.12-.006-.838-.266a8.838 8.838 0 0 0-.265-.092 2.544 2.544 0 0 0-.487-.052c-.009 0-.017-.005-.026-.005-.024 0-.059.007-.084.008a2.626 2.626 0 0 0-.382.037c-.044.007-.084.013-.13.023a3.246 3.246 0 0 0-.427.123c-.023.008-.039.017-.06.025-.038.014-.071.017-.109.033-.02.009-.034.025-.054.034a2.44 2.44 0 0 0-.217.109c-.044.026-.077.062-.11.098-.09.06-.193.1-.272.172-.157.168-.51.584-.557.636-.31.344-.51.458-.868.458-.362 0-.563-.116-.877-.474-.046-.052-.378-.453-.496-.584a2.422 2.422 0 0 0-.406-.297c-.004-.002-.006-.007-.01-.009a2.325 2.325 0 0 0-.163-.085c-.026-.012-.05-.029-.075-.04-.026-.012-.049-.013-.074-.024-.043-.018-.08-.035-.128-.053a3.331 3.331 0 0 0-.445-.129l-.035-.006a2.416 2.416 0 0 0-.953-.024l-.056.012a6.68 6.68 0 0 0-.331.108c-.72.253-.664.234-.85.258a.887.887 0 0 1-.6-.131c-.352-.204-.448-.405-.564-1.078-.065-.381-.064-.376-.096-.525-.048-.15-.116-.274-.183-.401-.01-.024-.011-.05-.024-.072a.528.528 0 0 0-.029-.042c-.023-.04-.05-.076-.076-.113a3.08 3.08 0 0 0-.225-.289c-.025-.028-.044-.061-.07-.089-.019-.02-.036-.03-.055-.05-.026-.027-.044-.053-.072-.08-.043-.042-.093-.071-.137-.11a3.068 3.068 0 0 0-.19-.15c-.066-.048-.131-.096-.2-.137l-.017-.011c-.008-.005-.017-.004-.025-.008a2.17 2.17 0 0 0-.4-.188c-.2-.046-.182-.043-.596-.119-.662-.12-.862-.219-1.064-.568a.88.88 0 0 1-.128-.615c.027-.184.006-.12.266-.838.035-.096.065-.18.092-.265.036-.167.049-.328.052-.487 0-.01.005-.017.005-.026 0-.024-.007-.058-.008-.084a2.63 2.63 0 0 0-.037-.382c-.007-.044-.013-.084-.023-.13a3.249 3.249 0 0 0-.123-.427c-.008-.023-.017-.039-.025-.06-.014-.038-.017-.071-.033-.109-.009-.02-.025-.034-.034-.054a2.46 2.46 0 0 0-.109-.217c-.026-.045-.062-.077-.098-.11-.06-.09-.1-.193-.172-.272-.168-.157-.584-.51-.636-.557-.344-.31-.458-.51-.458-.868 0-.362.116-.563.474-.877.052-.046.453-.379.584-.496.125-.137.217-.27.297-.406.002-.004.007-.006.009-.01.025-.042.055-.1.085-.165.012-.025.029-.048.04-.073.011-.026.013-.048.024-.074.018-.042.035-.08.053-.128a3.33 3.33 0 0 0 .129-.445l.006-.034c.066-.317.084-.637.024-.954l-.012-.056a6.659 6.659 0 0 0-.108-.331c-.253-.72-.234-.664-.258-.85a.887.887 0 0 1 .131-.6c.204-.352.405-.448 1.078-.564.381-.065.376-.064.525-.096.15-.048.274-.116.401-.183.024-.01.049-.01.072-.024.012-.007.03-.021.042-.029.04-.023.076-.05.113-.076.09-.06.184-.135.288-.225.029-.025.062-.043.09-.07.02-.019.031-.036.05-.055.027-.026.053-.044.08-.072.042-.043.071-.093.11-.138.056-.067.106-.127.15-.188.048-.066.096-.132.137-.202l.011-.016c.005-.008.004-.017.008-.025.073-.13.143-.26.188-.4.046-.2.043-.182.119-.596.12-.662.219-.862.568-1.064a.88.88 0 0 1 .615-.128c.184.027.12.006.838.266.096.035.18.065.265.092.167.036.328.049.487.052.009 0 .017.005.026.005.024 0 .058-.007.084-.008.13-.003.257-.016.382-.037.044-.007.084-.013.13-.023.145-.032.287-.071.427-.123l.061-.025c.037-.014.07-.017.108-.033.02-.009.034-.025.054-.034.088-.04.164-.078.217-.11a.465.465 0 0 0 .11-.097c.09-.06.193-.1.272-.172.157-.168.51-.584.557-.636.31-.345.51-.458.868-.458.362 0 .563.116.877.474.046.052.378.453.496.584.137.125.27.217.405.297.004.002.007.007.01.009.043.025.1.054.165.085.025.012.049.029.074.04.026.012.049.013.074.024.043.018.08.035.128.053.147.055.296.095.445.129l.035.006c.316.066.636.084.953.024l.056-.012c.133-.04.225-.07.331-.108.72-.253.664-.234.85-.258a.887.887 0 0 1 .6.131c.352.204.448.405.564 1.078.065.381.064.376.096.525.048.15.116.274.183.4.01.025.01.05.024.073.007.012.021.03.029.042.023.04.05.075.075.113.061.09.136.184.226.289.025.028.044.061.07.089.019.02.036.03.055.05.026.027.044.053.072.08.043.042.093.071.138.11a3 3 0 0 0 .39.287l.016.011c.008.005.017.004.025.008.13.073.26.143.4.188.2.046.182.043.596.119.662.12.862.219 1.064.567.126.22.16.4.128.616-.027.184-.006.12-.266.837a8.839 8.839 0 0 0-.092.266 2.542 2.542 0 0 0-.052.487c0 .01-.005.017-.005.026 0 .024.007.058.008.084.003.13.015.256.037.382.007.044.013.084.023.13.032.145.071.287.123.427.008.023.017.039.025.06.014.037.017.071.033.109.009.02.025.034.035.054.04.088.077.164.108.217a.492.492 0 0 0 .098.11c.06.09.1.193.172.272.168.157.584.51.636.557.344.31.458.51.458.868 0 .362-.116.563-.474.877-.052.046-.453.378-.584.496zm-8.895-2.685C13.617 10.345 14 9.72 14 9a2 2 0 1 0-4 0c0 .72.383 1.345.953 1.697l-1.722 1.378a.663.663 0 0 0-.231.494v3.862c0 .302.229.569.556.569h4.888a.566.566 0 0 0 .556-.57v-3.86a.635.635 0 0 0-.231-.495l-1.722-1.378zM12 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2 8h-4v-3.26l2-1.6 2 1.6V16z" fill-rule="evenodd" data-reactid="442"></path>
							</svg>
						</div>
						<div class="textContainer">
							<h5> @lang('messages.home.host_guarantee') </h5>
							<p>
								@lang('messages.home.host_guarantee_desc')
								<a class="green-link" href="{{ url('host_guarantee') }}" target="_blank">
									{{trans('messages.search.learn_more')}}
								</a>
							</p>
						</div>
					</div>
					<div class="col-md-4 d-md-flex">
						<div class="iconContainer d-inline-block my-3 my-md-0 mr-md-4">
							<svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display:block; fill:currentColor; height:33px; width:33px;" data-reactid="455">
								<path d="M22.5 2h-21C.724 2 0 2.724 0 3.5v14.986C0 19.273.72 20 1.5 20h10.672l1.362 1.363a2 2 0 0 0 2.83.001c.379-.379.57-.87.582-1.364H22.5c.78 0 1.5-.727 1.5-1.514V3.5c0-.776-.724-1.5-1.5-1.5zm-6.843 18.657a1 1 0 0 1-1.416-.001l-2.826-2.826a1 1 0 0 1 1.414-1.414l2.827 2.825a.997.997 0 0 1 0 1.416zM23 18.486c0 .237-.275.514-.5.514h-5.8a1.99 1.99 0 0 0-.337-.466l-2.826-2.826a1.996 1.996 0 0 0-2.426-.304l-.736-.736A4.97 4.97 0 0 0 12 11a5 5 0 1 0-5 5c.942 0 1.812-.276 2.564-.729l.082.083.757.756a1.993 1.993 0 0 0 .305 2.427l.464.463H1.5c-.225 0-.5-.277-.5-.514V3.5c0-.224.276-.5.5-.5h21c.224 0 .5.276.5.5v14.986zM7 15a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm1.854-4.854a.5.5 0 0 1 0 .708l-1.951 1.95a.568.568 0 0 1-.808-.005l-.93-.985a.5.5 0 1 1 .728-.686l.617.654 1.636-1.636a.5.5 0 0 1 .708 0zM21 7.5a.5.5 0 0 1-.5.5h-5.974a.5.5 0 0 1 0-1H20.5a.5.5 0 0 1 .5.5zm0 3a.5.5 0 0 1-.5.5h-5.974a.5.5 0 0 1 0-1H20.5a.5.5 0 0 1 .5.5zm0 3a.5.5 0 0 1-.5.5h-5.974a.5.5 0 0 1 0-1H20.5a.5.5 0 0 1 .5.5z" fill-rule="evenodd" data-reactid="456">
								</path>
							</svg>
						</div>
						<div class="textContainer">
							<h5> @lang('messages.home.verified_id') </h5>
							<p> @lang('messages.home.verified_id_desc') </p>
						</div>
					</div>
				</div>
			</div>
		</main>
		@stop