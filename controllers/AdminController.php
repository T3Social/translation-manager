<?php

namespace humhub\modules\translationManager\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\translationManager\models\AllowedLanguages;
use humhub\modules\translationManager\models\Translation;
use humhub\modules\translationManager\models\TranslationSearch;
use humhub\modules\translationManager\permissions\ManageTranslations;
use Yii;

class AdminController extends Controller
{
    /**
     * @return array the access permissions
     * @see AccessControl
     */
    public function getAccessRules()
    {
        return [
            ['permission' => ManageTranslations::class]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        $model = new TranslationSearch();

        $hits = null;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $hits = $model->search();
        }

        return $this->render('add', ['translationSearch' => $model, 'hits' => $hits]);
    }

    public function actionEdit()
    {
        $model = new Translation();

        if (!empty(Yii::$app->request->get('id'))) {
            $model = Translation::findOne(['id' => Yii::$app->request->get('id')]);
        }

        $model->load(Yii::$app->request->get());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('translationOverwrites');

            $this->view->saved();
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['translation' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Translation::findOne(['id' => $id]);
        $model->delete();

        Yii::$app->cache->delete('translationOverwrites');

        $this->view->saved();
        return $this->redirect(['index']);
    }

    public function actionLanguages()
    {
        $model = new AllowedLanguages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
            return $this->redirect(['index']);
        }

        return $this->render('languages', ['model' => $model]);
    }
}