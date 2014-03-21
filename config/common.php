<?php

return array(
	'import' => array(
		'application.modules.mehbookinglogger.components.*',
	),
	'components' => array(
		'event' => array(
			'observers' => array(
				'OphTrOperationbooking_booking_after_save' => array(
					array(
						'class' => 'BookingObserver',
						'method' => 'bookingAfterSave',
					),
				),
			),
		),
	),
);
