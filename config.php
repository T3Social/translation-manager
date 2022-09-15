<?php

/** @noinspection MissedFieldInspection */

use humhub\modules\admin\widgets\AdminMenu;
use yii\base\Application;

return [
    'id' => 'translation-manager',
    'class' => 'humhub\modules\translationManager\Module',
    'namespace' => 'humhub\modules\translationManager',
    'events' => [
        [AdminMenu::class, AdminMenu::EVENT_INIT, ['humhub\modules\translationManager\Events', 'onAdminMenuInit']],
        [Application::class, Application::EVENT_BEFORE_REQUEST, ['humhub\modules\translationManager\Events', 'onBeforeApplicationRequest']]
    ]
];
?>