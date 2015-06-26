<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

    /**
     * Returns the login view
     *
     * @return \Illuminate\View\View
     */
    public function getLogin() {
        return view('auth.login');
    }



    /**
     * Logs the user out and redirects him/her to the main page
     *
     * @return mixed
     */
    public function logout() {

        \Auth::logout();

        return \Redirect::to('/');
    }

}
