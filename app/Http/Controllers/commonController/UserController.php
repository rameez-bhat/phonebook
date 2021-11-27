<?php

namespace App\Http\Controllers\commonController;

use App\User;
use App\Contact;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $redirect="customer/dashboard";
        if(Auth::check() && (Auth::user()->type=="superAdmin" || Auth::user()->type=="admin"))
        {
            $redirect="admin/dashboard";
        }
        else if(!Auth::check())
        {
            $redirect="customer/login";  
        }
        return redirect($redirect);
    }
    public function adminDashboard()
    {
        $this->CheckifAdmin();
        $ViewContactsCount = Contact::select(\DB::raw("COUNT(*) as count"))
    ->groupBy(\DB::raw("Month(created_at)"))
    ->pluck('count');
        dd($ViewContactsCount);exit;
        $data = User::where("type","user")->paginate(5);
    
        return view('admin.dashboard',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function adminDashboardViewCustomerContacts($id)
    {
        $this->CheckifAdmin();
        $data = Contact::where("user_id",$id)->paginate(5);
        $user = User::where("id",$id)->get()->toArray();
        return view('admin.contacts',compact(['data', 'user']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function adminDeleteCustomer($id)
    {
        $this->CheckifAdmin();
        User::destroy($id);
        return redirect('/admin/dashboard');
    }
    public function adminEditCustomer($id)
    {
        $this->CheckifAdmin();
        $data = User::where("id",$id)->get()->toArray();
        return view('admin.edit',compact('data'));
    }
    public function postAdminUpdateCustomer( $userid, Request $request)
    {
        $this->CheckifAdmin();
        $this->validate(request(), [
            'name' => 'required',
            'email' => "required|email|unique:users,email,$userid,id",
            'password' => 'required|min:6|confirmed',
            'type' => 'required',
        ]);
        $user=User::find($userid);
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));

        $user->save();

        return redirect("admin/dashboard")->withSuccess('Successfully Updated');
    }
    public function adminCreateCustomer()
    {
        $this->CheckifAdmin();
        return view('admin.create');
    }
    public function postAdminCreateCustomer(Request $request)
    {
        $this->CheckifAdmin();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'type' => 'required',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
        return redirect("admin/dashboard")->withSuccess('Successfully Added');
    }

    public function adminDeleteCustomerContact($id,$clientid)
    {
        $this->CheckifAdmin();
        Contact::destroy($id);
        return redirect('/admin/dashboard/view-contacts/'.$clientid);
    }
    public function adminCreateCustomerContact($userid)
    {
        $this->CheckifAdmin();
        $ClientList = User::where("type","user")->get();
        $UserSelected=$userid;
        return view('admin.createcontact',compact(['ClientList', 'UserSelected']));
    }
    public function postAdminCreateCustomerContact(Request $request)
    {
        $this->CheckifAdmin();
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'phone' => 'required|min:8|unique:contacts',
        ]);
           
        $data = $request->all();
        $check = $this->createContact($data);
        return redirect("/admin/dashboard/view-contacts/".$data['user_id'])->withSuccess('Successfully Added');
    }
    public function adminEditCustomerContact($id,$clientid)
    {
        $this->CheckifAdmin();
        $data = Contact::where("id",$id)->get()->toArray();
       // dd($data);exit;
        $ClientList = User::where("type","user")->get();
        $UserSelected=$clientid;
        return view('admin.updatecontact',compact(['ClientList', 'UserSelected','data']));
    }
    public function adminPostEditCustomerContact( $id,$clientid, Request $request)
    {
        $this->CheckifAdmin();
        $this->validate(request(), [
            'name' => 'required',
            'user_id' => 'required',
            'phone' => 'required|min:8|unique:contacts,phone,$id,id',
        ]);
        $user=Contact::find($id);
        $user->name = request('name');
        $user->phone = request('phone');
        $user->user_id = request('user_id');
        $user->save();

        return redirect("/admin/dashboard/view-contacts/".$clientid)->withSuccess('Successfully Updated');
    }
    public function customerDashboard()
    {
        $Clientid=Auth::user()->id;
        $data = Contact::where("user_id",$Clientid)->paginate(5);
    
        return view('customer.dashboard',compact(['data','Clientid']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function customerEditCustomerContact($id,$clientid)
    {
        $data = Contact::where("id",$id)->get()->toArray();
       // dd($data);exit;
        $ClientList = User::where("type","user")->get();
        $UserSelected=$clientid;
        return view('customer.updatecontact',compact(['ClientList', 'UserSelected','data']));
    }
    public function customerPostEditCustomerContact( $id,$clientid, Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'user_id' => 'required',
            'phone' => 'required|min:8|unique:contacts,phone,$id,id',
        ]);
        $user=Contact::find($id);
        $user->name = request('name');
        $user->phone = request('phone');
        $user->user_id = request('user_id');
        $user->save();

        return redirect("/customer/dashboard")->withSuccess('Successfully Updated');
    }

    public function customerCreateCustomerContact($userid)
    {
        $ClientList = User::where("type","user")->get();
        $UserSelected=$userid;
        return view('customer.createcontact',compact(['ClientList', 'UserSelected']));
    }
    public function postCustomerCreateCustomerContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'phone' => 'required|min:8|unique:contacts',
        ]);
           
        $data = $request->all();
        $check = $this->createContact($data);
        return redirect("/customer/dashboard")->withSuccess('Successfully Added');
    }
    public function customerDeleteCustomerContact($id,$clientid)
    {
        Contact::destroy($id);
        return redirect('/customer/dashboard/');
    }
   
    public function createContact(array $data)
    {
      return Contact::create([
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'phone' => $data['phone']
      ]);
    }
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type']
      ]);
    }  
    public function registration()
    {
        return view('auth.registration');
    }
    public function customerlogin()
    {
        view('auth.login'); 
    }
    public function login()
    {
            exit;
        return view('auth.login');
    }
    protected function CheckifAdmin()
    {
        if(!Auth::check() || Auth::user()->type=="user" )
        {
            return abort(404);
        }
    }
}
