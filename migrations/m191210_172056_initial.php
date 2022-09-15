<?php

use yii\db\Migration;

/**
 * Class m191210_172056_initial
 */
class m191210_172056_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('translation_manager_translation', [
           'id' => $this->primaryKey(),
            'original' => $this->text()->notNull(),
            'translation' => $this->text()->notNull(),
            'language_code' => $this->string(10)->notNull(),
            'module_id' => $this->string(100),
            'category_id' => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191210_172056_initial cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191210_172056_initial cannot be reverted.\n";

        return false;
    }
    */
}
