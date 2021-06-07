<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class AuthController extends Controller
{
    public function changePassword(Request $request)
    {
        $input = $request->all();

        $user = auth()->user();

        if (!Hash::check($input['old_password'], $user->password)) {
            return response()->json([
                'message' => 'password lama salah input'
            ],400);
        }


        if ($input['new_password'] != $input['confirm_password']) {
            return response()->json([
                'message' => 'password baru tidak sama dengan konfirmasi password'
            ],400);
        }


        DB::beginTransaction();
        try {
            $user->password = Hash::make($input['confirm_password']);
            $user->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'password berhasil diubah'
            ],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'terjadi kesalahan pada sistem'
            ],500);
        }
    }
}
