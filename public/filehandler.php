<?php
error_log('001');
require_once '../vendor/autoload.php';
error_log('002');
$symfonySession = new \Symfony\Component\HttpFoundation\Session\Session($app['session.storage']);
error_log('003');
//$symfonySession->has('someVariable');
header('Content-type: application/octet-stream');
header('Content-Disposition: inline; filename="'.basename(urlencode($file['name'])).'"');
readfile($dir.basename($file['filename']));
exit;