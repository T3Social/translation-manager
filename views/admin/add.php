<?php
/* @var $this \humhub\modules\ui\view\components\View */
/* @var $translationSearch TranslationSearch */

/* @var $hits array */


use humhub\modules\translationManager\models\Translation;
use humhub\modules\translationManager\models\TranslationSearch;
use humhub\modules\translationManager\widgets\AdminMenu;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('TranslationManagerModule.base', '<strong>Translation</strong> Manager'); ?></div>
        <?= AdminMenu::widget([]); ?>
        <div class="panel-body">

            <h4><?= Yii::t('TranslationManagerModule.base', 'Search') ?></h4>
            <div class="help-block">
                <?= Yii::t('TranslationManagerModule.base', 'Use the field below to search the translation files for the phrase you want to overwrite.'); ?>
            </div>

            <?php $form = ActiveForm::begin([]); ?>

            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($translationSearch, 'key'); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($translationSearch, 'language_code')->dropDownList(Yii::$app->params['availableLanguages']); ?>
                </div>
            </div>
            <br/>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('TranslationManagerModule.base', 'Search'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php if ($hits !== null): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('TranslationManagerModule.base', '<strong>Search </strong> Results'); ?></div>
        <div class="panel-body">
            <?php if (empty($hits)): ?>
                <div class="alert alert-danger">
                    <strong><?= Yii::t('TranslationManagerModule.base', 'No results found!'); ?></strong><br/>
                    <?= Yii::t('TranslationManagerModule.base', 'Please check your input or try to search for a phrase only.'); ?>
                </div>
            <?php else: ?>
                <div class="grid-view">
                    <table class="table table-hover table-responsive">
                        <tbody>
                        <tr>
                            <th class="text-left"
                                style="width:70px"><?= Yii::t('TranslationManagerModule.base', 'Module<br/>Category'); ?></th>
                            <th><?= Yii::t('TranslationManagerModule.base', 'Original'); ?></th>
                            <th><?= Yii::t('TranslationManagerModule.base', 'Translation'); ?></th>
                            <th style="width:70px">&nbsp;</th>
                        </tr>
                        <?php foreach ($hits as $hit): ?>
                            <?php
                            $translation = Translation::find()
                                ->where(['category_id' => $hit['categoryId'], 'module_id' => $hit['moduleId'], 'language_code' => $hit['languageCode']])
                                ->andWhere('BINARY [[original]]=:binary_original', ['binary_original' => $hit['original']])
                                ->one();
                            ?>

                            <tr class="<?php if ($translation !== null): ?>alert-warning<?php endif; ?>">
                                <td class="text-left">
                                    <small><?= $hit['moduleId']; ?><br/><?= $hit['categoryId']; ?></small>
                                </td>
                                <td><?= $hit['original']; ?></td>
                                <td>
                                    <?php if ($hit['translation'] === ''): ?>
                                        <span style="color:red"><?= Yii::t('TranslationManagerModule.base', 'Missing'); ?></span>
                                    <?php elseif ($hit['translation'] === null): ?>
                                        <span style="color:red"><?= Yii::t('TranslationManagerModule.base', 'Not available'); ?></span>
                                    <?php else: ?>
                                        <?= $hit['translation']; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($translation === null) : ?>
                                        <?= Html::a('<i class="fa fa-exchange" aria-hidden="true"></i>', ['edit',
                                            'Translation[original]' => $hit['original'],
                                            'Translation[translation]' => $hit['translation'],
                                            'Translation[category_id]' => $hit['categoryId'],
                                            'Translation[module_id]' => $hit['moduleId'],
                                            'Translation[language_code]' => $hit['languageCode'],
                                        ], ['class' => 'btn btn-success']); ?>
                                    <?php else: ?>
                                        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['edit',
                                            'id' => $translation->id,
                                        ], ['class' => 'btn btn-success']); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>