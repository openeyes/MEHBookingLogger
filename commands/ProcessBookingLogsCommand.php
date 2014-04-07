<?php
/**
 * (C) OpenEyes Foundation, 2014
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2014, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class ProcessBookingLogsCommand extends CConsoleCommand
{
	public function run($args)
	{
		if (!isset(Yii::app()->params['mehbookinglogger_tcidir'])) {
			throw new Exception("Please set the configuration parameter 'mehbookinglogger_tcidir' to the directory to write TCI files to");
		}
		$target_dir = Yii::app()->params['mehbookinglogger_tcidir'];

		while (($events = MEHBookingLogger_Log::model()->findAll(array('limit' => 128)))) {
			print "Processing " . count($events) . " events...\n";

			foreach ($events as $event) {
				file_put_contents("{$target_dir}/{$event->id}.xml", $event->serialise());
				$event->delete();
			}

			print "done\n";
		}
	}
}
