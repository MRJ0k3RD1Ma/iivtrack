<?php

namespace backend\components;

use backend\models\User;
use Firebase\JWT\Key;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Firebase\JWT\JWT as JWT;

class JwtCom extends Component
{
    public string $key;
    public function init()
    {
        parent::init();
        if ($this->key === null) {
            throw new InvalidConfigException("The 'key' property must be set.");
        }
    }

    public function generateToken(array $payload, int $expiry = 86400): string
    {
        $token = JWT::encode($payload, $this->key,'HS256');
        $per = User::findOne(['id'=>$payload['id']]);
        $per->access_token = $token;
        $per->save(false);
        return $token;
    }

    public function validateToken(string $token): bool
    {
        try {
            JWT::$leeway = 86400;
            JWT::decode($token, new Key($this->key, 'HS256'));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function decodeToken(string $token): object
    {
        return JWT::decode($token, new Key($this->key, 'HS256'));
    }
}