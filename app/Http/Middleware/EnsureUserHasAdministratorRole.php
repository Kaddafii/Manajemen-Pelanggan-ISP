<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdministratorRole
{
    /**
     * Memeriksa apakah pengguna yang terautentikasi memiliki peran Administrator.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authenticatedUser = $request->user();

        if (! $authenticatedUser || ! $authenticatedUser->isAdministratorRole()) {
            abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
