<?php


namespace humhub\modules\translationManager;


use Yii;

class TranslationHelper
{
    /**
     * Config array to append additional translatable messages from database tables:
     *      [$moduleId][$categoryId][
     *          'model' => $modelActiveRecordClassName,
     *          'attributes' => $arrayOrStringOfAttributes
     *      ]
     *
     * @var array[][]
     */
    protected static $dbSources = [
        'user' => [
            'profile_field' => [
                'model' => '\humhub\modules\user\models\ProfileField',
                'attributes' => ['title', 'description'],
            ],
            'profile_field_category' => [
                'model' => '\humhub\modules\user\models\ProfileFieldCategory',
                'attributes' => ['title', 'description'],
            ],
        ],
    ];

    /**
     * Get translatable message from language file and from DB tables defined in self::$dbSources
     *
     * @param string $language
     * @return array
     */
    public static function getMessages($language)
    {
        $messages = [];

        foreach (Yii::$app->moduleManager->getModules(['includeCoreModules' => true]) as $moduleId => $module) {
            $messages[$moduleId] = [];

            /** @var \humhub\components\Module $module */
            $messageDir = $module->getBasePath() . '/messages/' . $language;
            if (!is_dir($messageDir)) {
                #print $messageDir . ' not found ';
                continue;
            }

            foreach (scandir($messageDir) as $file) {
                if (!preg_match('/\.php$/', $file)) {
                    continue;
                }

                $messages[$moduleId][basename($file, '.php')] = require($messageDir . DIRECTORY_SEPARATOR . $file);
            }
        }

        return self::getMessagesFromDB($messages);
    }

    /**
     * Get translatable messages from database tables/models and append them to a provided array $messages.
     * Note: An already existing message in the provided array $messages will NOT be overriding from model attribute,
     * because model attribute always has only original source message without translation.
     *
     * @param array $messages
     * @return array
     */
    public static function getMessagesFromDB($messages = [])
    {
        foreach (self::$dbSources as $dbModuleId => $dbCategories) {
            foreach ($dbCategories as $dbCategoryId => $dbCategory) {
                /** @var \humhub\components\ActiveRecord $model */
                $model = $dbCategory['model'];
                if (!class_exists($model)) {
                    continue;
                }

                if (!isset($messages[$dbModuleId][$dbCategoryId])) {
                    $messages[$dbModuleId][$dbCategoryId] = [];
                }

                $attributeRows = $model::find()
                    ->select($dbCategory['attributes'])
                    ->asArray()
                    ->all();

                foreach ($attributeRows as $attributes) {
                    $messages[$dbModuleId][$dbCategoryId] += array_map(function () { return null; }, array_flip(array_filter($attributes)));
                }
            }
        }

        return $messages;
    }
}