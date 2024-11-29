<?php

namespace App\Http\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;
use phpseclib3\Crypt\RSA;
use phpseclib3\Math\BigInteger;

class DecodeJwt
{


    public static function getPublicKey($user)
    {
        $cacheKey = $user . '-public-key';
        $publicKey = Cache::get($cacheKey);
        if ( $publicKey !== null) {
            return $publicKey;
        } else {
            $key = RSA::loadPublicKey(file_get_contents(storage_path('oauth-public.key')));
            $publicKey = $key->toString('PKCS8');
            Cache::put($cacheKey, $publicKey, now()->addDays(10));
            return $publicKey;
        }
    }



    /**
     * @throws \Exception
     */
    public static function decode (string $jwt, mixed $user): \stdClass
    {
        try{
            return JWT::decode($jwt, new Key(self::getPublicKey($user), 'RS256'));
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(),502);
        }
    }
}
