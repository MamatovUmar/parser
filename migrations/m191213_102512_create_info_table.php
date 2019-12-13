<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%info}}`.
 */
class m191213_102512_create_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%info}}', [
            'id' => $this->primaryKey(),
            'nameRu' => $this->string()->notNull(),
            'iinBin' => $this->bigInteger()->notNull(),
            'totalArrear' => $this->decimal(10, 2)->notNull(),
            'totalTaxArrear' => $this->decimal(10, 2)->notNull(),
            'pensionContributionArrear' => $this->decimal(10, 2)->notNull(),
            'socialContributionArrear' => $this->decimal(10, 2)->notNull(),
            'socialHealthInsuranceArrear' => $this->decimal(10, 2)->notNull(),
            'sendTime' => $this->bigInteger(),
            'taxOrgInfo' => $this->text(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%info}}');
    }
}
