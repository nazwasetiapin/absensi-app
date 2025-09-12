<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
{
    $userRole = auth()->user()->role;

    // Konversi nama peran menjadi angka
    $roleMap = [
        'admin'    => 1,
        'karyawan' => 2,
        'pkl'      => 3,
    ];

    $allowedRoles = collect($roles)->map(function ($role) use ($roleMap) {
        return is_numeric($role) ? (int)$role : ($roleMap[$role] ?? null);
    })->filter()->toArray();

    if (in_array($userRole, $allowedRoles)) {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}

}
