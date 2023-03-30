﻿@extends('template')
@section('main')
<main id="site-content" role="main" ng-cloak>
    @include('common.subheader')
    <div class="listing-content my-4 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 side-nav">
                    @include('common.sidenav')
                </div>
                <div class="col-12 col-md-9 listing-wrap mt-3 mt-md-0">
                    @if($listed_result->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3>
                                {{ trans('messages.your_listing.listed') }}
                            </h3>
                        </div>
                        <ul>
                            @foreach($listed_result as $row)
                            <li class="listing card-body mr-3">
                                <div class="row">


                                    <!-- img -->
                                    <div class="col-12 col-sm-5 col-md-6 col-lg-4 room-image pr-0">
                                        <a href="{{ url('rooms/'.$row->id) }}">
                                            {!! Html::image($row->photo_name, '', ['class' => 'img-fluid'])
                                            !!}
                                        </a>
                                    </div>


                                    <div class="col-12 col-sm-7 col-md-6 col-lg-8 d-flex flex-sm-column flex-lg-row">
                                        <div class="row">
                                            <!-- name -->
                                            <div class="col-12 col-md-12 col-lg-6 mt-3 mt-md-0">
                                                <a href="{{ url('rooms/'.$row->id) }}">
                                                    <h4>
                                                        {{ ($row->name == '') ? $row->sub_name : $row->name }}
                                                    </h4>
                                                </a>
                                                <div class="actions mt-1">
                                                    <a class="theme-link"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ trans('messages.your_listing.manage_listing_calendar') }}
                                                    </a>
                                                </div>
                                            </div>


                                            <!-- btn -->
                                            <div
                                                class="col-12 col-md-12 col-lg-6 mt-2 pl-md-0 pt-sm-3 pt-lg-0 mt-md-0 ml-0 d-flex align-items-center justify-content-start justify-content-md-end">
                                                <div class="list-btn-wrap-new d-flex align-items-center">
                                                    @if($row->steps_count == 0 && ( $row->status == NULL || $row->status
                                                    ==
                                                    'Pending'))
                                                    <a class="btn ml-auto"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ trans('messages.your_listing.pending') }}
                                                    </a>
                                                    @elseif($row->steps_count == 0 && $row->status == 'Resubmit')
                                                    <a class="btn ml-auto"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ trans('messages.profile.Resubmit') }}
                                                    </a>
                                                    @elseif($row->steps_count != 0)
                                                    <a class="btn ml-auto"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ $row->steps_count }}
                                                        {{ trans('messages.your_listing.steps_to_list') }}
                                                    </a>
                                                    @else
                                                    <div id="availability-dropdown"
                                                        class="availability-dropdown-wrap d-flex align-items-center justify-content-md-end ml-auto ml-md-3 mr-lg-2"
                                                        data-room-id="div_{{ $row->id }}">
                                                        <i class="dot mr-2 dot-{{ ($row->status == 'Listed') ? 'success' : 'danger' }}"
                                                            style="min-width: 10px;"></i>
                                                        <div class="select">
                                                            <select class="room_status_dropdown" style="min-width: 75px"
                                                                data-room-id="{{ $row->id }}">
                                                                <option value="Listed"
                                                                    {{ ($row->status == 'Listed') ? 'selected' : '' }}>
                                                                    {{ trans('messages.your_listing.listed') }}
                                                                </option>
                                                                <option value="Unlisted"
                                                                    {{ ($row->status == 'Unlisted') ? 'selected' : '' }}>
                                                                    {{ trans('messages.your_listing.unlisted') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-host step_count disable_after_click ml-2 ml-lg-2"
                                                        href="{{ url('listing/'.$row->id.'/duplicate') }}">
                                                        {{trans('messages.rooms.duplicate')}}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($unlisted_result->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3>
                                {{ trans('messages.your_listing.unlisted') }}
                            </h3>
                        </div>
                        <ul>
                            @foreach($unlisted_result as $row)
                            <li class="listing card-body mr-3">
                                <div class="row">

                                    <!-- unlisted img -->
                                    <div class="col-12 col-sm-5 col-md-6 col-lg-4 room-image pr-0">
                                        <a href="{{ url('rooms/'.$row->id) }}">
                                            {!! Html::image($row->photo_name, '', ['class' => 'img-fluid'])
                                            !!}
                                        </a>
                                    </div>


                                    <div class="col-12 col-sm-7 col-md-6 col-lg-8 d-flex flex-sm-column flex-lg-row">
                                        <div class="row" style="width: 100%">
                                            <!-- unlisted name -->
                                            <div class="col-12 col-md-12 col-lg-6 mt-3 mt-md-0">
                                                <a href="{{ url('rooms/'.$row->id) }}">
                                                    <h4>
                                                        {{ ($row->name == '') ? $row->sub_name : $row->name }}
                                                    </h4>
                                                </a>
                                                <div class="actions mt-1">
                                                    <a class="theme-link"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">{{ trans('messages.your_listing.manage_listing_calendar') }}</a>
                                                </div>
                                            </div>

                                            <!-- btn -->
                                            <div
                                                class="col-12 col-md-12 col-lg-6 mt-2 md-0 mt-md-0 pt-sm-3 pt-lg-0 d-flex align-items-center justify-content-start justify-content-lg-end">

                                                <div class=" list-btn-wrap-new d-flex align-items-center">
                                                    @if($row->steps_count == 0 && ($row->status == NULL || $row->status
                                                    ==
                                                    'Pending'))
                                                    <a class=" btn ml-auto pl-3 "
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ trans('messages.your_listing.pending') }}
                                                    </a>
                                                    @elseif($row->steps_count == 0 && $row->status == 'Resubmit')
                                                    <a class="btn ml-auto pl-3"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ trans('messages.profile.Resubmit') }}
                                                    </a>
                                                    @elseif($row->steps_count != 0)
                                                    <a class="btn ml-auto pl-3"
                                                        href="{{ url('manage-listing/'.$row->id.'/basics') }}">
                                                        {{ $row->steps_count }}
                                                        {{ trans('messages.your_listing.steps_to_list') }}
                                                    </a>
                                                    @else
                                                    <div id="availability-dropdown"
                                                        class="availability-dropdown-wrap d-flex align-items-center justify-content-md-end ml-auto ml-md-3 mr-lg-0"
                                                        data-room-id="div_{{ $row->id }}">
                                                        <i class="dot mr-2 dot-{{ ($row->status == 'Listed') ? 'success' : 'danger' }}"
                                                            style="min-width: 10px !important"></i>
                                                        <div class="select">
                                                            <select class="room_status_dropdown"
                                                                data-room-id="{{ $row->id }}">
                                                                <option value="Listed"
                                                                    {{ ($row->status == 'Listed') ? 'selected' : '' }}>
                                                                    {{ trans('messages.your_listing.listed') }}
                                                                </option>
                                                                <option value="Unlisted"
                                                                    {{ ($row->status == 'Unlisted') ? 'selected' : '' }}>
                                                                    {{ trans('messages.your_listing.unlisted') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($unlisted_result->count() == 0 && $listed_result->count() == 0)
                    <div class="card">
                        <div class="card-body">
                            <p>
                                {{ trans('messages.your_listing.no_listings') }}
                            </p>
                            <a href="{{ url('/') }}/rooms/new" class="become-a-host__btn" id="list-your-space" style="  color: #ffffff !important;
                        background: #009fda !important;
                        line-height: 0 !important;
                        padding: 20px 20px !important;
                        border-radius: 6px !important;
                        font-size: 16px !important;">
                                {{ trans('messages.your_listing.add_new_listings') }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@stop