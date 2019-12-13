<?php

namespace app\controllers;

use app\models\Info;
use app\models\Parser;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }


    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionInfo($iin){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax){
            $parser = new Parser();
            return $parser->getClientInfo($iin);
        }
        throw new MethodNotAllowedHttpException('405');
    }


    public function actionSaveData(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax){
            if(Yii::$app->request->isPost){

                $info = new Info();
                $res = $info->saveInfo(Yii::$app->request->post('info'));

                if($res){
                    return [
                        'status' => 'success',
                        'message' =>  'Данные соранены'
                    ];
                }

                return [
                    'status' => 'error',
                    'message' =>  $info->errors//Yii::$app->request->post()
                ];
            }
        }
        throw new MethodNotAllowedHttpException('405');
    }



}
