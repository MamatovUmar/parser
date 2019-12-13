<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.12.2019
 * Time: 11:51
 */

namespace app\models;


use yii\base\Model;
use yii\httpclient\Client;
use yii\helpers\Json;

class Parser extends Model
{
    const API_KEY = "66f5fa58da14ec11bf8082004e0a82e4";
    const UID = "b98cc94a-30c1-4de4-af5b-c10fe4a41a90";
    const T = "36233ab4-876e-4ca0-a8cc-36b77bf68a05";

    private function getCaptchaText(){
        $api = new ImageToText();
        $api->setVerboseMode(true);

        $api->setKey(self::API_KEY);
        $api->setFile("http://kgd.gov.kz/apps/services/CaptchaWeb/generate?uid=". self::UID ."&t=" . self::T);
        if (!$api->createTask()) {
            return false;
        }
        if (!$api->waitForResult()) {
            return [
                'status' => 'error',
                'message' => $api->getErrorMessage()
            ];
        } else {
            return [
                'status' => 'success',
                'captchaText' => $api->getTaskSolution()
            ];
        }
    }

    public function getClientInfo($iinBin){

        $res = $this->getCaptchaText();

        if($res['status'] == 'success'){

            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setFormat(Client::FORMAT_JSON)
                ->setUrl('http://kgd.gov.kz/apps/services/culs-taxarrear-search-web/rest/search')
                ->setData([
                    "captcha-id"=> self::UID ."&t=" . self::T,
                    "captcha-user-value" => $res['captchaText'],
                    "iinBin" => $iinBin
                ])
                ->send();

            $content = Json::decode($response->content);

            if ($response->isOk) {
                if(isset($content['captchaError'])){
                    return [
                        'status' => 'error',
                        'message' => $content['captchaError']
                    ];
                }

                return [
                    'status' => 'success',
                    'data' => Json::decode($response->content)
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Неопознанная ошибка'
            ];

        }else{
            return $res;
        }

    }

}