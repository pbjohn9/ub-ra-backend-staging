<?php

function fullMonthYearFormat($dt)
{
	return date('F, Y', strtotime($dt));
}