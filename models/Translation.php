<?php

namespace humhub\modules\translationManager\models;

use Yii;

/**
 * This is the model class for table "translation_manager_translation".
 *
 * @property int $id
 * @property string $original
 * @property string $translation
 * @property string $language_code
 * @property string $module_id
 * @property string $category_id
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translation_manager_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['original', 'translation'], 'safe'],
            [['module_id', 'category_id'], 'string', 'max' => 100],
            [['language_code'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'original' => Yii::t('TranslationManagerModule.base', 'Original translation'),
            'translation' => Yii::t('TranslationManagerModule.base', 'New translation')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
        ];
    }

}
