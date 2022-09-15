<?php

/* @var $model AllowedLanguages */

use humhub\modules\translationManager\models\AllowedLanguages;
use humhub\modules\translationManager\widgets\AdminMenu;
use humhub\libs\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('TranslationManagerModule.base', '<strong>Translation</strong> Manager'); ?></div>
    <?= AdminMenu::widget([]); ?>
    <div class="panel-body">

        <?php if (Yii::$app->getSession()->hasFlash('language-warnings')): ?>
        <div class="alert alert-warning">
            <ul>
                <?php foreach (Yii::$app->getSession()->getFlash('language-warnings') as $languageWarning): ?>
                <li><?= $languageWarning; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <input type="button" class="check btn btn-primary pull-right btn-sm" value="<?= Yii::t('TranslationManagerModule.base', 'Toggle checkboxes') ?>"/>

        <h4><?= Yii::t('TranslationManagerModule.base', 'Enabled languages') ?></h4>
        <div class="help-block">
            <?= Yii::t('TranslationManagerModule.base', 'On this page you can choose which languages are enabled for your users.'); ?>
        </div>


        <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'enableAjaxValidation' => false]); ?>

        <?= $form->field($model, 'allowedLanguages')->checkboxList(Yii::$app->params['availableLanguages'])->label(false); ?>

        <br/>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>

<script>
    $(document).ready(function () {
        $c = true;
        $('.check').click(function () {
            if ($c) {
                $('input:checkbox').attr('checked', 'checked');
                $c = false;
            } else {
                $('input:checkbox').removeAttr('checked');
                $c = true;
            }
        });
    })
</script>
