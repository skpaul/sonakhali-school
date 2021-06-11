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
$sessionBase = new SessionBase($db,$dateTime,60);
try {
    $sessionBase->continue("6065cd13815273.06190183");
    
} catch (\Exception $th) {
    exit($th->getMessage());
}
// echo $sessionBase->getSessionId();

// $array = array("issuccess"=>false, "message"=>"hi");
// $sessionBase->setJsonObject("first", $array);
$sessionBase->setString("test", "test value");
$kk = $sessionBase->getString("test");

echo $kk;
var_dump($kk);
?>