<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\helper;
class FrontMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        
       
        $user = User::where('slug',$request->vendor)->first();
        Helper::language($user->id);
        if (@helper::appdata(@$user->id)->maintenance_mode == 1) {
            return response(view('errors.maintenance'));
        }
        $checkplan = helper::checkplan($user->id, '3');
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return response(view('errors.accountdeleted'));
        }
        if ($user->is_available == 2) {
            return response(view('errors.accountdeleted'));
        }
        return $next($request);
    }
}
