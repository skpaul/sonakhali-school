<?php 
    require_once("../../Required.php");

    Required::SwiftLogger()
     ->SessionBase()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->JSON()
    ->Validable();

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
        $regNo= $form->label("Registration No.")->httpPost("regNo")->required()->asString(false)->maxLength(100)->validate();
        $contactNo= $form->label("Contact No")->httpPost("contactNo")->required()->asMobile()->validate();

        
    } catch (\ValidableException $ve) {
        $error = $json->fail()->message($ve->getMessage())->create(); // SwiftJSON::failure($ve->getMessage()); 
        die($error);
    }
    
    

    try{
        $registration = $db->select('id')->from("registration")
        ->where("id")->equalTo($regNo)
        ->andWhere("contactNo")->equalTo($contactNo)
        ->singleOrNull();
       
        if($registration == null){
            die(SwiftJSON::failure('Registration not found.'));
        }
        

        $id = $endecrytor->encrypt($registration->id);
    }
    catch (\Exception $exp) {
        $logger->createLog($exp->getMessage());
        $json = SwiftJSON::failure("Problem found. Please try again.");
        die($json);
    }
    
    $url = BASE_URL . "/reunion-2021/registration/preview.php?id=$id";

    exit('{"issuccess":true, "redirecturl":"'. $url .'"}');
?>