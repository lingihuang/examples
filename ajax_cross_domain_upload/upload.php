<?php

$timestamp = $_GET["timestamp"];
$key = "file_" . $timestamp;

// Check if this is an AJAX request.
if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]))
{
	die();
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_FILES["file_input"]["name"];
	$size = $_FILES["file_input"]["size"];
	$type = $_FILES["file_input"]["type"];
	$tmp_name = $_FILES["file_input"]["tmp_name"];

	$_SESSION[$key] = array(
		"name" => $name,
		"size" => $size,
		"type" => $type,
	);
}
else
{
	$callback = $_GET["callback"];

	if ($_SESSION[$key])
	{
		$response = array(
			"status" => "ok",
			"file"   => $_SESSION[$key],
		);
	}
	else {
		$response = array(
			"status" => "failed",
			"file"   => array(),
		);
	}
	unset($_SESSION[$key]);

	if ($callback)
	{
		header("Content-type: application/javascript");
		echo $callback . "(" . json_encode($response) . ")";
	}
	else
	{
		header("Content-type: application/json");
		echo json_encode($response);
	}
}

?>