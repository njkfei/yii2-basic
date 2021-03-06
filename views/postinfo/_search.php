<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="postinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pacname') ?>

    <?= $form->field($model, 'version') ?>

    <?= $form->field($model, 'version_in') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'zip_source') ?>

    <?php // echo $form->field($model, 'zip_name') ?>

    <?php // echo $form->field($model, 'themepic') ?>

    <?php // echo $form->field($model, 'theme_url') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
