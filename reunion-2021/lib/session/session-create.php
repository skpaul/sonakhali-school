<?php
require_once("Required.php");

Required::SwiftLogger()
    ->SwiftDatetime()
    ->ZeroSQL(2)
    ->EnDecryptor()
    ->SwiftJSON()
    ->Helpers()->Validable()->SessionBase();

$logger = new SwiftLogger(ROOT_DIRECTORY,true);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();
$dateTime = new SwiftDatetime();
$sessionBase = new SessionBase($db,$dateTime);
$sessionId = $sessionBase->start("skpaul")->getSessionId();
echo $sessionId;
?>