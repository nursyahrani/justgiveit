<?php

use yii\db\Migration;

class m160822_092011_post_give_table_notification_table_bid_vote extends Migration
{
    public function up()
    {
        $this->execute(""
                . " 
            CREATE TABLE notification_type(
                notification_type_name varchar(255) not null primary key,
                url_template varchar(255) not null,
                created_at int not null,
                updated_at int not null
            );


            Create table notification_verb(
                notification_verb_name varchar(255) not null,
                notification_type_name varchar(255) not null,
                text_template varchar(255) not null,
                text_template_two_people varchar(255) null,
                text_template_more_than_two_people varchar(255) null,
                created_at int not null,
                updated_at int not null,
                primary key(notification_verb_name, notification_type_name),
                foreign key (notification_type_name) references notification_type(notification_type_name)
            );

            Create table notification(
                notification_id int not null primary key auto_increment,
                notification_type_name varchar(255) not null,
                notification_verb_name varchar(255) not null,
                url_key_value varchar(255) not null,
                UNIQUE(notification_type_name, notification_verb_name, url_key_value),
                foreign key(notification_verb_name, notification_type_name) references notification_verb(notification_verb_name, notification_type_name)
            );

            Create table notification_receiver(
                notification_id int not null,
                receiver_id int not null,
                is_read tinyint not null default 0,
                created_at int not null,
                updated_at int not null,
                primary key(notification_id, receiver_id),
                foreign key(notification_id) references notification(notification_id),
                foreign key(receiver_id) references user(id)
            );

            CREATE INDEX get_extra_value_from_notification on notification(notification_type_name, url_key_value);

            Create table notification_actor(
                notification_id int not null,
                actor_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(notification_id, actor_id),
                FOREIGN key(notification_id) REFERENCES  notification(notification_id),
                FOREIGN key(actor_id) REFERENCES  user(id)
            );

            Create table notification_extra_value(
                notification_type_name varchar(255) not null,
                url_key_value varchar(255) not null,
                extra_value varchar(255) not null,
                created_at int not null,
                updated_at int not null,
                primary key(notification_type_name, url_key_value),
                foreign key(notification_type_name, url_key_value) references notification(notification_type_name,url_key_value)
            );
");
                

    }

    public function down()
    {
        echo "m160822_092011_post_give_table_notification_table_bid_vote cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
