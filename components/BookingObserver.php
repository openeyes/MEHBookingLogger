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
 * Class BookingObserver
 */
class BookingObserver
{
	/**
	 * @param array $params
	 */
	public function bookingAfterSave(array $params)
	{
		$pas_assignment = PasAssignment::model()->findByAttributes(array('internal_type' => 'Patient', 'internal_id' => $params['patient']->id));
		if ($pas_assignment) {
			$params['x_cn'] = $pas_assignment->external_id;
		} else {
			Yii::log('No PAS assignment found for patient {$patient->id}', 'error');
			$params['x_cn'] = null;
		}

		$params['site_code'] = Yii::app()->db->createCommand()->select('pas_code')->from('mehbookinglogger_site_code')->where('site_id = ?', array($params['site']->id))->queryScalar();

		if ($params['cancellation_date']) {
			$this->log('X', $params);
		} else {
			if (!$params['new']) {
				$this->log('X', $params, false);
			}
			$this->log('C', $params);
		}
	}

	private function log($action, $params, $include_time = true)
	{
		$log = new MEHBookingLogger_Log;

		$log->attributes = array(
			'log_date' => date('Y-m-d H:i:s'),
			'x_cn' => $params['x_cn'],
			'action' => $action,
			'decision_date' => $params['decision_date'],
			'admission_date' => $params['admission_date'],
			'admission_time' => $include_time ? $params['admission_time'] : null,
			'consultant_code' => ($params['firm']) ? $params['firm']->pas_code : 'EMG',
			'subspecialty_code' => ($params['firm']) ? $params['firm']->subspecialty->ref_spec : 'EMG',
			'ward_code' => $params['ward_code'],
			'site_code' => $params['site_code'],
			'theatre_code' => $params['theatre_code'],
		);

		if(!$log->save()) {
			Yii::log('Cannot save MEHBookingLogger_Log', 'error');
		}
	}
}
