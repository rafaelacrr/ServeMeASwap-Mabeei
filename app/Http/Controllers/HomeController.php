<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Swap;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function newSwap(){

        return view('newSwap');

    }

    /**
     * Delete a Swap
     *
     */
    protected function deleteSwap($id){

        $user= DB::table('swaps')->where('id', $id)->pluck('user_id')->first();        
        if (Auth::check() && (Auth::id())==$user){  
            $subdomain= DB::table('swaps')->where('id', $id)->pluck('subdomain')->first();
            DB::table('swaps')->where('id', $id)->delete();
            DB::table('courses')->where('swap_subdomain', $subdomain)->delete();
            $this->delete($subdomain);
            return redirect(route('homepage'));
        }
    }

    /**
     * Sends a HTTP delete to Opacum 
     *
     */
    protected function delete($subdomain){
        $request=Http::delete('http://servemeaswap.com:4000/deploy/'.$subdomain, [
            'key' => config('app.opacum_key'),
        ]); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

      $id= Auth::id();
      $swaps=DB::table('Swaps')->where('user_id', '=', $id)->get();
      return view('home', ['swaps' => $swaps]);
    }

}
