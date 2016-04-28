<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;


/**
 * PostinfoController implements the CRUD actions for Postinfo model.
 */
class PostinfoController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
        public function actionViews()
        {
                   $theme = Yii::$app->cache->get("themes");

                   if($theme==false){
                       $theme = Yii::$app->db->createCommand('SELECT `pacname` as `packageName` ,`version`,`version_in`,`title`,`zip_source` as `downloadUrl`,`zip_name`,`theme_url` as `previewImageUrl`  FROM `postinfo` ')->queryAll();

                       Yii::$app->cache->set("themes",json_encode($theme));

                       return $theme;
                   }

                   return json_decode($theme);
        }


    /**
     * @param $id
     * @return array|bool|mixed
     * demo:{
    "packageName": "com.kkkeyboard.emoji.keyboard.theme.Paris",
    "title": "aaa",
    "downloadUrl": "https://s3-ap-northeast-1.amazonaws.com/demo.mav/zip/zip/com.kkkeyboard.emoji.keyboard.theme.RainbowLove.zip",
    "previewImageUrl": "https://s3-ap-northeast-1.amazonaws.com/demo.mav/pic/rainbowlove.png",
    "version": " 1.52"
    }
     */
    public function actionView($id)
    {

               $theme = Yii::$app->cache->get("theme".$id);

               if($theme==false){
                   $theme = Yii::$app->db->createCommand('SELECT `pacname` as `packageName` ,`version`,`version_in`,`title`,`zip_source` as `downloadUrl`,`zip_name`,`theme_url` as `previewImageUrl` FROM postinfo where id = ' .$id)->queryOne();

                   Yii::$app->cache->set("theme".$id,json_encode($theme));

                   return $theme;
               }

               return json_decode($theme);
    }
}
