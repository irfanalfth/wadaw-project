
<?php

function is_logged_in()
{
	$CI = &get_instance();

	$user = $CI->session->userdata('username');

	if (!isset($user)) {
		return false;
	} else {
		return true;
	}
}

function rupiah($rp)
{
	return 'Rp. ' . number_format($rp, 0, ",", ".");
}

function toNumber($rp)
{
	return preg_replace('/[^0-9]/', '', $rp);
}

function searchInArray($key, $array)
{
	if (array_key_exists($key, $array)) {
		return $array[$key];
	} else {
		return null;
	}
}

function convertPostArray($array)
{
	$outputArray = [];

	foreach ($array as $key => $values) {
		foreach ($values as $index => $value) {
			if ($key === "harga") {
				$value = toNumber($value);
			}
			$outputArray[$index][$key] = $value;
		}
	}

	return $outputArray;
}
