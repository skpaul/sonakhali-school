<?php 
    require_once("../../../Required.php");

    Required::SwiftLogger()
    ->SessionBase()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Validable()
    ->AgeCalculator()
    ->ImageFile()
    ->UniqueCode()
    ;

    $logger = new SwiftLogger(ROOT_DIRECTORY, false);
    $endecrytor = new EnDecryptor();
    $db = new ZeroSQL();
    $db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
    $db->connect();
// print_r($_POST); die();
    $form = new Validable();
    
    $datetime = new SwiftDatetime();
    $now = $datetime->now()->asYmdHis();

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

    // if($currentDatetime > $applicationEnd)
        // die(SwiftJSON::failure('Last date of submission expired at '. $datetime->input($applicationEnd)->ashis() .' on ' . $datetime->input($applicationEnd)->asdmY(). '.'));

    //<-------Check the datetime limitations
    $cinfo = $db->new("hc_written_cinfo");

    $encSessionId = $_GET["u"];
    $sessionId = $endecrytor->decrypt($encSessionId);
    $session = new SessionBase($db, $datetime);
    try {
        $session->continue($sessionId);
        $sessionUserDetails = $session->getJsonObject("userDetails");
    } catch (SessionExpiredException $exp1) {
        Helpers::redirect(BASE_URL ."/session-expired.php?reason=1",false);
    }catch (SessionNotFoundException $exp2) {
        Helpers::redirect(BASE_URL ."/session-expired.php?reason=2",false);
    }

    $registration = $db->select()->from("hc_written_registered_cinfo")
    ->where("regNo")->equalTo($sessionUserDetails->regNo)
    ->andWhere("regYear")->equalTo($sessionUserDetails->regYear)
    ->single();

    $regNo = trim($registration->regNo);
    $regYear = trim($registration->regYear);
   
   
    

    // print_r($cinfo);
    try {
     
       
        $cinfo->fullName= strtoupper($form->label("Full Name")->httpPost("fullName")->required()->asString(true)->maxLength(100)->validate());

        $cinfo->fatherName= $form->label("Father's Name")->httpPost("fatherName")->required()->asString(true)->maxLength(100)->validate();
        
        $cinfo->motherName= $form->label("Mother's Name")->httpPost("motherName")->required()->asString(true)->maxLength(100)->validate();
        $dateOfBirth= $form->label("Date of Birth")->httpPost("dob")->required()->asDate()->validate();
        $cinfo->dob = $dateOfBirth->format('Y-m-d');
        $cinfo->gender= $form->label("Gender")->httpPost("gender")->required()->asString(true)->maxLength(6)->validate();
        $cinfo->contactNo= $form->label("Contact No")->httpPost("contactNo")->required()->asString(true)->maxLength(13)->validate();
        $cinfo->email= $form->label("Email")->httpPost("email")->asString(true)->maxLength(40)->default('')->validate();
        $cinfo->nationality= $form->label("Nationality")->httpPost("nationality")->required()->asString(true)->maxLength(50)->validate();
        
        $cinfo->idType= $form->label("Id Type")->httpPost("idType")->required()->asString(true)->maxLength(30)->validate();
        $cinfo->idNo = $form->label("Id No")->httpPost("idNo")->required()->asString(true)->maxLength(50)->validate();
        if($cinfo->idNo == ''){
            $json = SwiftJSON::failure("Please enter either NID Number or Passport Number or Birth Certificate.");
            die($json) ;
        }
        
        $cinfo->presentAddress= $form->label("Present Address")->httpPost("presentAddress")->required()->asString(true)->maxLength(150)->validate();
        $cinfo->presentDist= $form->label("Present District")->httpPost("presentDist")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->presentThana= $form->label("Present Thana")->httpPost("presentThana")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->presentGpo= $form->label("Present GPO Number")->httpPost("presentGpo")->asInteger(false)->maxLength(11)->default(0)->validate();
        
        $cinfo->permanentAddress= $form->label("Permanent Address")->httpPost("permanentAddress")->required()->asString(true)->maxLength(150)->validate();
        $cinfo->permanentDist= $form->label("Permanent District")->httpPost("permanentDist")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->permanentThana= $form->label("Permanent Thana")->httpPost("permanentThana")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->permanentGpo= $form->label("Permanent GPO Number")->httpPost("permanentGpo")->asInteger(false)->maxLength(11)->default(0)->validate();
        
        $cinfo->sscExamName= $form->label("S.S.C Exam. Name")->httpPost("sscExamName")->required()->asString(true)->maxLength(50)->validate();
        $cinfo->sscRollNo= $form->label("S.S.C Roll No")->httpPost("sscRollNo")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->sscRegiNo= $form->label("S.S.C Regi No")->httpPost("sscRegiNo")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->sscYear= $form->label("S.S.C Year")->httpPost("sscYear")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->sscBoard= $form->label("S.S.C Board")->httpPost("sscBoard")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->sscResultType= $form->label("S.S.C Result Type")->httpPost("sscResultType")->required()->asString(true)->maxLength(20)->validate();

        // if(strtoupper($cinfo->sscExamName) == "O LEVEL" || strtoupper($cinfo->sscExamName) == "OTHER"){
        //     if(empty($_POST["sscGpa"]) && empty($_POST["sscGrade"])){
        //         //CHANGE
        //         $json = SwiftJSON::failure("Enter either GPA or Grade in Secondary Examination.");
        //         die($json);
        //     }
        //     $cinfo->o_level_grade= $form->label("O level grade")->httpPost("sscGrade")->required()->asString(true)->maxLength(50)->default(NULL)->validate();

        //     if(!empty($_POST["sscGpa"])){
        //         $cinfo->sscGpa= $form->label("Secondary result in gpa")->httpPost("sscGpa")->required()->asFloat(true)->minValue(0.01)->maxValue(5.00)->default(NULL)->validate();
        //     }
        // } else{

            if (strtolower($cinfo->sscResultType) == 'division') {
                if(empty($_POST["sscDivision"])){
                    $json = SwiftJSON::failure("S.S.C Division required.");
                    die($json);
                }
                $cinfo->sscDivision= $form->label("S.S.C Division")->httpPost("sscDivision")->required()->asString(true)->maxLength(20)->validate();
            } 
            
            if (strtolower($cinfo->sscResultType) == 'grade'){
                if(empty($_POST["sscGpa"])){
                    $json = SwiftJSON::failure("Enter S.S.C GPA");
                    die($json);
                }
                $cinfo->sscGpa= $form->label("S.S.C Gpa")->httpPost("sscGpa")->required()->asFloat(true)->maxLength(4)->validate();
                if(empty($_POST["sscScale"])){
                    $json = SwiftJSON::failure("Enter S.S.C Scale");
                    die($json);
                }
                $cinfo->sscScale= $form->label("S.S.C Scale")->httpPost("sscScale")->required()->asFloat(true)->maxLength(1)->validate();
                // $cinfo->sscGrade= $form->label("S.S.C Grade")->httpPost("sscGrade")->required()->asString(true)->maxLength(10)->validate();
            }        

            // $cinfo->sscGpa= $form->label("Secondary result in gpa")->httpPost("sscGpa")->required()->asFloat(true)->minValue(0.01)->maxValue(5.00)->default(NULL)->validate();
        // }

        $cinfo->sscGroup= $form->label("S.S.C Group")->httpPost("sscGroup")->required()->asString(true)->maxLength(20)->validate();

        $cinfo->hscExamName= $form->label("H.S.C Exam Name")->httpPost("hscExamName")->required()->asString(true)->maxLength(50)->validate();
        $cinfo->hscRollNo= $form->label("H.S.C Roll No")->httpPost("hscRollNo")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->hscRegiNo= $form->label("H.S.C Registration No.")->httpPost("hscRegiNo")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->hscYear= $form->label("H.S.C Year")->httpPost("hscYear")->required()->asInteger(false)->maxLength(11)->validate();
        $cinfo->hscBoard= $form->label("H.S.C Board")->httpPost("hscBoard")->required()->asString(true)->maxLength(100)->validate();
        $cinfo->hscResultType= $form->label("H.S.C ResultType")->httpPost("hscResultType")->required()->asString(true)->maxLength(20)->validate();
        if (strtolower($cinfo->hscResultType) == 'division') {
            $cinfo->hscDivision= $form->label("H.S.C Division")->httpPost("hscDivision")->required()->asString(true)->maxLength(20)->validate();
        } else if (strtolower($cinfo->hscResultType) == 'grade'){
            $cinfo->hscGpa= $form->label("H.S.C Gpa")->httpPost("hscGpa")->required()->asFloat(true)->maxLength(4)->validate();
            $cinfo->hscScale= $form->label("H.S.C Scale")->httpPost("hscScale")->required()->asFloat(true)->maxLength(1)->validate();
            // $cinfo->hscGrade= $form->label("H.S.C Grade")->httpPost("hscGrade")->required()->asString(true)->maxLength(10)->validate();
        }        
        $cinfo->hscGroup= $form->label("H.S.C Group")->httpPost("hscGroup")->required()->asString(true)->maxLength(20)->validate();

        $cinfo->regNo= $regNo;
        $cinfo->regYear= $regYear;
        $cinfo->applicantType = $form->label("Applicant Type")->httpPost("applicantType")->required()->asString(true)->maxLength(20)->validate();

        $cinfo->practiceStartDate = $form->label("Practice Start Date")->httpPost("practiceStartDate")->optional()->asDate()->default(NULL)->validate();
        $cinfo->practiceEndDate = $form->label("Practice End Date")->httpPost("practiceEndDate")->optional()->asDate()->default(NULL)->validate();



        $cinfo->barAssosiationName= $form->label("Bar Assosiation Name")->httpPost("barAssosiationName")->required()->asString(true)->maxLength(100)->validate();
        
        $cinfo->seniorAdvocateName= $form->label("Senior Advocate Name")->httpPost("seniorAdvocateName")->required()->asString(true)->maxLength(100)->validate();

        $dateOfMembership = $form->label("Date of Membership")->httpPost("dateOfMembership")->required()->asDate()->validate();


        $cinfo->session= 2021; //$form->label("Session")->httpPost("session")->required()->asInteger(false)->maxLength(11)
        
        $cinfo->appliedDatetime = $now;
        // $cinfo->appliedDatetime= $form->label("Applied Datetime")->httpPost("appliedDatetime")->required()->asDate()->default(NULL)->validate();
        // $cinfo->fee= $form->label("Fee")->httpPost("fee")->required()->asBool()->maxLength(1)->default(NULL)->validate();
        // $cinfo->screening= $form->label("Screening")->httpPost("screening")->required()->asBool()->maxLength(1)->default(NULL)->validate();
        $cinfo->hasPaidPreviously= $form->label("Paid Previously?")->httpPost("hasPaidPreviously")->asBool()->maxLength(3)->default(false)->validate();
        if($cinfo->hasPaidPreviously == "yes"){
            $cinfo->hasPaidPreviously = 1;
        } else {
            $cinfo->hasPaidPreviously = 0;
        }
        // print_r($_POST);
        if($cinfo->hasPaidPreviously){
            $paymentType = $form->label("Previous Payment Type")->httpPost("prevPaymentType")->required()->asString(true)->maxLength(30)->validate();
            $cinfo->prevPaymentType= $paymentType; //
            // $cinfo->prevPaymentDetails= $form->label("Previous Payment Details")->httpPost("prevPaymentDetails")->required()->asString(true)->maxLength(250)->validate();
            $cinfo->bankName= $form->label("Bank Name")->httpPost("bankName")->required()->asString(true)->maxLength(100)->validate();
            $cinfo->branchName= $form->label("Branch Name")->httpPost("branchName")->required()->asString(true)->maxLength(100)->validate();
            $cinfo->feeAmount= $form->label("Amount")->httpPost("feeAmount")->required()->asInteger(false)->maxLength(11)->validate();
            $cinfo->draftOrSlipNo= $form->label("Amount")->httpPost("draftOrSlipNo")->required()->asString(false)->maxLength(20)->validate();
            if($cinfo->feeAmount > 0){
                $cinfo->fee = 1;
            }
        }
    } catch (\ValidableException $ve) {
        // print_r($cinfo);
        $json = SwiftJSON::failure($ve->getMessage()); die($json);
    }
    //TODO: Must get data from configuration table
    // $ageCalculationDate = '2021-05-27'; //$post->ageCalculationDate;
    // echo json_encode($ageCalculationDate);die();
    // $age = AgeCalculator::calculate($dateOfBirth, $datetime->input($ageCalculationDate)->asObject());

    // try {
    //     // AgeCalculator::validateAge($age, $post->minimum_age, $post->maximum_age, $datetime->input($ageCalculationDate)->asObject() );
    //     AgeCalculator::validateAge($age, $post->minimumAge, 32, $datetime->input($ageCalculationDate)->asObject() );
    // } catch (\Exception $exp) {
    //     $json = SwiftJSON::failure($exp->getMessage());
    //     die($json);
    // }

    //Photo and signature ------>
    try {
        //Use this if the form does not have edit option.
        // ImageFile::validate("ApplicantPhoto",300,300,100);
        // ImageFile::validate("ApplicantSignature",300,80,100);
        if($cinfo->hasPaidPreviously){
            ImageFile::validate("paymentSlipScanCopy", "Payment Slip Scan Copy", 0, 0, 150);
        }

        ImageFile::validate("ApplicantPhoto", "Applicant Photo" ,300,300,100);
        ImageFile::validate("ApplicantSignature","Applicant signature",300,80,100);

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
        $signatureDirectory = ROOT_DIRECTORY . "/applicant-images/signatures";
        if (!file_exists($signatureDirectory)) {
            mkdir($signatureDirectory, 0777, true);
        }
       
    } catch (\Exception $exp) {
        $json = SwiftJSON::failure($exp->getMessage());
        die($json);
    }
    //<---------- photo and signature

    try{
        // 
      

        // HC Higher Education start
        // ===================
        $higherEducations = $db->new("hc_written_higher_educations");   

      

        #region LL.B
            $higherEducations->llbExam= $form->label("LL.B Exam")->httpPost("llbExam")->required()->asString(true)->maxLength(50)->default(NULL)->validate();
            $higherEducations->llbId= $form->label("LL.B ID/Roll/Regi No.")->httpPost("llbId")->required()->asString(true)->maxLength(20)->default(NULL)->validate();

            $llbCountryName = $form->label("LL.B Country Name")->httpPost("llbCountryName")->required()->asString(true)->maxLength(50)->validate();
            if($llbCountryName == "Bangladesh"){
                $higherEducations->llbCountry = "Bangladesh";
            }
            else{
                $higherEducations->llbCountry = $form->label("LL.B Country Name")->httpPost("llbOtherCountryName")->required()->asString(true)->maxLength(50)->validate();
                $hasLlbEquivalentCertificate = $form->label("LL.B Equivalent Certificate")->httpPost("hasLlbEquivalentCertificate")->required()->asString(false)->maxLength(3)->validate();
                if($hasLlbEquivalentCertificate == "no"){
                    $json = SwiftJSON::failure("LL.B Equivalent Certificate of Bar Council is required.");
                    die($json);
                }
            }

          
            $higherEducations->llbUni= $form->label("LLB. University")->httpPost("llbUni")->required()->asString(true)->maxLength(250)->default(NULL)->validate();
            
            $higherEducations->llbResultType= $form->label("LL.B Result Type")->httpPost("llbResultType")->required()->asString(true)->maxLength(10)->default(NULL)->validate();

            //Exam concluded date & Passing Year
            switch (strtolower($higherEducations->llbResultType)) {
                case 'division':
                case 'class':    
                case 'grading':           
                    $higherEducations->llbExamConcludedDate=NULL;
                    $higherEducations->llbPassingYear= $form->label("LL.B Passing Year")->httpPost("llbPassingYear")->required()->asInteger(false)->maxLength(4)->default(NULL)->validate();

                    break; //end of division, class, grading switch
                case "appeared":
                    $higherEducations->llbDivision = NULL;
                    $higherEducations->llbClass = NULL;
                    $higherEducations->llbCgpa = NULL;
                    $higherEducations->llbCgpaScale= NULL;
                    $higherEducations->llbPassingYear = NULL;
                    $higherEducations->llbTotalMarks = NULL;
                    $higherEducations->llbObtainedMarks = NULL;
                    $higherEducations->llbMarksPercentage = NULL;

                    $llbExamConcludedDate = $form->label("LL.B Exam Concluded Date")->httpPost("llbExamConcludedDate")->required()->asDate()->validate();                    

                    $ecd= $datetime->value($llbExamConcludedDate)->asObject(); 
                    if($ecd > $applicationEnd){
                        $json = SwiftJSON::failure("LL.B Examination Appeared Date Must Be Less Than " . $datetime->value($applicationEnd)->asdmY());
                        die($json);
                    }
                    $higherEducations->llbExamConcludedDate = $datetime->value($llbExamConcludedDate)->asYmd();
                    break;
                default:
                    break;
            }
        
            //Data for total marks, obtained marks & percentage of marks
            switch (strtolower($higherEducations->llbResultType)) {
                case 'division':
                case 'class':    
                    $higherEducations->llbTotalMarks = $form->label("LL.B Total Marks")->httpPost("llbTotalMarks")->required()->asInteger(false)->maxLength(4)->validate();
                    $higherEducations->llbObtainedMarks = $form->label("LL.B Obtained Marks")->httpPost("llbObtainedMarks")->required()->asInteger(false)->maxLength(4)->validate();

                    if($higherEducations->llbObtainedMarks > $higherEducations->llbTotalMarks){
                        $json = SwiftJSON::failure("LL.B obtained marks must be less than total marks."); die($json);
                    }

                    $higherEducations->llbMarksPercentage = ($higherEducations->llbObtainedMarks / $higherEducations->llbTotalMarks) * 100; 
                    break;
                case 'grading':           
                        $higherEducations->llbTotalMarks = NULL;
                        $higherEducations->llbObtainedMarks = NULL;
                        $higherEducations->llbMarksPercentage = NULL;
                    break; //end of division, class, grading switch
              
                default:
                    break;
            }
        
            //Division/Class/CGPA
            switch (strtolower($higherEducations->llbResultType)) {
                case 'division':
                    $higherEducations->llbDivision = $form->label("LL.B Division")->httpPost("llbDivision")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'class':    
                    $higherEducations->llbClass = $form->label("LL.B Class")->httpPost("llbClass")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'grading':           
                    $higherEducations->llbCgpa = $form->label("LL.B CGPA")->httpPost("llbCgpa")->required()->asFloat(false)->maxLength(4)->validate();
                    $higherEducations->llbCgpaScale = $form->label("LL.B CGPA Scale")->httpPost("llbCgpaScale")->required()->asFloat(false)->maxLength(4)->validate();

                     //(cgpa*80)/scale
                     $higherEducations->llbMarksPercentage = ($higherEducations->llbCgpa * 80)/ $higherEducations->llbCgpaScale;

                    break;
                default:
                    break;
            } // //Division/Class/CGPA ends

            $higherEducations->llbCourseDuration=  NULL; //$form->label("LL.B Course Duration")->httpPost("llbCourseDuration")->required()->asInteger(false)->maxLength(4)->validate();
        
            $higherEducations->llbGrade=  NULL; //$form->label("LL.B Grade")->httpPost("llbGrade")->required()->asString(true)->maxLength(5)->default(NULL)->validate();
        #endregion
       
        #region Graduation (Other)
            $hasOtherGrad = $form->label("Has Graduation Other")->httpPost("hasOtherGrad")->optional()->asString(false)->maxLength(12)->default(false)->validate();
            if($hasOtherGrad == "hasOtherGrad"){
                $higherEducations->hasOtherGrad = 1;
            }
            else{
                $higherEducations->hasOtherGrad = 0;
            }
          

            if($higherEducations->hasOtherGrad){
                $higherEducations->gradOtherExam= $form->label("Graduation (Other) Exam")->httpPost("gradOtherExam")->required()->asString(true)->maxLength(50)->default(NULL)->validate();
                $higherEducations->gradOtherId= $form->label("Graduation (Other) ID/Roll/Regi No.")->httpPost("gradOtherId")->required()->asString(true)->maxLength(20)->default(NULL)->validate();
               
               
                $gradOtherCountry= $form->label("Graduation (Other) Country")->httpPost("gradOtherCountryName")->required()->asString(true)->maxLength(50)->validate();
               
                if($gradOtherCountry == "Bangladesh"){
                    $higherEducations->gradOtherCountry = "Bangladesh";
                }
                else{
                    $higherEducations->gradOtherCountry = $form->label("Graduatoin (Other) Country Name")->httpPost("gradOtherOtherCountryName")->required()->asString(true)->maxLength(50)->validate();

                    $hasGradOtherEquivalentCertificate = $form->label("Graduation (Other) Equivalent Certificate")->httpPost("hasGradOtherEquivalentCertificate")->required()->asString(false)->maxLength(3)->validate();
                    if($hasGradOtherEquivalentCertificate == "no"){
                        $json = SwiftJSON::failure("Graduation (Other) Equivalent Certificate of Bar Council is required.");
                        die($json);
                    }
                }













               
                $higherEducations->gradOtherUni= $form->label("Graduation (Other) University")->httpPost("gradOtherUni")->required()->asString(true)->maxLength(250)->default(NULL)->validate();

                $higherEducations->gradOtherResultType= $form->label("Graduation (Other) Result Type")->httpPost("gradOtherResultType")->required()->asString(true)->maxLength(10)->validate();

               //Exam concluded date & Passing Year
            switch (strtolower($higherEducations->gradOtherResultType)) {
                case 'division':
                case 'class':    
                case 'grading':           
                    $higherEducations->gradOtherExamConcludedDate=NULL;
                    $higherEducations->gradOtherPassingYear= $form->label("Graduation (Other) Passing Year")->httpPost("gradOtherPassingYear")->required()->asInteger(false)->maxLength(4)->default(NULL)->validate();

                    break; //end of division, class, grading switch
                case "appeared":
                    $higherEducations->gradOtherDivision = NULL;
                    $higherEducations->gradOtherClass = NULL;
                    $higherEducations->gradOtherCgpa = NULL;
                    $higherEducations->gradOtherCgpaScale= NULL;
                    $higherEducations->gradOtherPassingYear = NULL;
                    $higherEducations->gradOtherTotalMarks = NULL;
                    $higherEducations->gradOtherObtainedMarks = NULL;
                    $higherEducations->gradOtherMarksPercentage = NULL;

                    $gradOtherExamConcludedDate = $form->label("Graduation (Other) Exam Concluded Date")->httpPost("gradOtherExamConcludedDate")->required()->asDate()->validate();

                    $ecd= $datetime->value($gradOtherExamConcludedDate)->asObject(); 
                    if($ecd > $applicationEnd){
                        $json = SwiftJSON::failure("Graduation (Other) Examination Appeared Date Must Be Less Than " . $datetime->value($applicationEnd)->asdmY());
                        die($json);
                    }
                    $higherEducations->gradOtherExamConcludedDate= $datetime->value($gradOtherExamConcludedDate)->asYmd();
                    break;
                default:
                    break;
            }
        
            //Data for total marks, obtained marks & percentage of marks
            switch (strtolower($higherEducations->gradOtherResultType)) {
                case 'division':
                case 'class':    
                    $higherEducations->gradOtherTotalMarks = $form->label("Graduation (Other) Total Marks")->httpPost("gradOtherTotalMarks")->required()->asInteger(false)->maxLength(4)->validate();
                    $higherEducations->gradOtherObtainedMarks = $form->label("Graduation (Other) Obtained Marks")->httpPost("gradOtherObtainedMarks")->required()->asInteger(false)->maxLength(4)->validate();

                    if($higherEducations->gradOtherObtainedMarks > $higherEducations->gradOtherTotalMarks){
                        $json = SwiftJSON::failure("Graduation (Other) Obtained marks must be less than total marks."); die($json);
                    }

                    $higherEducations->gradOtherMarksPercentage = ($higherEducations->gradOtherObtainedMarks / $higherEducations->gradOtherTotalMarks) * 100; 
                    break;
                case 'grading':           
                        $higherEducations->gradOtherTotalMarks = NULL;
                        $higherEducations->gradOtherObtainedMarks = NULL;
                        $higherEducations->gradOtherMarksPercentage = NULL;
                    break; //end of division, class, grading switch
              
                default:
                    break;
            }
        
            //Division/Class/CGPA
            switch (strtolower($higherEducations->gradOtherResultType)) {
                case 'division':
                    $higherEducations->gradOtherDivision = $form->label("Graduation (Other) Division")->httpPost("gradOtherDivision")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'class':    
                    $higherEducations->gradOtherClass = $form->label("Graduation (Other) Class")->httpPost("gradOtherClass")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'grading':           
                    $higherEducations->gradOtherCgpa = $form->label("Graduation (Other) CGPA")->httpPost("gradOtherCgpa")->required()->asFloat(false)->maxLength(4)->validate();
                    $higherEducations->gradOtherCgpaScale = $form->label("Graduation (Other) CGPA Scale")->httpPost("gradOtherCgpaScale")->required()->asFloat(false)->maxLength(4)->validate();

                     //(cgpa*80)/scale
                     $higherEducations->gradOtherMarksPercentage = ($higherEducations->gradOtherCgpa * 80)/ $higherEducations->gradOtherCgpaScale;

                    break;
                default:
                    break;
            } // //Division/Class/CGPA ends






















            
            
                //$higherEducations->gradOtherCourseDuration= NULL; //$form->label("Graduation (Other) Course Duration")->httpPost("gradOtherCourseDuration")->required()->asInteger(false)->maxLength(4)->validate();
            
            
                //$higherEducations->gradOtherGrade= NULL; //$form->label("gradOtherGrade")->httpPost("gradOtherGrade")->required()->asString(true)->maxLength(5)->default(NULL)->validate();

            } //if hasOtherGrad = true   
   
        #endregion

        #region Masters
            $hasMasters = $form->label("")->httpPost("hasMasters")->optional()->asString(false)->maxLength(12)->default("")->validate();
            if($hasMasters == "hasMasters"){
                $higherEducations->hasMasters= 1;
            }
            else{
                $higherEducations->hasMasters= 0;
            }
           
            if($higherEducations->hasMasters){
                $higherEducations->mastersExam= $form->label("Masters Exam")->httpPost("mastersExam")->required()->asString(true)->maxLength(50)->default(NULL)->validate();
                $higherEducations->mastersId= $form->label("Masters ID/Roll/Regi No.")->httpPost("mastersId")->required()->asString(true)->maxLength(20)->default(NULL)->validate();


                $mastersCountry = $form->label("Masters Country")->httpPost("mastersCountryName")->required()->asString(true)->maxLength(50)->default(NULL)->validate();
                if($mastersCountry == "Bangladesh"){
                    $higherEducations->mastersCountry = "Bangladesh";
                }
                else{
                    $higherEducations->mastersCountry = $form->label("Masters Degree Country Name")->httpPost("mastersOtherCountryName")->required()->asString(true)->maxLength(50)->validate();

                    $hasMastersEquivalentCertificate = $form->label("Masters Equivalent Certificate")->httpPost("hasMastersEquivalentCertificate")->required()->asString(false)->maxLength(3)->validate();
                    if($hasMastersEquivalentCertificate == "no"){
                        $json = SwiftJSON::failure("Masters Equivalent Certificate of Bar Council is required.");
                        die($json);
                    }
                }















                $higherEducations->mastersUni= $form->label("Masters University")->httpPost("mastersUni")->required()->asString(true)->maxLength(250)->default(NULL)->validate();

                $higherEducations->mastersResultType= $form->label("Masters Result Type")->httpPost("mastersResultType")->required()->asString(true)->maxLength(10)->validate();

               //Exam concluded date & Passing Year
            switch (strtolower($higherEducations->mastersResultType)) {
                case 'division':
                case 'class':    
                case 'grading':           
                    $higherEducations->mastersExamConcludedDate=NULL;
                    $higherEducations->mastersPassingYear= $form->label("Masters Passing Year")->httpPost("mastersPassingYear")->required()->asInteger(false)->maxLength(4)->default(NULL)->validate();

                    break; //end of division, class, grading switch
                case "appeared":
                    $higherEducations->mastersDivision = NULL;
                    $higherEducations->mastersClass = NULL;
                    $higherEducations->mastersCgpa = NULL;
                    $higherEducations->mastersCgpaScale= NULL;
                    $higherEducations->mastersPassingYear = NULL;
                    $higherEducations->mastersTotalMarks = NULL;
                    $higherEducations->mastersObtainedMarks = NULL;
                    $higherEducations->mastersMarksPercentage = NULL;

                    $ecd = $form->label("Masters Exam Concluded Date")->httpPost("mastersExamConcludedDate")->required()->asDate()->validate();
                    $higherEducations->mastersExamConcludedDate= $datetime->value($ecd)->asYmd();
                    $ecd= $datetime->value($ecd)->asObject(); 
                    if($ecd > $applicationEnd){
                        $json = SwiftJSON::failure("Masters Examination Appeared Date Must Be Less Than " . $datetime->value($applicationEnd)->asdmY());
                        die($json);
                    }

                    break;
                default:
                    break;
            }
        
            //Data for total marks, obtained marks & percentage of marks
            switch (strtolower($higherEducations->mastersResultType)) {
                case 'division':
                case 'class':    
                    $higherEducations->mastersTotalMarks = $form->label("Masters Total Marks")->httpPost("mastersTotalMarks")->required()->asInteger(false)->maxLength(4)->validate();
                    $higherEducations->mastersObtainedMarks = $form->label("Masters Obtained Marks")->httpPost("mastersObtainedMarks")->required()->asInteger(false)->maxLength(4)->validate();

                    if($higherEducations->mastersObtainedMarks > $higherEducations->mastersTotalMarks){
                        $json = SwiftJSON::failure("Masters obtained marks must be less than total marks."); die($json);
                    }

                    $higherEducations->mastersMarksPercentage = ($higherEducations->mastersObtainedMarks / $higherEducations->mastersTotalMarks) * 100; 
                    break;
                case 'grading':           
                        $higherEducations->mastersTotalMarks = NULL;
                        $higherEducations->mastersObtainedMarks = NULL;
                        $higherEducations->mastersMarksPercentage = NULL;
                    break; //end of division, class, grading switch
              
                default:
                    break;
            }
        
            //Division/Class/CGPA
            switch (strtolower($higherEducations->mastersResultType)) {
                case 'division':
                    $higherEducations->mastersDivision = $form->label("Masters Division")->httpPost("mastersDivision")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'class':    
                    $higherEducations->mastersClass = $form->label("Masters Class")->httpPost("mastersClass")->required()->asString(true)->maxLength(20)->validate();
                    break;
                case 'grading':           
                    $higherEducations->mastersCgpa = $form->label("Masters CGPA")->httpPost("mastersCgpa")->required()->asFloat(false)->maxLength(4)->validate();
                    $higherEducations->mastersCgpaScale = $form->label("Masters CGPA Scale")->httpPost("mastersCgpaScale")->required()->asFloat(false)->maxLength(4)->validate();

                    //(cgpa*80)/scale
                    $higherEducations->mastersMarksPercentage = ($higherEducations->mastersCgpa * 80)/ $higherEducations->mastersCgpaScale;
                    break;
                default:
                    break;
            } // //Division/Class/CGPA ends
            
            
                $higherEducations->mastersCourseDuration= NULL; //$form->label("Masters Course Duration")->httpPost("mastersCourseDuration")->required()->asInteger(false)->maxLength(4)->validate();
            
            
                $higherEducations->mastersGrade = NULL; //$form->label("mastersGrade")->httpPost("mastersGrade")->required()->asString(true)->maxLength(5)->default(NULL)->validate();

            } //if has masters      
    
        #endregion
                
        // HC Higher Education ends



        $differenceOfMemberShip = AgeCalculator::calculate($dateOfMembership, $applicationEnd);
      
        if($differenceOfMemberShip->years < 1){
            die(SwiftJSON::failure("Membership duration must be greater than 1 year."));
        }

        //------

        if($differenceOfMemberShip->years < 2){
            //no pass course
            if($higherEducations->llbExam == "LL.B (Pass)"){
                die(SwiftJSON::failure("LL.B (Pass) not allowed."));
            }
           
            if( $higherEducations->hasMasters == 0){
                die(SwiftJSON::failure("Masters degree required."));
            }

            if( $higherEducations->mastersMarksPercentage == NULL ||  $higherEducations->mastersMarksPercentage < 50  ){
                die(SwiftJSON::failure("50% or above marks required in Masters degree."));
            }

            //priority applicant
            if($cinfo->applicantType=="Regular"){
                if($cinfo->practiceStartDate == NULL || $cinfo->practiceEndDate == NULL){
                    die(SwiftJSON::failure("Minimum 1 year practice duration required."));
                }
                else{
                    $practiceDuration = AgeCalculator::calculate($cinfo->practiceStartDate, $cinfo->practiceEndDate);
                    if($practiceDuration->year < 1){
                        die(SwiftJSON::failure("Minimum 1 year practice duration required."));
                    }
                }
            }
        }


        if($differenceOfMemberShip->years >= 2){
            //general applicant
            if($cinfo->applicantType=="Regular"){
                if($cinfo->practiceStartDate == NULL || $cinfo->practiceEndDate == NULL){
                    die(SwiftJSON::failure("Minimum 6 months practice duration required."));
                }
                else{
                    $practiceDuration = AgeCalculator::calculate($cinfo->practiceStartDate, $cinfo->practiceEndDate);
                    if($practiceDuration->year == 0){
                        if($practiceDuration->month < 6){
                            die(SwiftJSON::failure("Minimum 6 months practice duration required."));
                        }
                    }
                }
            }
        }

        // if($difference->years == 5){
        //     if($difference->months > 0){
        //         die(SwiftJSON::failure($diffMessage));
        //     }
        //     else{
        //         if($difference->days > 0){
        //             die(SwiftJSON::failure($diffMessage));
        //         }
        //     }
        // }










        $uniqueCode = new UniqueCode($db);
        $cinfo->userId =  $uniqueCode->generate(8,"userId", "hc_written_cinfo");
        $db->startTransaction();
        $cinfo->id = $db->insert($cinfo)->execute();
        $higherEducations->applicantId= $cinfo->id;
        $higherEducations->userId=  $cinfo->userId;
        $db->insert($higherEducations)->execute();


        $photoPath = $photoDirectory . "/" . $cinfo->userId . '.jpg';
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
        ImageFile:: save("ApplicantPhoto", "Applicant's photo" ,$photoPath);
    
        $signaturePath = $signatureDirectory . "/" . $cinfo->userId . '.jpg';
        if (file_exists($signaturePath)) {
            unlink($signaturePath);
        }
        ImageFile:: save("ApplicantSignature", "Applicant's signature" ,$signaturePath);


        $scanCopyDir = ROOT_DIRECTORY . "/court-higher/written/payment-images";
        $scanCopy = $scanCopyDir. "/" . $cinfo->userId . '.jpg';
        if (file_exists($scanCopy)) {
            unlink($scanCopy);
        }

        if($cinfo->hasPaidPreviously){
            ImageFile:: save("paymentSlipScanCopy", "Payment Slip Scan Copy" ,$scanCopy);
        }

        $db->commit();
        $db->stopTransaction();
    }
    catch (\Exception $exp) {
        $logger->createLog($exp->getMessage());
        $json = SwiftJSON::failure("Problem in saving data. Please try again.");
        die($json);
    }
  
    function sanitizeString($string, $setUCase = false){
        $string = trim($string);
        $string = str_replace("Mr.", "", $string);
        $string = str_replace("Mrs.", "", $string);
        $string = trim($string);
        if($setUCase){
            $string = strtoupper($string);
        }
        return $string;
    }

    $encId = $endecrytor->encrypt($cinfo->id);
    $url = BASE_URL . "/court-higher/written/application-form/preview.php?id=$encId" ;

    exit('{"issuccess":true, "redirecturl":"'. $url .'"}');
?>