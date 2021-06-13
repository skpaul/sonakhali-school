<?php 
    require_once("../../Required.php");

    Required::SwiftLogger()
    ->SessionBase()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Validable()
    ->ImageFile() ;

    $logger = new SwiftLogger(ROOT_DIRECTORY, false);
    $endecrytor = new EnDecryptor();
    $db = new ZeroSQL();
    $db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
    $db->connect();

    $form = new Validable();
    
    $datetime = new SwiftDatetime();
    $now = $datetime->now()->asYmdHis();
    $registration = $db->new("registration");
    try {
       
       
        $registration->name= strtoupper($form->label("Name")->httpPost("name")->required()->asString(true)->maxLength(50)->validate());
        $registration->fatherName= strtoupper($form->label("Father Name")->httpPost("fatherName")->required()->asString(true)->maxLength(50)->validate());
        $registration->motherName= strtoupper($form->label("Mother Name")->httpPost("motherName")->required()->asString(true)->maxLength(50)->validate());
        $registration->gender= $form->label("Gender")->httpPost("gender")->required()->asString(false)->maxLength(10)->validate();
        $dob= $form->label("Date of Birth")->httpPost("dob")->required()->asDate()->validate();
        $registration->dob = $datetime->value($dob)->asYmd();
        $registration->contactNo= $form->label("Contact No")->httpPost("contactNo")->required()->asMobile()->validate();
        $registration->email= $form->label("Email")->httpPost("email")->optional()->asEmail()->maxLength(50)->default(NULL)->validate();
     
        $registration->admissionClass= $form->label("Admission Class")->httpPost("admissionClass")->required()->asString(true)->maxLength(10)->validate();
        $registration->admissionYear= $form->label("Admission Year")->httpPost("admissionYear")->required()->asInteger(false)->maxLength(4)->validate();
       
        $registration->presentVillage= $form->label("Present Village")->httpPost("presentVillage")->asString(true)->maxLength(50)->default(NULL)->validate();
        $registration->presentGpo = $form->label("Present GPO Post Code")->httpPost("presentGpo")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->presentDist = $form->label("Present District")->httpPost("presentDist")->required()->asString(true)->maxLength(50)->validate();
        $registration->presentThana = $form->label("Present Thana")->httpPost("presentThana")->required()->asString(true)->maxLength(50)->validate();
       
        $registration->permanentVillage= $form->label("Permanent Village")->httpPost("permanentVillage")->required()->asString(true)->maxLength(50)->validate();
        $registration->permanentGpo= $form->label("Permanent GPO Post Code")->httpPost("permanentGpo")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->permanentDist= $form->label("Permanent District")->httpPost("permanentDist")->required()->asString(true)->maxLength(50)->validate();
        $registration->permanentThana= $form->label("Permanent Thana")->httpPost("permanentThana")->required()->asString(true)->maxLength(50)->validate();
       
        $registration->occupation= $form->label("Occupation")->httpPost("occupation")->optional()->asString(true)->maxLength(20)->default(NULL)->validate();
        $registration->orgName= $form->label("Organization Name")->httpPost("orgName")->optional()->asString(true)->maxLength(100)->default(NULL)->validate();
        $registration->orgDist= $form->label("Organization District")->httpPost("orgDist")->optional()->asString(true)->maxLength(50)->default(NULL)->validate();
        $registration->orgThana= $form->label("Organization Thana")->httpPost("orgThana")->optional()->asString(true)->maxLength(50)->default(NULL)->validate();

        $registration->sscYear= $form->label("S.S.C Year")->httpPost("sscYear")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->sscInst= $form->label("S.S.C Institute")->httpPost("sscInst")->asString(true)->maxLength(100)->default(NULL)->validate();
        $registration->hscYear= $form->label("H.S.C Year")->httpPost("hscYear")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->hscInst= $form->label("H.S.C Institute")->httpPost("hscInst")->asString(true)->maxLength(100)->default(NULL)->validate();
        $registration->gradYear= $form->label("Graduation Year")->httpPost("gradYear")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->gradInst= $form->label("Graduation Institute")->httpPost("gradInst")->asString(true)->maxLength(100)->default(NULL)->validate();
        $registration->mastersYear= $form->label("Masters Year")->httpPost("mastersYear")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->mastersInst= $form->label("Masters Institute")->httpPost("mastersInst")->asString(true)->maxLength(100)->default(NULL)->validate();
        $registration->dropOutClass= $form->label("Drop-out Class")->httpPost("dropOutClass")->asString(true)->maxLength(10)->default(NULL)->validate();
        $registration->dropOutYear= $form->label("Drop-out Year")->httpPost("dropOutYear")->asInteger(false)->maxLength(4)->default(NULL)->validate();
        $registration->feeAmount= $form->label("Fee Amount")->httpPost("feeAmount")->required()->asFloat(false)->maxLength(7)->default(NULL)->validate();
        $paymentDate= $form->label("Payment Date")->httpPost("paymentDate")->required()->asDate()->validate();
        $registration->paymentDate = $datetime->value($paymentDate)->asYmd();

        $registration->schoolBkashNo= $form->label("School bKash No.")->httpPost("schoolBkashNo")->required()->asMobile()->validate();
        $registration->senderBkashNo= $form->label("Sender bKash No.")->httpPost("senderBkashNo")->required()->asMobile()->validate();
        $registration->appliedDatetime= $datetime->now()->asYmdHis();
       
        $registration->password= $form->label("Password")->httpPost("password")->required()->asString(true)->maxLength(10)->validate();

        $confirmPassword= $form->label("Confirm Password")->httpPost("confirmPassword")->required()->asString(true)->maxLength(10)->validate();

        if($confirmPassword !== $registration->password)
        throw new ValidableException("Password did not match");

    } catch (\ValidableException $ve) {
        // print_r($cinfo);
        $json = SwiftJSON::failure($ve->getMessage()); die($json);
    }

//zahiskpo_sonakhali (user and db)
//Sonakhali$2021@School
    //Photo and signature ------>
    try {
        ImageFile::validate("ApplicantPhoto", "Applicant Photo" ,300,300,100);

        //NOTE-------------->
        //If the form has edit option, then the following code is required.
        // if($_FILES['ApplicantPhoto']['name'] != "") {
        //     ImageFile::validate("ApplicantPhoto",300,300,100);
        // }
        // if($_FILES['ApplicantSignature']['name'] != "") {
        //     ImageFile::validate("ApplicantSignature",300,80,100);
        // }
        //<-----------------NOTE


        $photoDirectory = ROOT_DIRECTORY . "/applicant-images/photos";
        if (!file_exists($photoDirectory)) {
            mkdir($photoDirectory, 0777, true);
        }
    } catch (\Exception $exp) {
        $json = SwiftJSON::failure($exp->getMessage());
        die($json);
    }
    //<---------- photo and signature

    try{
        $registration->id = $db->insert($registration)->execute();

        $photoPath = $photoDirectory . "/" . $cinfo->userId . '.jpg';
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
        ImageFile:: save("ApplicantPhoto", "Applicant's photo" ,$photoPath);
    }
    catch (\Exception $exp) {
        $logger->createLog($exp->getMessage());
        $json = SwiftJSON::failure("Problem in saving data. Please try again.");
        die($json);
    }

    $encId = $endecrytor->encrypt($registration->id);
    $url = BASE_URL . "/reunion-2021/registration/preview.php?id=$encId" ;

    exit('{"issuccess":true, "redirecturl":"'. $url .'"}');
?>