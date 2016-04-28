<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * Cron controller
 */
class CronController extends ActiveController {
  public $modelClass = 'app\models\Postinfo';

      public function actions()
      {
          $actions = parent::actions();
          // 注销系统自带的实现方法
          unset($actions['index'],$actions['cron']);
          return $actions;
      }

    public function actionIndex() {
        echo "cron service runnning";
    }

     public function actionCleanredis() {

            Yii::$app->cache->flush();

            $themes = Yii::$app->db->createCommand('SELECT `id`, `pacname` as `packageName` ,`version`,`version_in`,`title`,`zip_source` as `downloadUrl`,`zip_name`,`theme_url` as `previewImageUrl`,`status` FROM `postinfo` ')->queryAll();
            $themes_new = array();
            if($themes != null){
                foreach($themes as $theme){
                    $id = $theme['id'];
                    unset($theme['id']);
                    Yii::$app->cache->set("theme".$id,json_encode($theme));

                     $themes_new[] = $theme;
                }
                 unset($themes['id']);
                 Yii::$app->cache->set("themes",json_encode($themes_new));
            }

             echo "reset redis data ok";
        }

}