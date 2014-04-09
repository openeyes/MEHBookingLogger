<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * Class MEHBookingLogger_Log
 *
 * @property string $log_date
 * @property string $hos_num
 * @property string $action
 * @property string $admission_date
 * @property string $admission_time
 * @property string $consultant_code
 * @property string $subspecialty_code
 * @property string $ward_code
 * @property string $site_code
 * @property string $theatre_code

 */
class MEHBookingLogger_Log extends CActiveRecord
{
	/**
	 * @param string $class_name
	 * @return CActiveRecord
	 */
	public static function model($class_name=__CLASS__)
	{
		return parent::model($class_name);
	}

	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'mehbookinglogger_log';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('hos_num, action, decision_date, admission_date, admission_time, consultant_code, subspecialty_code, ward_code, site_code, theatre_code', 'required'),
			array('id, log_date, hos_num, action, decision_date, admission_date, admission_time, consultant_code, subspecialty_code, ward_code, site_code, theatre_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return string
	 */
	public function serialise()
	{
		$doc = new DOMDocument;
		$event = $doc->createElement('event');

		$action_map = array(
			'added' => 'C',
			'removed' => 'X',
			'changed' => 'M',
		);

		$attrs = array(
			'hos_num' => $this->hos_num,
			'idate' => $this->admission_date,
			'itime' => $this->admission_time,
			'dec_ad' => $this->decision_date,
			'prof' => $this->consultant_code,
			'spec' => $this->subspecialty_code,
			'ward' => $this->ward_code,
			'hospital' => $this->site_code,
			'action' => $action_map[$this->action],
			'refno' => '',
		);

		foreach ($attrs as $name => $value) {
			$el = $doc->createElement($name);
			$el->appendChild($doc->createTextNode($value));
			$event->appendChild($el);
		}
		$doc->appendChild($event);

		if (YII_DEBUG) $doc->formatOutput = true;
		return $doc->saveXML();
	}
}

