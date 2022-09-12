<?php

namespace App\Utils\Sign;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hyperf\Utils\Traits\StaticInstance;
use App\Exception\Sign\TokenException;

class Token
{
    use StaticInstance;

    /**
     * @var string
     */
    protected $key = 'sclecon';

    /**
     * @var string
     */
    protected $alg = 'HS256';

    public function encode(array $data) : string {
        return JWT::encode($data, $this->getKey(), $this->alg);
    }

    public function decode(string $jwt) : array {
        $number = count(explode('.', $jwt));
        if ($number !== 3) throw new TokenException('签名格式错误', 5000, 200, ['sign'=>$jwt]);
        try {
            return (array) JWT::decode($jwt, new Key($this->getKey(), $this->alg));
        } catch (\Exception $exception) {
            throw new TokenException($exception->getMessage());
        }
    }

    protected function getKey(){
        return env('JWT_KEY', $this->key);
    }
}