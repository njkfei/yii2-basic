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
        public function actionList()
        {
                   $theme = Yii::$app->cache->get("themes");

                   if($theme==false){
                       $theme = Yii::$app->db->createCommand('SELECT `order_id` as id, `pacname` as `packageName` ,`version`,`title`,`zip_source` as `downloadUrl`,`theme_url` as `previewImageUrl`  FROM `postinfo` where `status`=1 and `order_id`<>65535 ORDER BY `id` ASC')->queryAll();

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
    public function actionItem($id = 1)
    {

               $theme = Yii::$app->cache->get("theme".$id);

               if($theme==false){
                   $theme = Yii::$app->db->createCommand('SELECT `order_id` as `id`, `pacname` as `packageName` ,`version`,`title`,`zip_source` as `downloadUrl`,`theme_url` as `previewImageUrl` FROM postinfo where  `status`=1 and  `order_id` = ' .$id)->queryOne();

                   Yii::$app->cache->set("theme".$id,json_encode($theme));

                   return $theme;
               }

               return json_decode($theme);
    }

    public function actionItems($startid=0,$count=9)
    {
        $themes = Yii::$app->cache->get("theme".$startid."s".$count);

        if($themes==false){
            $themes = Yii::$app->db->createCommand('SELECT `order_id` as `id`,`pacname` as `packageName` ,`version`,`title`,`zip_source` as `downloadUrl`,`theme_url` as `previewImageUrl` FROM postinfo where  `status`=1 and  `order_id`<>65535 and  `order_id` >= ' .$startid ."  ORDER BY `id` ASC " ." limit ".$count)->queryAll();

            Yii::$app->cache->set("theme".$startid."s".$count,json_encode($themes));

            return $themes;
        }

        return json_decode($themes);
    }
}
