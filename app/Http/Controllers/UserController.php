<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
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
    public function create()
    {
        //
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
            'username' => $request->username,
            'about' => $request->about,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back();
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

                            session()->flash('passupdte', 'Your Password has been Successfully Updated');
                            return redirect()->back();

                        } else {
                            session()->flash('notmatch', 'New Password does not match');
                            return redirect()->back();
                        }


                    } else {

                        session()->flash('warning', 'You have Entered Wrong Current Password');
                        return redirect()->back();
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back();
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



                            session()->flash('passupdte', 'Your Password has been Successfully Updated');
                            return redirect()->back();

                        } else {
                            session()->flash('notmatch', 'New Password does not match');
                            return redirect()->back();
                        }


                    } else {

                        session()->flash('warning', 'You have Entered Wrong Current Password');
                        return redirect()->back();
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back();
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
    public function edit($id)
    {

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

                            session()->flash('passupdte', 'Your Password has been Successfully Updated');
                            return redirect()->back();

                        } else {
                            session()->flash('notmatch', 'New Password does not match');
                            return redirect()->back();
                        }


                    } else {

                        session()->flash('warning', 'You have Entered Wrong Current Password');
                        return redirect()->back();
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back();
            }

        }else{
            $data['photo']=$request->old_photo;
            if($oldpass){
                if(isset($oldpass)) {
                    if(Hash::check($oldpass, $password)) {

                        if ($newpass == $retypepass) {

                            $data['password'] = Hash::make($newpass);


                            $update= DB::table('users')->where('id',$id)->update($data);



                            session()->flash('passupdte', 'Your Password has been Successfully Updated');
                            return redirect()->back();

                        } else {
                            session()->flash('notmatch', 'New Password does not match');
                            return redirect()->back();
                        }


                    } else {

                        session()->flash('warning', 'You have Entered Wrong Current Password');
                        return redirect()->back();
                    }

                }


            }else{

                $update= DB::table('users')->where('id',$id)->update($data);
                return redirect()->back();
            }

        }
    }

    /**

     */
    public function destroy($id)
    {
        $delete = DB::table('users')->where('id',$id)->delete();
        return redirect()->back();
    }

}
