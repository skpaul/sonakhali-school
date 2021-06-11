<?php 
require_once("../../Required.php");


Required::SwiftLogger()->ZeroSQL(2)->SwiftJSON()->Validable()->Helpers();

$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();
  
$district = $_GET["district"];
$query= $db->select("thana_name")->from("thanas")->where("district_name")->equalTo($district)->orderBy("thana_name");
$thanas = $query->toList();
$thanaas = json_encode($thanas);
$db->close();
echo '{"issuccess":true,"data":'. $thanaas .'}';
exit;
?>
