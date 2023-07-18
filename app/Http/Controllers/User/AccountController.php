<?php

namespace App\Http\Controllers\User;

use App\{
    Http\Requests\UserRequest,
    Http\Controllers\Controller,
    Repositories\Front\UserRepository
};
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{

    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\UserRepository $repository
     *
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth');

        $this->repository = $repository;
    }

    public function index()
    {
        return view('user.dashboard.dashboard',[
            'allorders' => Order::whereUserId(Auth::user()->id)->count(),
            'pending' => Order::whereUserId(Auth::user()->id)->whereOrderStatus('pending')->count(),
            'progress' => Order::whereUserId(Auth::user()->id)->whereOrderStatus('In Progress')->count(),
            'delivered' => Order::whereUserId(Auth::user()->id)->whereOrderStatus('Delivered')->count(),
            'canceled' => Order::whereUserId(Auth::user()->id)->whereOrderStatus('Canceled')->count()

        ]);

    }


    public function profile()
    {
        $user = Auth::user();
        $check_newsletter = Subscriber::where('email',$user->email)->exists();
        return view('user.dashboard.index',[
            'user' => $user,
            'check_newsletter' => $check_newsletter,
        ]);
    }



    public function profileUpdate(UserRequest $request)
    {   $this->repository->profileUpdate($request);
        Session::flash('success',__('Profile Updated Successfully.'));
        return redirect()->back();
    }

    public function addresses()
    {
        $user = Auth::user();
        return view('user.dashboard.address',[
            'user' => $user
        ]);
    }

    public function billingSubmit(Request $request)
    {

        $request->validate([
            'bill_address1' => 'required|max:100',
            'bill_address2' => 'nullable|max:100',
            'bill_zip'      => 'nullable|max:100',
            'bill_city'      => 'required|max:100',
            'bill_company'   => 'nullable|max:100',
            'bill_country'   => 'required|max:100',
        ]);
        $user =  Auth::user();
        $input = $request->all();
        $user->update($input);
        Session::flash('success',__('Address update successfully'));
        return back();
    }

    public function shippingSubmit(Request $request)
    {
        $request->validate([
            'ship_address1' => 'required|max:100',
            'ship_address2' => 'nullable|max:100',
            'ship_zip'      => 'nullable|max:100',
            'ship_city'      => 'required|max:100',
            'ship_company'   => 'nullable|max:100',
            'ship_country'   => 'required|max:100',
        ]);
        $user =  Auth::user();
        $input = $request->all();
        $user->update($input);
        Session::flash('success',__('Address update successfully'));
        return back();
    }


}
