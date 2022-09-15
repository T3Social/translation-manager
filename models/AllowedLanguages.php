<?php

namespace humhub\modules\translationManager\models;

use humhub\modules\translationManager\Module;
use humhub\modules\user\models\User;
use Yii;
use yii\base\Model;

class AllowedLanguages extends Model
{

    public $allowedLanguages;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Initialize allowed/enabled languages
        $module = Yii::$app->getModule('translation-manager');
        $allowedLanguages = $module->settings->get('allowedLanguages');
        $this->allowedLanguages = empty($allowedLanguages) ? [] : explode(',', $allowedLanguages);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['allowedLanguages'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'allowedLanguages' => Yii::t('TranslationManagerModule.base', 'Languages'),
        ];
    }


    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        // Update allowed/enabled languages
        $module = Yii::$app->getModule('translation-manager');
        $module->settings->set('allowedLanguages', implode(',', $this->allowedLanguages));

        $availableLanguages = Yii::$app->params['availableLanguages'];

        // Update default language if it was changed
        $previousDefaultLanguage = Yii::$app->settings->get('defaultLanguage');
        if (!in_array($previousDefaultLanguage, $this->allowedLanguages)) {
            // Change default language to first enabled if it was disabled
            $firstAllowedLanguage = $this->allowedLanguages[0];
            Yii::$app->settings->set('defaultLanguage', $firstAllowedLanguage);

            // Inform what default language was switched
            Yii::$app->getSession()->addFlash('language-warnings', Yii::t('TranslationManagerModule.base',
                'Default language has been changed from "{previousLanguage}" to "{currentLanguage}"!', [
                'previousLanguage' => isset($availableLanguages[$previousDefaultLanguage]) ? $availableLanguages[$previousDefaultLanguage] : $previousDefaultLanguage,
                'currentLanguage' => isset($availableLanguages[$firstAllowedLanguage]) ? $availableLanguages[$firstAllowedLanguage] : $firstAllowedLanguage
            ]));
        }

        // Update language of users to default language who still use the disabled languages
        $defaultLanguage = Yii::$app->settings->get('defaultLanguage');
        $updatedUsersCount = User::updateAll(
            ['language' => $defaultLanguage],
            ['AND', 'language != ""', 'language IS NOT NULL', ['NOT IN', 'language', $this->allowedLanguages]]);
        if ($updatedUsersCount) {
            Yii::$app->getSession()->addFlash('language-warnings', Yii::t('TranslationManagerModule.base',
                'Language of {usersCount} users has been changed to default "{defaultLanguage}" because they used the disabled languages!', [
                'usersCount' => $updatedUsersCount,
                'defaultLanguage' => isset($availableLanguages[$defaultLanguage]) ? $availableLanguages[$defaultLanguage] : $defaultLanguage
            ]));
        }
    }
}
