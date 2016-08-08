<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use  App\User;

use Image;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        ]);
        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        Auth::login($user);
        return redirect()->route('profile', ['user' => $user->id])->with(['message' => 'You have signed up']);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function signin()
    {
        return view('users.signin');
    }

    public function signinprocess(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->route('profile', ['user' => Auth::user()->id])->with(['message' => 'You have signed in']);
        }
        return redirect()->back()->with(['message' => 'Invalid data']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome')->with(['message' => 'You have logged out']);
    }

    public function uploadimage(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save(public_path('/uploads/avatars/' . $filename));
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
            return redirect()->route('profile', ['user' => $user->id])->with(['message' => 'Profile image changed']);
        }
        else {
            return redirect()->back()->with(['message' => 'No file selected']);
        }
    }
}
