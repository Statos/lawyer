<?php

use yii\db\Migration;


class m240225_031517_alter_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'avatar_id', 'int(11) DEFAULT NULL');
        $this->addColumn('user', 'phone', 'varchar(64) NOT NULL');
        $this->addColumn('user', 'fio', 'tinytext NOT NULL');
        $this->addColumn('user', 'online_at', 'timestamp NULL DEFAULT NULL');

        $this->addForeignKey('fk_avatar_id',
            'user',
            'avatar_id',
            'data_attachments',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_avatar_id', 'user');

        $this->dropColumn('user', 'online_at');
        $this->dropColumn('user', 'fio');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'avatar_id');
    }

}
