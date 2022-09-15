<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\translationManager;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer === null) {
            return [
                new permissions\ManageTranslations(),
            ];
        }
        return [];
    }
}
