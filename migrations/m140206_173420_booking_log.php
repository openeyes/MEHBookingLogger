<?php

class m140206_173420_booking_log extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'booking_log',
			array(
				'log_date' => 'timestamp not null',
				'hos_num' => 'varchar(85) not null',
				'action' => 'varchar(85) not null',
				'admission_date' => 'date not null',
				'admission_time' => 'time not null',
				'consultant_code' => 'varchar(85) not null',
				'subspecialty_code' => 'varchar(85) not null',
				'ward_code' => 'varchar(85) not null',
				'site_code' => 'varchar(85) not null',
				'theatre_code' => 'varchar(85) not null',
			),
			'engine=InnoDB charset=utf8 collate=utf8_bin'
		);
	}

	public function down()
	{
		$this->dropTable('booking_log');
	}
}
