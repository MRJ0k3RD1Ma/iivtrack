<?php
namespace backend\components;

use Yii;

class JwtValidationData extends \sizeg\jwt\JwtValidationData {
    /**
     * @inheritdoc
     */
    public function init() {
        $jwtParams = [
            'issuer' => 'https://bestit.uz/api',  //name of your project (for information only)
            'audience' => 'https://bestit.uz',  //description of the audience, eg. the website using the authentication (for info only)
            'id' => 'sdfwersdfwer',  //a unique identifier for the JWT, typically a random string
            'expire' => 1000,  //the short-lived JWT token is here set to expire after 5 min.
        ];
        $this->validationData->setIssuer($jwtParams['issuer']);
        $this->validationData->setAudience($jwtParams['audience']);
        $this->validationData->setId($jwtParams['id']);

        parent::init();
    }
}