<?php

namespace humhub\modules\translationManager\permissions;

use humhub\modules\admin\components\BaseAdminPermission;
use Yii;

/**
 * ManageModules Permission allows access to module section within the admin area.
 *
 * @since 1.2
 */
class ManageTranslations extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_translations';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'translation-manager';

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = Yii::t('TranslationManagerModule.permissions', 'Manage Translations');
        $this->description = Yii::t('TranslationManagerModule.permissions', 'Can manage translations within the \'Administration ->  Translations\' section.');
    }

}
