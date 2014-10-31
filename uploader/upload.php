<?php

function getFiles($fileArr)
{
	$fileKeys = array_keys($fileArr);
	$files    = array();

	for ($i = 0; $i < count($fileArr['name']); $i++)
	{
		foreach ($fileKeys as $key)
		{
			$files[$i][$key] = $fileArr[$key][$i];
		}
	}

	return $files;
}

function moveFiles($files)
{
	$isOk = true;
	foreach ($files as $file)
	{
		if (move_uploaded_file($file['tmp_name'], 'files/'. $file['name']))
		{
			
		}
		else
		{
			$isOk = false;
		}
	}
	return $isOk;
}

$files  = getFiles($_FILES['files']);
$status = moveFiles($files) ? 'ok' : 'failed';

// Check if this is an AJAX request.
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']))
{
	$response = array(
		'status' => $status
	);

	header('Content-type: application/json');
	echo json_encode($response);
}
else
{
	echo $status;
}

?>