<?php

namespace humhub\modules\translationManager\models;

use humhub\modules\translationManager\TranslationHelper;
use Yii;
use yii\base\Model;

/**
 * @property string $key
 */
class TranslationSearch extends Model
{
    public $key;
    public $language_code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'safe'],
            [['language_code'], 'string', 'max' => 10],
            [['key', 'language_code'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('TranslationManagerModule.base', 'Keyword'),
            'language_code' => Yii::t('TranslationManagerModule.base', 'Language'),
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


    public function search()
    {
        $hits = [];

        $lang = $this->language_code;
        if (strpos($this->language_code, 'en') !== false) {
            $lang = 'de';
        }

        foreach (TranslationHelper::getMessages($lang) as $moduleId => $categories) {
            foreach ($categories as $categoryId => $messages) {
                foreach ($messages as $original => $translated) {

                    if (mb_stripos($original, $this->key) !== false || mb_stripos($translated, $this->key) !== false) {

                        $hits[] = [
                            'original' => $original,
                            'translation' => (strpos($this->language_code, 'en') === false) ? $translated : $original,
                            'categoryId' => $categoryId,
                            'moduleId' => $moduleId,
                            'languageCode' => $this->language_code,
                        ];
                    }
                }
            }

        }

        return $hits;
    }
}