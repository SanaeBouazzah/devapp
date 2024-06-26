<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Mail\ProfileMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function __construct()
  {
     $this->middleware('guest')->except(['index', 'edit', 'show', 'store', 'update', 'destroy']);
  }
  public function index()
  {
    $profiles =  Profile::orderBy('created_at', 'desc')->get();
    return view('profiles.index', compact('profiles'));
  }
  public function show(string $id, Request $request)
  {
    $prefix = 'profile_'.$id;
    $profile = Cache::remember($prefix, 10, function () use ($id) {
      return Profile::findOrFail($id);
    });
    $compteur = $request->session()->increment('compteur');
    return view('profiles.show', compact('profile', 'compteur'));
  }
  public function create()
  {
    return view('profiles.create');
  }
  public function store(ProfileRequest $request)
  {
    $name =  $request->name;
    $data = $request->validated();
    $data['password'] = Hash::make($request->password);
    if (($request->file('image')) !== NULL) {
      $data['image'] = Storage::disk('public')->put('images', $request->file('image'));
    }
    Profile::create($data);
    return redirect()->route('login.index')->with('message', 'You Can Now Log In ' . $name . '!!!');
  }
  public function edit(Profile $profile)
  {
    return view('profiles.edit', compact('profile'));
  }
  public function update(ProfileRequest $request, Profile $profile)
  {
    $name =  $request->name;
    $data = $request->validated();
    $data['password'] = Hash::make($request->password);
    if (($request->file('image')) !== NULL) {
      $data['image'] = Storage::disk('public')->put('images', $request->file('image'));
    }
    $profile->fill($data)->save();
    return redirect()->route('profiles.index')->with('message', 'You Updated Your Informations Successfully ' . $name . '!!!');
  }
  public function destroy(Profile $profile)
  {
    $profile->delete();
    return redirect()->route('profiles.index')->with('message', 'You Have Deleted Profile Succefully!!!');
  }
}
