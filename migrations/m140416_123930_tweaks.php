<?php

class m140416_123930_tweaks extends OEMigration
{
	public function up()
	{
		$this->renameColumn('mehbookinglogger_log', 'hos_num', 'x_cn');
		$this->alterColumn('mehbookinglogger_log', 'log_date', 'datetime NOT NULL');
		$this->alterColumn('mehbookinglogger_log', 'admission_time', 'time');

		$this->createTable(
			'mehbookinglogger_site_code',
			array(
				'site_id' => 'int unsigned not null primary key',
				'pas_code' => 'varchar(85) not null',
				'last_modified_user_id' => 'int unsigned not null default 1',
				'last_modified_date' => 'datetime not null default "1901-01-01 00:00:00"',
				'created_user_id' => 'int unsigned not null default 1',
				'created_date' => 'datetime not null default "1901-01-01 00:00:00"',
				'constraint mehbookinglogger_site_code_site_id_fk foreign key (site_id) references site (id)',
				"constraint mehbookinglogger_site_code_lmui_fk foreign key (last_modified_user_id) references user (id)",
				"constraint mehbookinglogger_site_code_cui_fk foreign key (created_user_id) references user (id)",
			)
		);
		$this->initialiseData(Yii::getPathOfAlias('MEHBookingLogger.migrations'));
	}

	public function down()
	{
		$this->dropTable('mehbookinglogger_site_code');

		$this->alterColumn('mehbookinglogger_log', 'admission_time', 'time NOT NULL');
		$this->alterColumn('mehbookinglogger_log', 'log_date', 'timestamp NOT NULL');
		$this->renameColumn('mehbookinglogger_log', 'x_cn', 'hos_num');
	}
}
