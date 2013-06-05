<?php
$conf = parse_ini_file ("../config");
$response = file_get_contents($conf['downloader_path']);
echo $response;
?>
