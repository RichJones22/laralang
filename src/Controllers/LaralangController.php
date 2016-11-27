<?php

namespace Premise\Laralang\Controllers;

use Premise\Laralang\Models\DB_Translation;
use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;

/**
 * Class LaralangController
 * @package Premise\Laralang\Controllers
 */
class LaralangController extends Controller
{
    /**
     * @return mixed
     */
    public function showLogin()
    {
        if (session('laralang.password') && Crypt::decrypt(session('laralang.password')) == config('laralang.default.password')) {
            return redirect(Route('laralang::translations'));
        }

        return view('laralang::login');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        session(['laralang.password' => Crypt::encrypt($request->input('password'))]);
        if (Crypt::decrypt(session('laralang.password')) != config('laralang.default.password')) {
            return redirect(Route('laralang::login'))
            ->with('status', 'Invalid password');
        }

        return redirect(Route('laralang::translations'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $request->session()->forget('laralang.password');

        return redirect(Route('laralang::login'));
    }

    /**
     * @return mixed
     */
    public function showTranslations()
    {
        return view('laralang::translations');
    }

    /**
     * @return mixed
     */
    public function api()
    {
        return DB_Translation::all();
    }

    /**
     * @param Request $request
     */
    public function deleteTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->delete();
    }

    /**
     * @return mixed
     */
    public function deleteTranslationsAll()
    {
        $trans = DB_Translation::all();

        \DB::transaction(function () use ($trans) {
            foreach($trans as $tran)
            {
                $tran->delete();
            }
        });

        return redirect(Route('laralang::translations'));
    }

    /**
     * @param Request $request
     */
    public function editTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->string = $request->string;
        $trans->to_lang = $request->to;
        $trans->from_lang = $request->from;
        $trans->translation = $request->translation;
        $trans->touch();
        $trans->save();
    }
}
