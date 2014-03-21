<?php

class BookingObserver
{
	public function bookingAfterSave(array $params)
	{
		$row = array(
			'hos_num' => $params['patient']->hos_num,
			'action' => $params['cancellation_date'] ? "removed" : ($params['new'] ? "added" : "changed"),
			'admission_date' => $params['admission_date'],
			'admission_time' => $params['admission_time'],
			'consultant_code' => $params['firm']->consultant->code,
			'subspecialty_code' => $params['firm']->subspecialty->ref_spec,
			'ward_code' => $params['ward_code'],
			'site_code' => $params['site']->remote_id,
			'theatre_code' => $params['theatre_code'],
		);

		Yii::app()->db->createCommand()->insert('booking_log', $row);
	}
}
