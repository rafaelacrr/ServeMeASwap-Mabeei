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
use Arr;

class ResetSwapController extends Controller
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

    protected function index($subdomain){
        $info=DB::table('Swaps')->where('subdomain', '=', $subdomain)->get();
        $courses=DB::table('Courses')->where('swap_subdomain', '=', $subdomain)->get();
        return view('resetSwap')
            ->with('info', $info)
            ->with('courses', $courses);
    }
    

    protected function resetSwap(Request $request){
        $oldSubdomain = $request->input('oldsubdomain');
        $newSubdomain = $request->input('subdomain');
        $validatedData = $request->validate([
            'subdomain' => 'string|max:255',
            'email' => 'string|max:255',
            'format' => 'string|min:2',
            'emailAdmin' => 'string|email|max:70|min:9',
            'password' => 'string|min:8',
        ]);
        $swap=DB::table('Swaps')->where('subdomain', '=', $request->input('oldsubdomain'))->update([
            'subdomain' => $request->input('subdomain'),
            'institutional_mail' => $request->input('email'),
            'password' => $request->input('password'),
            'email_format'=> $request->input('format'),
            'email_admin' => $request->input('emailAdmin'), 
        ]);
        $this->deleteSwap($oldSubdomain);
        $this->deploySwap($newSubdomain);
        return redirect(route('homepage'));
    }

    protected function deleteSwap($subdomain){
        $request=Http::delete('http://servemeaswap.com:4000/deploy/'.$subdomain, [
            'key' => config('app.opacum_key'),
        ]); 
    }

    protected function deploySwap($subdomain){
        $data=DB::table('Swaps')->where('subdomain', '=', $subdomain)->get();
        $courses=DB::table('Courses')->where('swap_subdomain', '=', $subdomain)->get();
        $info=$data[0];
        $request=Http::post('http://'.config('app.domain_url').":4000".'/deploy/'.$subdomain, [
          'key' => config('app.opacum_key'),
          'mail_domain' => $info->institutional_mail,
          'admin' => ['email'=>$info->email_admin,'password'=>$info->password],
          'courses' => $courses,
        ]);
    }
}
