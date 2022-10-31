<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;

class Change_PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('change_password', [
            'title' => 'Ganti Password'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required:min:6'
        ]);

        $user = User::find(auth()->user()->id);

        if (Hash::check($request->old_password, $user->password)) {

            $user->update([
                'password' =>  Hash::make($request->new_password)
            ]);
            Helper::createLogs('Ubah password.');
            return back()->with(['success' => 'Berhasil merubah password.']);
        } else {
            return back()->with(['fail' => 'Password lama salah.']);
        }
    }
}
