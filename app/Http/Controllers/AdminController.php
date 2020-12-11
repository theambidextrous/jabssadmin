<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use App\Bank;
use App\Mpesa;
use App\Transaction;
use App\Address;
use App\Pan;
use Validator;
use Storage;
use Config;

class AdminController extends Controller
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
    public function index()
    {
        return view('admin.a_home')->with([
            'courses' => [],
            'counters' => $this->counters(),
            'recents' => $this->recent()
        ]);
    }
    public function trans()
    {
        return view('admin.a_trans')->with([
            'recents' => $this->recent(1000)
        ]);
    }
    public function tran($ref)
    {
        return view('admin.a_tran')->with([
            'r' => $this->one_tran($ref)
        ]);
    }
    public function deltran($id)
    {
        $t = Transaction::find($id);
        if(is_null($t))
        {
            return redirect()->route('a_trans')->with([
                'status' => 201,
                'message' => 'Entry you tried to delete does not exist',
            ]);
        }
        Mpesa::where('internal_ref', $t->mpesa_tran_ref)->delete();
        Bank::where('internal_ref', $t->bank_tran_ref)->delete();
        $t->delete();
        return redirect()->route('a_trans')->with([
            'status' => 200,
            'message' => 'Entry deleted successfully',
        ]);
    }
    public function mps()
    {
        return view('admin.a_mps')->with([
            'recents' => $this->m_recent(1000)
        ]);
    }
    public function mp($ref)
    {
        return view('admin.a_mp')->with([
            'r' => $this->one_mp($ref)
        ]);
    }
    public function bnks()
    {
        return view('admin.a_bnks')->with([
            'recents' => $this->b_recent(1000)
        ]);
    }
    public function bnk($ref)
    {
        return view('admin.a_bnk')->with([
            'r' => $this->one_bnk($ref)
        ]);
    }
    public function users()
    {
        return view('admin.a_users')->with([
            'recents' => $this->regular_users()
        ]);
    }
    public function user($id)
    {
        return view('admin.a_user')->with([
            'r' => User::find($id),
            'add' => $this->u_address($id),
            'pan' => $this->u_pan($id),
        ]);
    }
    public function admins()
    {
        return view('admin.a_admins')->with([
            'recents' => $this->regular_admins()
        ]);
    }
    public function a_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'password' => 'required|string',
            'cpassword' => 'required|string|same:password'
        ]);
        if( $validator->fails() ){
            return redirect()->route('a_admins')->with([
                'status' => 201,
                'message' => 'Could not create record. Make sure all fields are set',
            ]);
        }
        $input = $request->all();
        $input['address'] = 'n/a';
        $input['city'] = 'n/a';
        $input['state'] = 'n/a';
        $input['zip'] = 'n/a';
        $input['email_verified_at'] = date('Y-m-d H:i:s');
        $input['password'] = Hash::make($input['password']);
        $input['user_type'] = true;
        User::create($input);
        return redirect()->route('a_admins')->with([
            'status' => 200,
            'message' => 'Admin user created',
        ]);
    }
    public function deluser($id)
    {
        $t = User::find($id);
        if(is_null($t))
        {
            return redirect()->route('a_users')->with([
                'status' => 201,
                'message' => 'Record you tried to delete does not exist',
            ]);
        }
        if( Transaction::where('user', $id)->count() > 0 )
        {
            return redirect()->route('a_users')->with([
                'status' => 201,
                'message' => 'Record could not be deleted because the user has active transactions',
            ]);
        }
        $t->delete();
        return redirect()->route('a_users')->with([
            'status' => 200,
            'message' => 'Record deleted successfully',
        ]);
    }
    public function deladmin($id)
    {
        $t = User::find($id);
        if(is_null($t))
        {
            return redirect()->route('a_admins')->with([
                'status' => 201,
                'message' => 'Record you tried to delete does not exist',
            ]);
        }
        if( Transaction::where('user', $id)->count() > 0 )
        {
            return redirect()->route('a_admins')->with([
                'status' => 201,
                'message' => 'Record could not be deleted because the user has active transactions',
            ]);
        }
        $t->delete();
        return redirect()->route('a_admins')->with([
            'status' => 200,
            'message' => 'Record deleted successfully',
        ]);
    }
    protected function u_address($id)
    {
        $m = Address::where('user', $id)->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function u_pan($id)
    {
        $m = Pan::where('user', $id)->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function regular_users()
    {
        $m = User::where('email_verified_at', '!=', null)
            ->where('user_type', false)
            ->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function regular_admins()
    {
        $m = User::where('user_type', true)
            ->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function m_recent($take = 10)
    {
        $m = Mpesa::where('status', true)
            ->orderBy('id', 'desc')
            ->skip(0)
            ->take($take)
            ->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function b_recent($take = 10)
    {
        $m = Bank::where('status', true)
            ->orderBy('id', 'desc')
            ->skip(0)
            ->take($take)
            ->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function one_tran($ref)
    {
        $m = Transaction::where('internal_ref', $ref)
            ->first();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function one_mp($ref)
    {
        $m = Mpesa::where('internal_ref', $ref)
            ->first();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function one_bnk($ref)
    {
        $m = Bank::where('internal_ref', $ref)
            ->first();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function recent($take = 10)
    {
        $m = Transaction::where('status', true)
            ->orderBy('id', 'desc')
            ->skip(0)
            ->take($take)
            ->get();
        if(is_null($m))      
        {
            return [];
        } 
        return $m->toArray();
    }
    protected function counters()
    {
        $m = Mpesa::where('status', true)->count();
        $b = Bank::where('status', true)->count();
        $u = User::where('user_type', false)->where('email_verified_at', '!=', null)->count();
        
        return [ $m, $b, $u];
    }
}
