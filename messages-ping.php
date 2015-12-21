<?php

header('Content-Type: application/json');

if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
	header('HTTP/1.1 304 Not Modified', TRUE, 304);
	exit();
}

echo '{ }';

exit();
