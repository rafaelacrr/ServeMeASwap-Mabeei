<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Swap;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Arr;

class SwapController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after create a new Swap.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    protected function validateSubdomain($subdomain){
      $info=DB::table('Swaps')->where('subdomain', '=', $subdomain)->get();
      if(count($info)>0){
        return 0;
      }
      return 1;
    }


    /**
     * Create a new swap instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Swap
     */
    protected function create(Request $request){
      $subdomain=$request->input('subdomain');
      $validatedData = $request->validate([
        'subdomain' => 'unique:swaps|string|max:255',
        'email' => 'string|max:255',
        'format' => 'string|min:2',
        'emailAdmin' => 'string|email|max:70|min:9',
        'password' => 'string|min:8',
    ]);
      $swap = DB::transaction(function () use ($request) {
        $swap = swap::make([
          'subdomain' => $request->input('subdomain'),
          'institutional_mail' => $request->input('email'),
          'password' => ($request->input('password')),
          'email_format'=> $request->input('format'),
          'email_admin' => $request->input('emailAdmin'),
          'user_id' => Auth::id(),
        ]);
        $swap->save();
      });
      $result= $this->deploySwap($subdomain);
      return redirect(route('homepage'));
    }


    /**
     * Create a new swap instance after a valid registration.
     *
     * @param  Request  $request
     * @return \resources\views\home.blade.php
     */
    protected function addCourses(Request $request){
      $info=DB::table('Courses')->where('swap_subdomain', '=', $request[1])->delete();
      $size=count($request[2]);
      for($i = 0;$i<$size;$i++){
        $course = new Course;
        $course->code = $request[2][$i]['code'];
        $course->name = $request[2][$i]['name'];
        $course->year = $request[2][$i]['year'];
        $course->semester = $request[2][$i]['semester'];
        $course->swap_subdomain = $request[0];
        $course->save();
      }
    return redirect(route('homepage'));
  }

  /**
   * Sends a HTTP post to Opacum
   *
   * @param Subdomain $subdomain
   * @
   */
  protected function deploySwap($subdomain){
    $data=DB::table('Swaps')->where('subdomain', '=', $subdomain)->get();
    $courses=DB::table('Courses')->where('swap_subdomain', '=', $subdomain)->get();
    $info=$data[0];
    $request=HTTP::post('http://servemeaswap.com:4000/deploy/'.$subdomain, [
      'key' => config('app.opacum_key'),
      'mail_domain' => $info->institutional_mail,
      'admin' => ['email'=>$info->email_admin,'password'=>$info->password],
      'courses' => $courses,
    ]);
  }
}
