<?php

function fullMonthYearFormat($dt)
{
	return date('F, Y', strtotime($dt));
}

function printarr($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function printarrq($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
	die();
}

function getDatesInterval($objBundle)
{
	$begin = new DateTime( $objBundle->start_date );
	$end = new DateTime( $objBundle->end_date );
	$interval = new DateInterval('P1D');
	$sale_dates = new DatePeriod($begin, $interval, $end);

	return $sale_dates;
}