<?php

namespace humhub\modules\translationManager\widgets;

use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\menu\widgets\TabMenu;
use Yii;

class AdminMenu extends TabMenu
{

    public function init()
    {
        $entry = new MenuLink();
        $entry->setLabel(Yii::t('TranslationManagerModule.base', 'Overwrites'));
        $entry->setUrl(['/translation-manager/admin']);
        $entry->setIsActive((in_array(Yii::$app->controller->action->id, ['index', 'edit', 'add'])));
        $this->addEntry($entry);

        $entry = new MenuLink();
        $entry->setLabel(Yii::t('TranslationManagerModule.base', 'Languages'));
        $entry->setUrl(['/translation-manager/admin/languages']);
        $entry->setIsActive((in_array(Yii::$app->controller->action->id, ['languages'])));
        $this->addEntry($entry);

        parent::init();
    }

}
