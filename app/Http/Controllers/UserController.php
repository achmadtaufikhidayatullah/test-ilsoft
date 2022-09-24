<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Auth;
use Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //   $user = User::whereNotNull('last_seen')->get(); 
        $user = User::all(); 
      //   dd($user);
        return view('users.index', compact('user'));
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
        $emailValidate = User::where('email' , $request->email)->first();

        if ($emailValidate != null) {
            return redirect()->route('user.index')->with('error', "Email is already exists");
        }

        // Create User
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(60);
        $user->save();

        return redirect()->route('user.index')->with('success', "Add new user is success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    { 

      //   dd($user);

        $emailValidate = User::where('email' , $request->email)->first();

        if ($emailValidate != null && $request->email != $user->email) {
            return redirect()->route('user.index')->with('error', "Email is already exists");
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.index')->with('success', "User data is updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      //   dd($user);

        if ( Cache::has('is_online' . $user->id) ) {
            return redirect()->route('user.index')->with('error', "User still online");
        }else{
            $user->delete();
        }

        return redirect()->route('user.index')->with('success', "User data is deleted");
    }

    public function apiData()
    {
         $data = User::all();

      //   return response()->json($data);
        return response()->json([
            'status' => (bool) $data,
            'message' => $data ? 'Success Hit!' : 'Failed Hit',
            'data'   => $data,
         ], 201);
    }



    public function regist(Request $request)
    {

      //   dd($request->all());
        $emailValidate = User::where('email' , $request->email)->first();

        if ($emailValidate != null) {
            return redirect()->route('regist')->with('error', "Email is already exists");
        }

        // Create User
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(60);
        $user->save();

        return redirect()->route('regist')->with('success', "Your account has been created! you can go to login page");
    }
}
