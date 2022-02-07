<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  DB::table('users')->simplePaginate(10);
        $edit=DB::table('users')->get();
        return view('user_list',compact('data','edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active_list()
    {
        $data =  DB::table('users')->where('status','1')->simplePaginate(10);
        $edit=DB::table('users')->get();
        return view('active_list',compact('data','edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'status' => '0',
            'username' => $request->username,
            'about' => $request->about,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('message','Data added Successfully');
    }

// Auth Profile Update
    public function profile_update(Request $request)
    {


        $id = Auth::user()->id;
        $data['name']=$request->name;
        $data['username']=$request->username;
        $data['email']=$request->email;
        $data['about']=$request->about;
        $photo= $request->hasFile('photo');
        $password = auth()->user()->password;
        $oldpass = $request->current_pass;
        $newpass = $request->new_pass;
        $retypepass = $request->conf_pass;


        if ($photo){

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.'.$extension;
            $file->move('image',$filename);
            $data['photo']=$filename;

            if($oldpass){
                if(isset($oldpass)) {
                    if(Hash::check($oldpass, $password)) {

                        if ($newpass == $retypepass) {
                            $id = Auth::user()->id;
                            $data['password'] = Hash::make($newpass);

                            $update= DB::table('users')->where('id',$id)->update($data);

                            return redirect()->back()->with('message','Data Updated Successfully');

                        } else {
                            return redirect()->back()->with('error','New Password does not match');
                        }


                    } else {

                        return redirect()->back()->with('error','You have Entered Wrong Current Password');
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back()->with('message','Data Updated Successfully');
            }

        }else{
            $data['photo']=$request->old_photo;
            if($oldpass){
                if(isset($oldpass)) {
                    if(Hash::check($oldpass, $password)) {

                        if ($newpass == $retypepass) {
                            $id = Auth::user()->id;
                            $data['password'] = Hash::make($newpass);


                            $update= DB::table('users')->where('id',$id)->update($data);



                            return redirect()->back()->with('message','Data Updated Successfully');

                        } else {
                            return redirect()->back()->with('error','New Password does not match');
                        }


                    } else {

                        return redirect()->back()->with('error','You have Entered Wrong Current Password');
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back()->with('message','Data Updated Successfully');
            }

        }

    }

    /**
     * Display the specified resource.
     *

     */
    public function show($id)
    {
        $show = DB::table('users')->where('id',$id)->first();
        return view('view_profile')->with('show',$show);;
    }

    /**
     * Show the form for editing the specified resource.
     *

     */
    public function search(Request $request)
    {

        $name=$request->name;
        $status=$request->user_status;

        $from = date('2018-01-01');
        $to = date('2018-05-02');

        $edit=DB::table('users')->get();

        if($name){
            $data =DB::table('users')->where("created_at",">", Carbon::now()->subMonths(3))->where('name',$name)->where('status',$status)->simplePaginate(10);

            return view('search_result',compact('data','edit'));
        }else{
            $data =DB::table('users')->where("created_at",">", Carbon::now()->subMonths(3))->where('status',$status)->simplePaginate(10);
        return view('search_result',compact('data','edit'));
        }

    }

    /**
     * Update the specified resource in storage.

     */
    public function update(Request $request, $id)
    {

        $pass= DB::table('users')->where('id',$id)->first();

        $data['name']=$request->name;
        $data['username']=$request->username;
        $data['email']=$request->email;
        $data['about']=$request->about;
        $data['status']=$request->status;
        $photo= $request->hasFile('photo');
        $password = $pass->password;
        $oldpass = $request->current_pass;
        $newpass = $request->new_pass;
        $retypepass = $request->conf_pass;


        if ($photo){

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.'.$extension;
            $file->move('image',$filename);
            $data['photo']=$filename;

            if($oldpass){
                if(isset($oldpass)) {
                    if(Hash::check($oldpass, $password)) {

                        if ($newpass == $retypepass) {

                            $data['password'] = Hash::make($newpass);

                            $update= DB::table('users')->where('id',$id)->update($data);

                            return redirect()->back()->with('message','Data Updated Successfully');

                        } else {
                            return redirect()->back()->with('error','New Password does not match');
                        }


                    } else {

                        return redirect()->back()->with('error','You have Entered Wrong Current Password');
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back()->with('message','Data Updated Successfully');
            }

        }else{
            $data['photo']=$request->old_photo;
            if($oldpass){
                if(isset($oldpass)) {
                    if(Hash::check($oldpass, $password)) {

                        if ($newpass == $retypepass) {

                            $data['password'] = Hash::make($newpass);


                            $update= DB::table('users')->where('id',$id)->update($data);



                            return redirect()->back()->with('message','Data Updated Successfully');

                        } else {
                            return redirect()->back()->with('error','New Password does not match');
                        }


                    } else {

                        return redirect()->back()->with('error','You have Entered Wrong Current Password');
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back()->with('message','Data Updated Successfully');
            }

        }
    }

    /**

     */
    public function destroy($id)
    {
        $delete = DB::table('users')->where('id',$id)->delete();
        return redirect()->back()->with('info','Data Deleted Successfully');
    }
    public function deleteAll(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required',
        ]);

        $ids = $request->ids;
        DB::table("users")->whereIn('id',$ids)->delete();
        return redirect()->back()->with('error','Data Deleted Successfully');
    }

}
