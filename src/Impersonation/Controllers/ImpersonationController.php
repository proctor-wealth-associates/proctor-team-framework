<?php

namespace Elegon\Impersonation\Controllers;

use Illuminate\Http\Request;
use Elegon\Foundation\Elegon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeImpersonation();
    }

    public function impersonate(Request $request, $userId)
    {
        $request->session()->flush();
        $request->session()->put('elegon:impersonator', $request->user()->getKey());

        Auth::login(Elegon::user()->findOrFail($userId));

        return redirect(config('elegon.impersonation.redirect_begins'));
    }

    public function stopImpersonating(Request $request)
    {
        $currentId = Auth::user()->getKey();

        if (! $request->session()->has('elegon:impersonator')) {
            Auth::logout();

            return redirect(config());
        }

        $userId = $request->session()->pull('elegon:impersonator');
        $request->session()->flush();

        Auth::login(Elegon::user()->findOrFail($userId));

        $redirectUrl = config('elegon.impersonation.redirect_finished');
        $redirectUrl = preg_replace('#{user}#', $currentId, $redirectUrl);

        return redirect($redirectUrl);
    }

    private function authorizeImpersonation()
    {
        $policy = config('elegon.impersonation.policy');

        if ($policy === 'dev') {
            return $this->middleware('dev')->except('stopImpersonating');
        }

        if ($policy === 'role') {
            $role = config('elegon.impersonation.role');
            return $this->middleware('role', $role)->except('stopImpersonating');
        }

        abort(500, "Impersonation Policy should be [dev] or [role].");
    }
}
