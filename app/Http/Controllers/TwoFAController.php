<?php

namespace App\Http\Controllers;

use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFAController extends Controller
{
        /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('twofactor');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);
  
        $find = UserCode::where('user_id', auth()->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();
  
        if (!is_null($find)) {
            Session::put('user_2fa', auth()->user()->id);
            return redirect()->route('blog.index');
        }
  
        return back()->with('error', 'You entered wrong code.');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update()
    {

        generateCode(auth()->user());
        return back()->with('success', 'We sent you code on your email.');
    }
}
