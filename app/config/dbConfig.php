<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
if(count($url)>1){
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
}else{
   $server = "localhost";
$username = "root";
$password = "";
$db = "webonise"; 
}
define('DB_READ_HOST', $server);
define('DB_READ_USER', $username);
define('DB_READ_PASSWORD', $password);
define('DB_READ_NAME', $db);




define('DB_WRITE_HOST', $server);
define('DB_WRITE_USER', $username);
define('DB_WRITE_PASSWORD', $password);
define('DB_WRITE_NAME', $db);
