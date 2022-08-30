<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Image;
use Illuminate\Support\Facades\File;
use Validator;
use Gate;
use Auth;
use Hash;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('email', '<>', '')->select('name', 'email')->get();
    }

    public function index_districts()
    {
        $total = User::count();

        $centro     = round(100*User::where('district','Centro')->count()/$total,1);
        $este       = round(100*User::where('district','Este')->count()/$total,1);
        $costa      = round(100*User::where('district','La costa')->count()/$total,1);
        $norte      = round(100*User::where('district','Norte')->count()/$total,1);
        $noreste    = round(100*User::where('district','Noreste')->count()/$total,1);
        $noroeste   = round(100*User::where('district','Noroeste')->count()/$total,1);
        $oeste      = round(100*User::where('district','Oeste')->count()/$total,1);
        $suroeste   = round(100*User::where('district','Suroeste')->count()/$total,1);
        $sin_datos  = round(100*User::where('district','')->count()/$total,1);

        return json_encode(array( ["label"=> 'Centro', "value" => $centro],
                                  ["label"=> 'Este', "value" => $este],
                                  ["label"=> 'La costa', "value" => $costa],
                                  ["label"=> 'Norte', "value" => $norte],
                                  ["label"=> 'Noreste', "value" => $noreste],
                                  ["label"=> 'Noroeste', "value" => $noroeste],
                                  ["label"=> 'Oeste', "value" => $oeste],
                                  ["label"=> 'Suroeste', "value" => $suroeste],
                                  ["label"=> 'Sin datos', "value" => $sin_datos]));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users/show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('users/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('edit_profile', $id)) {
            abort(403, 'No autorizado');
        }

        $validation = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'email'     => 'unique:users,email,'.$id.'|email|required|max:255',
            'avatar'    => 'image|max:500'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->get('district')){
            $user->district = $request->get('district');
        }

        // Change avatar 
        if($request->hasFile('avatar')){
            $avatar     = $request->file('avatar');
            $filename   = $user->id . '.' . $avatar->getClientOriginalExtension();
            $path       = '/uploads/avatars/' . $filename;
            Image::make($avatar)->resize(200,200)->save( public_path($path));

            $user->avatar = $path;
        }

        $user->save();

        return redirect()->back()
            ->with('alert', 'Los cambios han sido guardados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getChangePassword(){
        return view('users.change-password');
    }

    public function postChangePassword(Request $request){
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->get('current_password'), $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'La contraseña actual introducida es incorrecta'
                ]);
        }

        $user->password = bcrypt($request->get('new_password'));

        $user->save();

        return redirect()->route('user', $user->id)->with('alert', 'La contraseña ha sido cambiada con éxito');
    }

    public function ban($id){

        $user = User::findOrFail($id);

        return view('users/ban', compact('user'));
    }

    public function putban(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'ban_reason' => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }
        $user = User::findOrFail($id);
        $user->ban_reason = $request->get('ban_reason');
        $user->save();

        Mail::send('emails/banned', compact('user'), function($m) use ($user){
            $m->to($user->email, $user->name)->subject('Has sido suspendido');
        });

        return redirect()->route('user', $user->id)->with('alert', 'El usuario ha sido suspendido');
    }

    public function unban($id){

        $user = User::findOrFail($id);

        $user->ban_reason = null;

        $user->save();

        Mail::send('emails/unbanned', compact('user'), function($m) use ($user){
            $m->to($user->email, $user->name)->subject('Se ha levantado tu suspensión');
        });

        return redirect()->route('user', $user->id)->with('alert', 'Se ha quitado la suspensión al usuario');
    }

    public function getCreate(){
        return view('users/create');
    }

    public function postCreate(Request $request){

        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'role'      => 'required',
            'password'  => 'required|confirmed|min:6'
        ]);

        $user = new User;
        
        $user->name             = $request->get('name');
        $user->email            = $request->get('email');
        $user->role            = $request->get('role');
        $user->password         = bcrypt($request->get('password'));

        $user->save();

        return redirect()->route('user', $user->id)->with('alert', 'Usuario creado con éxito');
    }
}
