<?php

namespace appbiz\local\local_modules\Site\controllers;

use appbiz\local\local_modules\AppbizController;
use Yii;

class ErrorController extends AppbizController
{
    public function actionIndex(){
        return [
            'code'    => 400,
            'message' => 'Api path error',
            'data'    => [],
        ];
    }

    public function actionTest(){
        $param = Yii::$app->params;
        return [
            'code'    => 200,
            'message' => 'message',
            'data'    => $param,
        ];
    }

    public function actionSms(){
        $param = ['mobile' => '13289288516', 'code' => '2266'];
        $response = Yii::$service->sms->sendMobileVerificationCode($param);

        return [
            'code'    => 200,
            'message' => 'message',
            'data'    => $response,
        ];
    }
}
