<?php

/**
 * Home Controller
 *
 * @package     Tempus media | Booking
 * @subpackage  Controller
 * @category    Home
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Http\Helper\FacebookHelper;
use App\Http\Start\Helpers;
use App\Models\Contactus;
use App\Models\Currency;
use App\Models\Help;
use App\Models\HelpSubCategory;
use App\Models\HomeCities;
use App\Models\OurCommunityBanners;
use App\Models\Pages;
use App\Models\Reservation;
use App\Models\Rooms;
use App\Models\SiteSettings;
use App\Models\HelpTranslations;
use App\Models\HomePageSlider;
use App\Models\User;
use App\Models\Rating;
use Auth;
use Illuminate\Http\Request;
use Route;
use Session;
use Validator;
use View;

class HomeController extends Controller
{
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		//
	}



	/**
	 * Load Social OR Email Signup view file with Generated Facebook login URL
	 *
	 * @return Signup page view
	 */
	public function signup_login(Request $request)
	{
		$data['class'] = '';

		// Social Signup Page
		if ($request->input('sm') == 1 || $request->input('sm') == '') {
			Session::put('referral', $request->referral);
			if ($request->referral && User::find($request->referral) == null) {
				abort(404);
			}
			return view('home.signup_login', $data);
		}
		// Email Signup Page
		else if ($request->input('sm') == 2) {
			return view('home.signup_login_2', $data);
		}

		abort(404);
	}

	public function generateFacebookurl()
	{
		// flash_message('danger', trans('messages.login.facebook_https_error'));
		// return redirect('login');

		if (!session_id()) {
			session_start();
		}

		$fb = new FacebookHelper;
		$fb_url = $fb->getUrlLogin();
		return redirect($fb_url);
	}

	/**
	 * Set session for Currency & Language while choosing footer dropdowns
	 * Lang: {"language":"de"}
	 * Currency: {"currency":"USD","previous_currency":"EUR"}
	 */
	public function set_session(Request $request)
	{

		if ($request->currency) {
			Session::put('currency', $request->currency);
			Session::put('previous_currency', $request->previous_currency);
			$symbol = Currency::original_symbol($request->currency);
			Session::put('symbol', $symbol);
			Session::put('search_currency', $request->previous_currency);
		} else if ($request->language) {
			Session::put('language', $request->language);
			App::setLocale($request->language);
		}
	}

	/**
	 * View Static Pages
	 *
	 * @param array $request  Input values
	 * @return Static page view file
	 */
	public function static_pages($name, Request $request)
	{


		if ($request->token != '') {
			Session::put('get_token', $request->token);
		}

		if ($request->name == ADMIN_URL) {
			return redirect()->route('admin_dashboard');
		}

		$pages = Pages::where(['url' => $name, 'status' => 'Active'])->firstOrFail();

		$data['content'] = str_replace(['SITE_NAME', 'SITE_URL'], [SITE_NAME, url('/')], $pages->content);
		//$data['content'] = $pages->content;
		$data['title'] = $pages->name;


		return view('home.static_pages', $data);
	}

	public function help(Request $request)
	{

		if ($request->token != '') {
			Session::put('get_token', $request->token);
			if (isset($request->language)) {
				App::setLocale($request->language);
				Session::put('language', $request->language);
			} else {
				App::setLocale('en');
			}
		}

		if (Route::current()->uri() == 'help') {
			$data['result'] = Help::with(['category', 'subcategory'])->whereSuggested('yes')->get();
		} elseif (Route::current()->uri() == 'help/topic/{id}/{category}') {
			$count_result = HelpSubCategory::find($request->id);
			$data['subcategory_count'] = $count = (str_slug($count_result->name, '-') != $request->category) ? 0 : 1;
			$data['is_subcategory'] = (str_slug($count_result->name, '-') == $request->category) ? 'yes' : 'no';
			if ($count) {
				$data['result'] = Help::whereSubcategoryId($request->id)->whereStatus('Active')->get();
			} else {
				$data['result'] = Help::whereCategoryId($request->id)->whereStatus('Active')->get();
			}
		} else {
			$data['result'] = Help::whereId($request->id)->whereStatus('Active')->get();
			$data['is_subcategory'] = ($data['result'][0]->subcategory_id) ? 'yes' : 'no';
		}

		$data['category'] = Help::with(['category', 'subcategory'])->whereStatus('Active')->groupBy('category_id')->get(['category_id', 'subcategory_id']);

		return view('home.help', $data);
	}

	public function ajax_help_search(Request $request)
	{
		$lan = Session::get('language');
		$term = $request->term;

		$queries = Help::whereHas('category', function ($query) {
			$query->where("status", "active");
		})->whereHas('subcategory', function ($query) {
			$query->where("status", "active");
		})
			->where('status', 'active')
			->where('question', 'like', '%' . $term . '%')
			->get();

		$queries_translate = HelpTranslations::where('locale', $lan)
			->where('name', 'like', '%' . $term . '%')
			->get();

		if ($lan == 'en') {
			if ($queries->isEmpty()) {
				$results[] = ['id' => '0', 'value' => trans('messages.search.no_results_found'), 'question' => trans('messages.search.no_results_found')];
			} else {
				foreach ($queries as $query) {
					$results[] = ['id' => $query->id, 'value' => str_replace('SITE_NAME', SITE_NAME, $query->question), 'question' => str_slug($query->question, '-'), 'target' => route('help_question', ['id' => $query->id, 'question' => str_slug($query->question, '-')])];
				}
			}
		} else {
			if ($queries_translate->isEmpty()) {
				$results[] = ['id' => '0', 'value' => trans('messages.search.no_results_found'), 'question' => trans('messages.search.no_results_found')];
			} else {
				foreach ($queries_translate as $translate) {
					$results[] = ['id' => $translate->help_id, 'value' => str_replace('SITE_NAME', SITE_NAME, $translate->name), 'question' => str_slug($translate->name, '-'), 'target' => route('help_question', ['id' => $translate->help_id, 'question' => str_slug($translate->name, '-')])];
				}
			}
		}

		return json_encode($results);
	}

	public function contact_create(Request $request, EmailController $email_controller)
	{


		// return $request->all();
		$rules = array(
			'name' => 'required',
			'email' => 'required|max:255|email',
			'feedback' => 'required|min:6',
			'gdpr' => 'required'
		);

		$messages = array(
			//
		);

		$attributes = array(
			'name' => trans('messages.contactus.name'),
			'email' => trans('messages.contactus.email'),
			'feedback' => trans('messages.contactus.feedback'),
		);

		$request->validate($rules, $messages, $attributes);


		$user_contact = new Contactus;

		$user_contact->name = $request->name;
		$user_contact->email = $request->email;
		$user_contact->feedback = $request->feedback;

		$user_contact->save(); // Create a new user

		$email_controller->contact_email_confirmation($user_contact);

		flash_message('success', trans('messages.contactus.sent_successfully')); // Call flash message function
		return redirect('contact_us');
	}




	public function clearLog()
	{
		session()->forget('get_token');
		exec('echo "" > ' . storage_path('logs/laravel.log'));
	}

	public function showLog()
	{
		$contents = \File::get(storage_path('logs/laravel.log'));
		echo '<pre>' . $contents . '</pre>';
	}

	public function ratings(Request $request, EmailController $email_controller)
	{
		$rules = array(
			'name' => 'required',
			'email' => 'required|max:255|email',
			'feedback' => 'required|min:6',
		);

		$messages = array(
			//
		);

		$attributes = array(
			'name' => trans('messages.contactus.name'),
			'email' => trans('messages.contactus.email'),
			'feedback' => trans('messages.contactus.feedback'),
		);

		$request->validate($rules, $messages, $attributes);


		$user_contact = new Rating();

		$user_contact->name = $request->name;
		$user_contact->email = $request->email;
		$user_contact->feedback = $request->feedback;
		$user_contact->compliance_of_the_boat = $request->compliance_of_the_boat;
		$user_contact->comfort_on_board = $request->comfort_on_board;
		$user_contact->standard_of_maintenance = $request->standard_of_maintenance;
		$user_contact->cleanliness = $request->cleanliness;
		$user_contact->welcome_and_communication = $request->welcome_and_communication;
		$user_contact->value_for_money = $request->value_for_money;
		$user_contact->boat = $request->boat;

		$user_contact->save(); // Create a new user

		//$email_controller->contact_email_confirmation($user_contact);

		flash_message('success', trans('messages.feedback.feedback_sent_successfully')); // Call flash message function
		return redirect()->back();
	}
}
