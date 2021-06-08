<?php 
    require_once("Required.php");

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

    //Session has postId in all situations. 
    $post = $db->select()->from("post_configurations")->find(1);
    if(!$post->isActive) die(SwiftJSON::failure('Application is not available.'));
    
    
    //Check the datetime limitations------>
    $now = new DateTime("now", new DateTimeZone("Asia/Dhaka"));
    $now = $now->format('Y-m-d H:i:s');
    
    $applicationStart = $datetime->input($post->applicationStartDatetime)->asObject();
    $applicationEnd = $datetime->input($post->applicationEndDatetime)->asObject();
    $currentDatetime = $datetime->now()->asObject();
    if($currentDatetime < $applicationStart)
        die(SwiftJSON::failure('Application submission will start at '. $datetime->input($applicationStart)->ashis() .' on ' . $datetime->input($applicationStart)->asdmY(). '.'));

    if($currentDatetime > $applicationEnd)
        die(SwiftJSON::failure('Last date of submission expired at '. $datetime->input($applicationEnd)->ashis() .' on ' . $datetime->input($applicationEnd)->asdmY(). '.'));


    try {
        $regYear= $form->label("Registration Year")->httpPost("regYear")->required()->asString(false)->maxLength(4)->validate();
        $regNo= $form->label("Registration No.")->httpPost("regNo")->required()->asString(false)->maxLength(100)->validate();
        
    } catch (\ValidableException $ve) {
        $error = $json->fail()->message($ve->getMessage())->create(); // SwiftJSON::failure($ve->getMessage()); 
        die($error);
    }
    
    

    try{
        $user= $db->select()->from("hc_written_registered_cinfo")
        ->where("regYear")->equalTo($regYear)
        ->andWhere("regNo")->equalTo($regNo)
        ->singleOrNull();
        // if(!$post->isActive) die(SwiftJSON::failure('Application is not available.'));
        if($user == null){
            die(SwiftJSON::failure('Registration not found.'));
        }
        
        try {
            $contractDate = $datetime->value($user->contractDate)->asObject();
            $compareDate = $datetime->createDate(2021,6,1)->asObject();
            $difference = AgeCalculator::calculate($contractDate, $compareDate);
           
            $diffMessage = "Contract must be within 5 years.<br> As of 01-06-2021, your contract has been ". $difference->years ." years ". $difference->months ." months ". $difference->days ." days.";

            if($difference->years > 5){
                die(SwiftJSON::failure($diffMessage));
            }
    
            if($difference->years == 5){
                if($difference->months > 0){
                    die(SwiftJSON::failure($diffMessage));
                }
                else{
                    if($difference->days > 0){
                        die(SwiftJSON::failure($diffMessage));
                    }
                }
            }




        } catch (\Exception $exp) {
            die(SwiftJSON::failure('Invalid contract date.'));
        }
       
    
        $session = new SessionBase($db, $datetime);
        $userDetails = array("regYear"=>$user->regYear, "regNo"=>$user->regNo);
        $session->start($user->regYear.$user->regNo);

        $session->setJsonObject("userDetails", $userDetails);
        $sessionId = $session->getSessionId();
        $sessionId = $endecrytor->encrypt($sessionId);
    }
    catch (\Exception $exp) {
        $logger->createLog($exp->getMessage());
        $json = SwiftJSON::failure("Problem found. Please try again.");
        die($json);
    }
    
    $url = BASE_URL . "/court-higher/written/application-form/written-exam-application-form.php?u=$sessionId";

    exit('{"issuccess":true, "redirecturl":"'. $url .'"}');
?>