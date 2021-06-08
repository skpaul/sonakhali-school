<?php 
    require_once("../../../Required.php");

    Required::SwiftLogger()
     ->SessionBase()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->JSON()
    ->Validable()
    ->AgeCalculator()
    ->ImageFile();

    $logger = new SwiftLogger(ROOT_DIRECTORY, false);
    $endecrytor = new EnDecryptor();
    $db = new ZeroSQL();
    $db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
    $db->connect();

    $form = new Validable();
    $datetime = new SwiftDatetime();
    $now = $datetime->now()->asYmdHis();
    $json = new Json();

    try {
        $regYear= $form->label("Registration Year")->httpPost("regYear")->required()->asString(false)->maxLength(4)->validate();
        $regNo= $form->label("Registration No.")->httpPost("regNo")->required()->asString(false)->maxLength(100)->validate();
        $userId= $form->label("User Id")->httpPost("userId")->required()->asString(false)->maxLength(100)->validate();
        
    } catch (\ValidableException $ve) {
        $error = $json->fail()->message($ve->getMessage())->create(); // SwiftJSON::failure($ve->getMessage()); 
        die($error);
    }
    
    

    try{
        $user= $db->select('id')->from("hc_written_cinfo")
        ->where("regYear")->equalTo($regYear)
        ->andWhere("regNo")->equalTo($regNo)
        ->andWhere("userId")->equalTo($userId)
        ->singleOrNull();
        // if(!$post->isActive) die(SwiftJSON::failure('Application is not available.'));
        if($user == null){
            die(SwiftJSON::failure('User not found.'));
        }
        

        $userId = $endecrytor->encrypt($user->id);
    }
    catch (\Exception $exp) {
        $logger->createLog($exp->getMessage());
        $json = SwiftJSON::failure("Problem found. Please try again.");
        die($json);
    }
    
    $url = BASE_URL . "/court-higher/written/application-form/preview.php?id=$userId";

    exit('{"issuccess":true, "redirecturl":"'. $url .'"}');
?>