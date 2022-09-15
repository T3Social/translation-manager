<?php

/* @var $model \humhub\modules\custom_pages\models\forms\AddPageForm */
/* @var $target \humhub\modules\custom_pages\models\Target */
/* @var $subNav string */

/* @var $pageType string */

use humhub\modules\translationManager\widgets\AdminMenu;
use humhub\modules\translationManager\models\Translation;
use humhub\modules\translationManager\TranslationHelper;
use humhub\libs\Html;

?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('TranslationManagerModule.base', '<strong>Translation</strong> Manager'); ?></div>
    <?= AdminMenu::widget([]); ?>
    <div class="panel-body">

        <div class="pull-right">
            <?= Html::a('Add new overwrite', ['/translation-manager/admin/add'], ['class' => 'btn btn-success']); ?>
        </div>

        <h4><?= Yii::t('TranslationManagerModule.base', 'Overview') ?></h4>
        <div class="help-block">
            <?= Yii::t('TranslationManagerModule.base', 'The list displays an overview of all individually created translations. To contribute to our official language translation, please use our HumHub translation community at: https://translate.humhub.org'); ?>
        </div>

        <div class="grid-view">
            <table class="table table-hover table-responsive">
                <tbody>
                <tr>
                    <th><?= Yii::t('TranslationManagerModule.base', 'Original (English)'); ?></th>
                    <th><?= Yii::t('TranslationManagerModule.base', 'New'); ?></th>
                    <th><?= Yii::t('TranslationManagerModule.base', 'Language Code'); ?></th>
                    <th>
                        <?= Yii::t('TranslationManagerModule.base', 'Module'); ?><br/>
                        <?= Yii::t('TranslationManagerModule.base', 'Category'); ?>
                    </th>
                    <th>&nbsp;</th>
                </tr>

                <?php
                $messages = TranslationHelper::getMessages('de');
                ?>

                <?php foreach (Translation::find()->all() as $translation): ?>
                    <?php
                    $inUse = isset($messages[$translation->module_id][$translation->category_id]) &&
                        // Use array_key_exists() instead of isset() because value may be NULL for string from table fields(not from lang file):
                        array_key_exists($translation->original, $messages[$translation->module_id][$translation->category_id]);
                    ?>

                    <tr>
                        <td>
                            <?php if (!$inUse): ?>
                            <strike><?php endif; ?><?= $translation->original; ?><?php if (!$inUse): ?></strike><?php endif; ?>
                        </td>
                        <td><?= $translation->translation; ?></td>
                        <td><?= $translation->language_code; ?></td>
                        <td><small><?= $translation->module_id; ?><br/><?= $translation->category_id; ?></small></td>
                        <td><?= \yii\helpers\Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['edit',
                                'id' => $translation->id
                            ], ['class' => 'btn btn-primary']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>


    </div>
</div>