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
		$log = new MEHBookingLogger_Log();
		$log->attributes = array(
			'hos_num' => $params['patient']->hos_num,
			'action' => $params['cancellation_date'] ? "removed" : ($params['new'] ? "added" : "changed"),
			'admission_date' => $params['admission_date'],
			'admission_time' => $params['admission_time'],
			'consultant_code' => ($params['firm']->consultant) ? $params['firm']->consultant->code : '',
			'subspecialty_code' => ($params['firm']->subspecialty) ? $params['firm']->subspecialty->ref_spec : '',
			'ward_code' => $params['ward_code'],
			'site_code' => $params['site']->remote_id,
			'theatre_code' => $params['theatre_code'],
		);
		Yii::log(var_export($log,true));
		if(!$log->save()) {
			Yii::log('Cannot save MEHBookingLogger_Log', 'error');
		}
	}
}
