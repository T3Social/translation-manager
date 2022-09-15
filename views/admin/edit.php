<?php
/* @var $this \humhub\modules\ui\view\components\View */

/* @var $translation Translation */


use humhub\modules\translationManager\models\Translation;
use humhub\modules\translationManager\widgets\AdminMenu;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('TranslationManagerModule.base', '<strong>Translation</strong> Manager'); ?></div>
    <?= AdminMenu::widget([]); ?>
    <div class="panel-body">

        <h4><?= Yii::t('TranslationManagerModule.base', 'Edit translation') ?></h4>
        <div class="help-block">
            <?= Yii::t('TranslationManagerModule.base', 'Use the field below to search the translation files for the phrase you want to overwrite.'); ?>
        </div>
        
        <br />

        <?php $form = ActiveForm::begin([]); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($translation, 'language_code')->textInput(['readonly' => true]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($translation, 'module_id')->textInput(['readonly' => true]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($translation, 'category_id')->textInput(['readonly' => true]); ?>
            </div>
        </div>

        <?= $form->field($translation, 'original')->textarea(['readonly' => true]); ?>
        <?= $form->field($translation, 'translation')->textarea(); ?>

        <br/>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
            <div class="pull-right">
                <?php if (!$translation->isNewRecord): ?>
                    <?= Html::a(Yii::t('base', 'Delete'), ['/translation-manager/admin/delete', 'id' => $translation->id]); ?>
                <?php endif; ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

