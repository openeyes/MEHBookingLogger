<?php

class m140409_145428_add_decision_date extends CDbMigration
{
	public function up()
	{
		$this->addColumn('mehbookinglogger_log', 'decision_date', 'date after action');
	}

	public function down()
	{
		$this->dropColumn('mehbookinglogger_log', 'decision_date');
	}
}
