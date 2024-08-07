<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\tbl_mail_notifications;
use App\tbl_activities;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;

class employeecontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function employeelist()
    {
        $user = Auth::User();

        $users = User::select(
                'users.*',
                'tbl_accessrights.name as position'
            )->join('tbl_accessrights', 'tbl_accessrights.id', '=', 'users.role');

        $users = $users->where('users.id', '!=', $user->id)->orderBy('id', 'DESC')->get();
        if(auth()->user()->role=="admin"){
            $users=User::orderBy('updated_at', 'DESC')->get();
        }

        return view('employee.list', compact('users'));
    }


    // employee addform

    public function addemployee()
    {
        $states = DB::table('tbl_states')->get()->toArray();
        $country = DB::table('tbl_countries')->get()->toArray();
        $roles = DB::table('tbl_accessrights')->where('status', '=', 'active')->get()->toArray();

        return view('employee.add', compact('country', 'roles', 'states'));
    }


    // employee store

    public function store(Request $request)
    {
        $this->authorize('create', new User);
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
        ]);
        $firstname = $request->input('firstname');
        $email = $request->input('email');

        $password = $request->input('password');

        if (getDateFormat() == 'm-d-Y') {
            $dob = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('dob'))));
        } else {
            $dob = date('Y-m-d', strtotime($request->input('dob')));
        }

        $user = new User();
        $user->name = $firstname;
        $user->lastname = $request->input('lastname');
        $user->display_name = $request->input('displayname');
        $user->gender = $request->input('gender');
        $user->birth_date = join('-', array_reverse(explode('-', $request->input('dob'))));
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->mobile_no = $request->input('mobile');
        $user->address = $request->input('address');
        $user->api_token = auth()->user()->createToken('authToken')->accessToken;
        if (!empty($request->hasFile('image'))) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path() . '/employee/', $file->getClientOriginalName());
            $user->image = $filename;
        } else {
            $user->image = 'avtar.png';
        }
        $user->role = $request->input('role');

        if ($request->input('role') >= 90) {
            $user->branch_id = \App\Models\User::BRANCH_LABORATORY;
        }
        $user->save();
        $last_id = DB::table('users')->orderBy('id', 'desc')->get()->first();
        $userA = Auth::user();
        $active = new tbl_activities;
        $active->ip_adress = $_SERVER['REMOTE_ADDR'];
        $active->user_id = $userA->id;
        $active->action_id = $last_id->id;
        $active->action_type = 'user_added';
        $active->action = "Foydalanuvchi qo'shildi";
        $active->time = date('Y-m-d H:i:s');
        $active->save();

        return redirect('/employee/list')->with('message', 'Successfully Submitted');
    }


    public function getrole(Request $request)
    {
        $position = $request->input('position');
        $role = DB::table('tbl_accessrights')->where('id', '=', $position)->get()->first();
        echo $role->position;
    }


    // employee edit

    public function edit($id)
    {
        $editid = $id;
        $title = "Xodimni o'zgartirish";
        $user = User::find($editid);

        // $this->authorize('edit', User::class);
        $this->authorize('viewAny', User::class);
        $state = null;
        $cities = null;
        if ($user->role != 'admin') {
            $position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
            if (!empty($position)) {
                if ($position->position == 'district') {
                    $state = DB::table('tbl_states')->get()->toArray();
                    $cities = DB::table('tbl_cities')->get()->toArray();
                } elseif ($position->position == 'country') {
                    $state = DB::table('tbl_states')->where(function ($query) use ($user) {
                        foreach (explode(',', $user->state_id) as $city) {
                            $query->orWhere('tbl_states.id', '=', $city);
                        }
                    })->get()->toArray();
                    $cities = DB::table('tbl_cities')->where('id', '=', $user->city_id)->get()->toArray();
                } elseif ($position->position == 'region') {
                    $state = DB::table('tbl_states')->where('id', '=', $user->state_id)->get()->toArray();
                    $cities = DB::table('tbl_cities')->where('id', $user->city_id)->get()->toArray();
                }
            }
        }
        $country = DB::table('tbl_countries')->get()->toArray();

        $position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
        $roles = DB::table('tbl_accessrights')->where('status', '=', 'active')->get()->toArray();
        return view('employee.edit', compact('country', 'state', 'cities', 'user', 'editid', 'roles', 'position', 'title'));
    }


    // employee update

    public function update($id, Request $request)
    {
        // $this->authorize('edit', User::class);
        $this->authorize('viewAny', User::class);

        $firstname = $request->input('firstname');
        $email = $request->input('email');
        $password = $request->input('password');

        if (getDateFormat() == 'm-d-Y') {
            $dob = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('dob'))));
        } else {
            $dob = date('Y-m-d', strtotime($request->input('dob')));
        }
        $userold = DB::table('users')->where('id', '=', $id)->get()->first();
        if ($userold->role == 'admin') {
            $role = 'admin';
        } else {
            $role = $request->input('role');
        }
        $user = User::find($id);
        $user->name = $firstname;
        $user->lastname = $request->input('lastname');
        $user->display_name = $request->input('displayname');
        $user->gender = $request->input('gender');
        $user->birth_date = join('-', array_reverse(explode('-', $request->input('dob'))));
        $user->email = $email;
        $user->api_token = $user->api_token??auth()->user()->createToken('authToken')->accessToken;
        if (!empty($password)) {
            $user->password = bcrypt($password);
        }
        $user->mobile_no = $request->input('mobile');
        $user->address = $request->input('address');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $request->file('image')->extension();
            $file->move(public_path() . '/employee/', $filename);
            if (!is_null($user->image)) {
                $oldImagePath = public_path() . '/employee/' . $user->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $user->image = $filename;
        } else {
            $user->image = $user->image;
        }
        $user->role = $role;
        if ($request->input('role') >= 90) {
            $user->branch_id = \App\Models\User::BRANCH_LABORATORY;
        }
        $user->save();

        $userA = Auth::user();
        $active = new tbl_activities;
        $active->ip_adress = $_SERVER['REMOTE_ADDR'];
        $active->user_id = $userA->id;
        $active->action_id = $id;
        $active->action_type = 'user_edit';
        $active->action = "Foydalanuvchi O'zgartrildi";
        $active->time = date('Y-m-d H:i:s');
        $active->save();
        if (auth()->user()->role == "admin") {
            return redirect('/employee/list')->with('message', 'Successfully Updated');
        }
        return $this->showemployer($user->id ?? null)->with('message', 'Successfully Updated');
    }

    public function showemployer($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('view', User::class);

        return view('employee.show', compact('user'));
    }

    public function destory($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('edit', User::class);

        $active = new tbl_activities;
        $active->ip_adress = $_SERVER['REMOTE_ADDR'];
        $active->user_id = auth()->id();
        $active->action_id = $id;
        $active->action_type = 'user_deleted';
        $active->action = "Inspektor O'chirildi";
        $active->time = date('Y-m-d H:i:s');
        $active->save();
        if ($user->image) {
            $oldImagePath = public_path('employee/' . $user->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $user->delete();

        return redirect('employee/list')->with('message', 'Successfully Deleted');
    }
}
