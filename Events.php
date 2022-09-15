<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\translationManager;


use humhub\modules\translationManager\models\Translation;
use humhub\modules\translationManager\permissions\ManageTranslations;
use Yii;

class Events
{
    /**
     * @var Translation[]
     */
    private static $_translations = null;

    public static function onAdminMenuInit($event)
    {
        if (!Yii::$app->user->can(ManageTranslations::class)) {
            return;
        }

        $event->sender->addItem([
            'label' => Yii::t('TranslationManagerModule.base', 'Translations'),
            'url' => ['/translation-manager/admin'],
            'icon' => '<i class="fa fa-language"></i>',
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id === 'translation-manager'),
            'sortOrder' => 1000,
            'isVisible' => true,
        ]);
    }

    public static function onBeforeApplicationRequest($event)
    {
        static::handleOverwrites();
        static::handleAllowedLanguages();
    }


    private static function handleOverwrites()
    {
        if (static::$_translations === null || !is_array(static::$_translations)) {
            static::$_translations = Yii::$app->cache->getOrSet('translationOverwrites', function () {
                return Translation::find()->asArray()->all();
            });
        }

        $translations = static::$_translations;

        Yii::$app->i18n->beforeTranslateCallback = function ($category, $message, $params, $language) use ($translations) {
            /** @var Translation $translation */
            foreach ($translations as $translation) {
                if ($translation['original'] === $message && $translation['language_code'] === $language) {
                    //ToDo: Check Module&Category
                    return [$category, $translation['translation'], $params, $language];
                }
            }

            return [$category, $message, $params, $language];
        };
    }

    private static function handleAllowedLanguages()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('translation-manager');
        $langs = $module->settings->get('allowedLanguages');
        if (!empty($langs)) {
            Yii::$app->params['allowedLanguages'] = explode(',', $langs);
        }

    }

}