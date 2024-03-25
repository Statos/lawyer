<?php

use yii\db\Migration;

class m240221_173814_tables extends Migration
{

    public function safeUp()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `data_attachments` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `model_class` varchar(32) NOT NULL,
          `model_id` int(11) DEFAULT NULL,
          `type` varchar(10) DEFAULT NULL,
          `default` int(11) DEFAULT '0',
          `attachment` text NOT NULL,
          `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `belongs_index` (`model_id`)
        ) ENGINE=InnoDB");

        $this->execute("CREATE TABLE IF NOT EXISTS `data_comments` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `pid` int(11) DEFAULT NULL,
          `model_class` varchar(32) NOT NULL,
          `model_id` int(11) NOT NULL,
          `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `ctype` int(11) NOT NULL,
          `state` int(11) DEFAULT NULL,
          `title` text,
          `txt` text NOT NULL,
          `attachment` varchar(256) DEFAULT NULL,
          `likes` int(11) DEFAULT NULL,
          `user_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `FK_data_comments_users` (`user_id`),
          CONSTRAINT `FK_data_comments_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB");

        $this->execute("CREATE TABLE IF NOT EXISTS `insurance` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `name` varchar(128) NOT NULL,
          `description` text NOT NULL,
          `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `max_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `FK_insurance_users` (`user_id`),
          CONSTRAINT `FK_insurance_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB");

        $this->execute("CREATE TABLE IF NOT EXISTS `law` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `number` text NOT NULL,
          `name` text NOT NULL,
          `description` text NOT NULL,
          `publicate_at` date NOT NULL,
          `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB");

        $this->execute("CREATE TABLE IF NOT EXISTS `notifications` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(10) NOT NULL,
          `message` text NOT NULL,
          `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0',
          `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `FK_notifications_users` (`user_id`),
          CONSTRAINT `FK_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB");

        $this->execute("CREATE TABLE IF NOT EXISTS `work` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `name` varchar(128) NOT NULL,
          `description` text,
          `insurance_id` int(11) DEFAULT NULL,
          `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `done_at` timestamp NULL DEFAULT NULL,
          `max_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `FK_work_users` (`user_id`),
          KEY `FK_work_insurance` (`insurance_id`),
          CONSTRAINT `FK_work_insurance` FOREIGN KEY (`insurance_id`) REFERENCES `insurance` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
          CONSTRAINT `FK_work_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB");
    }

    public function safeDown()
    {
        $this->dropTable('work');
        $this->dropTable('notifications');
        $this->dropTable('law');
        $this->dropTable('insurance');
        $this->dropTable('data_comments');
        $this->dropTable('data_attachments');
    }
}
