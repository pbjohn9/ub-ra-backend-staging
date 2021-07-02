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