<?php

namespace App\Http\Middleware;

use App\Http\Utils\AuthTrait;
use App\Http\Utils\DecodeJwt;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\RefreshTokenRepository;
use Symfony\Component\HttpFoundation\Response;

class ValidateSso extends DecodeJwt
{
    use AuthTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Exception
     * @throws GuzzleException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = request()->user();
        $response = $next($request);
        if($user instanceof User) {
            $this->_enterAt($user);
        }
        return $response;
    }


    /**
     * @throws \Exception
     */
    protected function _enterAt (User $user):bool
    {
        if(Cache::has($user->id.'_enter_at')){
            $enterAt = Cache::get($user->id.'_enter_at');
            $now = Carbon::now();
            if($now->diffInMinutes($enterAt) > 80)
                $this->invalidatePassport($user);
            else
                return true;
        }
        return true;
    }


    /**
     * @throws \Exception
     */
    protected function invalidatePassport (User $user): void
    {
        try {
            $accessToken = Passport::token()->where('user_id', $user->id)->first();

            if (!is_null($accessToken)) {
                $accessToken->revoked = 1;
                $accessToken->save();
            }
            $client = Client::where('user_id', $user->id)->first();
            if (!is_null($client)) {
                $repository = app(ClientRepository::class);
                $repository->regenerateSecret($client);
            }

            Cache::delete($user->id.'_enter_at');

            throw new \Exception("Non autorizzato",401);
        }catch (\Exception $e){
            throw new \Exception("Impossibile rigenerare il secret code per l'utente",401);
        }
    }
}
