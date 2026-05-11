<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffOnly
{
    /**
     * Handle an incoming request.
     * Restrict to Admin and Petugas roles only.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role;
        
        if ($role !== 'admin' && $role !== 'petugas') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk melakukan tindakan ini.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini. Hanya Admin dan Petugas yang diperbolehkan.');
        }

        return $next($request);
    }
}
