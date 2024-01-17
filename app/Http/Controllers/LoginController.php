<?php

namespace App\Http\Controllers;
// use App\Models\User;
use App\Models\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;

// use Illuminate\Support\Facades\Hash;

//use Session;

class LoginController extends Controller {

	public function index() {

		if (Auth::check()) {
			return redirect()->route('dashboard');
		} else {
			return view('login/index');
		}

	}

	public function loginWithOTP(Request $request) {

		if (Auth::check()) {
			return redirect()->route('dashboard');
		} else {
			$data = array();
			$data['type'] = isset($request->type) ? $request->type : 0;
			$data['email'] = isset($request->email) ? $request->email : "";
			return view('login/login_with_otp', compact('data'));
		}

	}
	public function loginProcess(Request $request) {

		if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]) && !Auth::attempt(['phone_number' => $request->email, 'password' => $request->password])) {

			return redirect()->route('login')->with("error", "Email or password incorrect!");

		} else {

			$userTypes = getAllUserTypes();

			if (!isset($userTypes[$request->user()->type]['can_login']) || (isset($userTypes[$request->user()->type]['can_login']) && $userTypes[$request->user()->type]['can_login'] == 0)) {

				Auth::logout();
				$request->session()->invalidate();
				$request->session()->regenerateToken();
				return redirect()->route('login')->with("error", "You haven't access to sign in");

			} else if ($request->user()->status != 1) {

				Auth::logout();
				$request->session()->invalidate();
				$request->session()->regenerateToken();
				return redirect()->route('login')->with("error", "You cannot login because your account has been locked");

			}

			// if ($request->user()->is_changed_password == 0) {

			// 	Auth::logout();
			// 	$request->session()->invalidate();
			// 	$request->session()->regenerateToken();
			// 	return redirect()->route('login')->with("error", "Must login with OTP(One Time Password) first time");

			// }

			$request->session()->regenerate();
			$user = Auth::user();
			$user->last_login_date_time = date('Y-m-d H:i:s');
			$user->save();

			// Start Debug Log

			$debugLog = array();
			$debugLog['name'] = "user-login";
			$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged in ";
			saveDebugLog($debugLog);

			// End Debug Log

			return redirect()->route('dashboard');
		}

	}

	public function loginWithOTPProcess(Request $request) {

		$validate = isset($request->validate) ? $request->validate : 0;

		$rules = array();
		$rules['email'] = 'required';
		$customMessage = array();
		$customMessage['email.required'] = "Please enter valid email/phone number";
		$validator = Validator::make($request->all(), $rules, $customMessage);
		if ($validator->fails()) {

			return redirect()->route('login.otp')->with("error", "Please enter valid email/phone number");

		} else {

			$typeOfLogin = "email";

			$User = User::where('email', $request->email)->first();
			if (!$User) {
				$typeOfLogin = "phone_number";
				$User = User::where('phone_number', $request->email)->first();
			}

			if ($User) {

				if ($validate == 0) {

					$userTypes = getAllUserTypes();

					if (!isset($userTypes[$User->type]['can_login']) || (isset($userTypes[$User->type]['can_login']) && $userTypes[$User->type]['can_login'] == 0)) {

						return redirect()->route('login')->with("error", "You haven't access to sign in");

					} else if ($User->status != 1) {

						return redirect()->route('login')->with("error", "You cannot login because your account has been locked");

					}

					// if ($typeOfLogin == "email") {

					// } else if ($typeOfLogin == "phone_number") {

					// }

					$one_time_password = (rand(1000, 9999));
					$User->one_time_password = $one_time_password;
					$User->save();

					$params = array();

					$params['to_email'] = $User->email;
					// if (Config::get('app.env') == "local") {
					// 	$params['to_email'] = "ankitsardhara4@gmail.com";
					// }

					$configrationForNotify = configrationForNotify();

					$params['from_name'] = $configrationForNotify['from_name'];
					$params['from_email'] = $configrationForNotify['from_email'];
					$params['to_name'] = $configrationForNotify['to_name'];
					$params['subject'] = "OTP (One Time Password) - Whitelion";
					$params['one_time_password'] = $one_time_password;

					if (Config::get('app.env') == "local") {
						$params['to_email'] = $configrationForNotify['test_email'];
						
					}

					Mail::send('emails.one_time_password', ['params' => $params], function ($m) use ($params) {
						$m->from($params['from_email'], $params['from_name']);
						$m->to($params['to_email'], $params['to_name'])->subject($params['subject']);

					});

					$params['mobile_numer'] = $User->phone_number;
					// if (Config::get('app.env') == "local") {
					// 	$params['mobile_numer'] = "9913834380";
					// }
					sendOTPToMobile($params['mobile_numer'], $one_time_password);

					return redirect()->route('login.otp', 'type=1&email=' . $request->email)->with("success", "Successfully sent otp to " . $params['to_email'] . "/" . $params['mobile_numer']);
				} else {

					$one_time_password = implode("", $request->one_time_password);
					$one_time_password = implode("", $request->one_time_password);
					if ($User->one_time_password == $one_time_password) {
						$User->one_time_password = "";
						$User->save();
						Auth::loginUsingId($User->id);
						$request->session()->regenerate();
						$user = Auth::user();
						$user->last_login_date_time = date('Y-m-d H:i:s');
						$user->save();

						// Start Debug Log

						$debugLog = array();
						$debugLog['name'] = "user-login";
						$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged in ";
						saveDebugLog($debugLog);

						// End Debug Log

						return redirect()->route('dashboard');

					} else {

						return redirect()->route('login.otp', 'type=1&email=' . $request->email)->with("error", "incorrect OTP(One Time Password)");

					}

				}

			} else {

				return redirect()->route('login.otp')->with("error", "Please enter valid email/phone number");

			}

		}

	}

	public function logout(Request $request) {

		// Start Debug Log

		if (isset(Auth::user()->id)) {
			$debugLog = array();
			$debugLog['name'] = "user-logout";
			$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged out ";
			saveDebugLog($debugLog);

		}

		// End Debug Log

		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('login')->with("success", "Successfully logout");
	}

}
