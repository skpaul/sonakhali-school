<?php
require_once("../../../Required.php");

Required::SwiftLogger()
    ->ZeroSQL()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Helpers()->Validable();

$logger = new SwiftLogger(ROOT_DIRECTORY,true);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$form = new Validable();
try {
    $regNo = $form->title("Registration No.")->httpPost("regNo")->required()->asInteger(false)->maxLength(11)->validate();
    $regYear = $form->title("Registration Year")->httpPost("regYear")->required()->asInteger(false)->maxLength(4)->validate();
    $userId= $form->label("User Id")->httpPost("userId")->required()->asString(false)->maxLength(100)->validate();

    $applicant = $db->select("userId, feeAmount")->from("hc_written_cinfo")
                ->where("regNo")->equalTo($regNo)
                ->andWhere("regYear")->equalTo($regYear)
                ->andWhere("userId")->equalTo($userId)
                ->singleOrNull();

    if ($applicant === NULL) die(SwiftJSON::success("Registration no and/or Year did not match."));

    if ($applicant->fee) {
        exit(SwiftJSON::success("Payment received successfully."));
    } else {
        exit(SwiftJSON::success("Payment has not been received yet."));
    }

   
} catch (\ValidableException $exp) {
    $json = SwiftJSON::failure($exp->getMessage());
    die($json);
}
catch(\ZeroException $dbExp){
    $json = SwiftJSON::failure($dbExp->getMessage());
    die($json);
}

?>
