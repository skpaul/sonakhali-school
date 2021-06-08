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
    ->Helpers()->DropDown()->RadioButton();

require_once(ROOT_DIRECTORY . "/lib/Heredoc.php");

$logger = new SwiftLogger(ROOT_DIRECTORY, false);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();

$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$dateTime = new SwiftDatetime();
$now = $dateTime->now()->asYmdHis();

if (!isset($_GET["u"]) || empty($_GET["u"])) {
    Helpers::redirect(BASE_URL . "/sorry.php", false);
}

$encSessionId = $_GET["u"];
$sessionId = $endecrytor->decrypt($encSessionId);
$session = new SessionBase($db, $dateTime);
try {
    $session->continue($sessionId);
    $sessionUserDetails = $session->getJsonObject("userDetails");
} catch (SessionExpiredException $exp1) {
    Helpers::redirect(BASE_URL . "/session-expired.php?reason=1", false);
} catch (SessionNotFoundException $exp2) {
    Helpers::redirect(BASE_URL . "/session-expired.php?reason=2", false);
}

$registration = $db->select()->from("hc_written_registered_cinfo")
    ->where("regNo")->equalTo($sessionUserDetails->regNo)
    ->andWhere("regYear")->equalTo($sessionUserDetails->regYear)
    ->single();


$isNewApplicant = true;
$applicant = NULL;
$higher_education = NULL;
$queryString = "";
$applicant = NULL;

$districts = $db->select("name")->from("districts")->orderBy("name")->toList();

function is_child_hidden($value, $value_to_compare){
    if ($value == $value_to_compare) {
        return "";
    } else {
        return "hidden";
    }
}

$infoSerialNo = 0;
// ob_start();
try {
    //code...

?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Application Form- <?= ORGANIZATION_SHORT_NAME ?></title>
        <?php
        Required::metaTags()->favicon()->teletalkCSS()->bootstrapGrid()->sweetModalCSS()->airDatePickerCSS();
        ?>

        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.structure.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.theme.min.css" rel="stylesheet">

        <style>
            .formSection {
                margin-bottom: 50px !important;
            }

            .btn {
                background-color: #dcdcdc !important;
                border: 2px solid #6b6b6b !important;
                color: #0a0909 !important;
                padding-top: 2px;
                padding-bottom: 2px;
            }

            .previewMode {
                /* border: none !important; */
                border-color: white;
                -webkit-user-select: none;
                outline: none;
                pointer-events: none;
                padding: 0;
            }

            label.changed::after {
                color: white;
            }

            .previewMode>select {
                -webkit-appearance: none;
                -moz-appearance: none;
                text-indent: 1px;
                text-overflow: '';
            }

            .sectionNavigation {
                display: flex;
                text-align: center;
                justify-content: space-between;
            }

            .sectionNavigation .btn {
                display: flex;
            }

            .sectionNavigation .goToPrevSection>img {
                height: 20px;
                margin-top: 2px;
                margin-right: 7px;
            }

            .sectionNavigation .goToNextSection>img {
                height: 20px;
                margin-top: 2px;
                margin-left: 7px;
            }

            /* Left right position */
            /* .sectionNavigation .goToPrevSection {
                float: left;
            }

            .sectionNavigation .goToNextSection,
            .sectionNavigation .form-submit-button
            .sectionNavigation #showPreview{
                float: right;
            } */
            /* Left right position */
        </style>

    </head>

    <body>
        <!-- <div id="version"></div> -->
        <div class="master-wrapper">
            <header>
                <?php
                require_once(ROOT_DIRECTORY . '/inc/header.php');
                echo prepareHeader(ORGANIZATION_FULL_NAME, $encSessionId);
                ?>
            </header>
            <main id="applicant-info">

                <h2 class="text-center">Application Form</h2>
                <h4 class="text-center">Written Examination (Higher Court)</h4>



                <div class="container">
                    <form class="classic" id="application-form" action="written-exam-application-form_.php?u=<?= $encSessionId ?>" method="post" enctype="multipart/form-data">

                        <!-- General info starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25">
                            <p>Step 1 of 6</p>
                            <h2>General Information</h2>
                            <?php
                            $name = trim($registration->name);
                            $name = str_replace("Mr.", "", $name);
                            $name = str_replace("Mrs.", "", $name);
                            $name = trim($name);
                            $readOnly = "readonly";
                            if (empty($name)) {
                                $readOnly = "";
                            }

                            $fullNameHtml =
                                <<<HTML
                                    <div class="field">
                                        <label class="required">Name</label>
                                        <input name="fullName" class="validate formControl upper-case" 
                                            type="text" value="{$name}"
                                            {$readOnly}
                                            data-swift-title="Name"
                                            data-swift-required="required"   
                                            data-swift-maxlen="100" 
                                            >
                                    </div>
                                HTML;

                            $fatherName = trim($registration->fatherName);
                            $fatherName = str_replace("S/o.", "", $fatherName);
                            $fatherName = str_replace("D/o.", "", $fatherName);
                            $fatherName = trim($fatherName);
                            $readOnly = "readonly";
                            if (empty($fatherName)) {
                                $readOnly = "";
                            }

                            $fathersNameHtml =
                                <<<HTML
                                    <div class="field">
                                        <label class="required">Father's Name</label>
                                        <input name="fatherName" class="validate formControl upper-case" 
                                            type="text" value="{$fatherName}" {$readOnly}
                                            data-swift-title="Father's Name"
                                            data-swift-required="required"   
                                            data-swift-maxlen="100"
                                            >
                                    </div>
                                HTML;

                            $motherNameHtml =
                                <<<HTML
                                     <div class="field">
                                        <label class="required">Mother's Name</label>
                                        <input name="motherName" class="validate formControl upper-case" type="text" value=""
                                            data-swift-title="Mother's name"
                                            data-swift-required="required" 
                                            data-swift-maxlength="100">
                                    </div>
                                HTML;

                            $genderOptions =
                                <<<HTML
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                HTML;

                            $genderCombo = <<<HTML
                                    <div class="field">
                                        <label class="required">Gender</label>
                                        <select name="gender" class="validate formControl" 
                                            data-swift-title="Gender"
                                            data-swift-required="required">
                                            $genderOptions
                                        </select>
                                    </div>
                                HTML;
                            ?>


                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <?= $fullNameHtml ?>
                                </div>
                            </div>

                            <!-- Father & mother starts -->
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <?= $fathersNameHtml ?>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <?= $motherNameHtml ?>
                                </div>
                            </div>
                            <!-- Father & mother ends -->

                            <!-- Gender, DOB and Nationality starts -->
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <?= $genderCombo ?>
                                </div>
                                <!-- //date_of_birth field -------->
                                <div class="col-lg-4 col-sm-12">
                                    <div class="field">
                                        <label class="required">Date of Birth</label>
                                        <input name="dob" class="validate swiftDate formControl" data-swift-title="Date of Birth" data-swift-required="required" data-swift-datatype="date" type="text" autocomplete="off" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="field">
                                        <label class="required">Nationality</label>
                                        <input name="nationality" class="validate formControl" data-swift-title="Nationality" data-swift-required="required" type="text" value="Bangladeshi" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- Gender, DOB and Nationality ends -->


                            <?php
                            $nidTypes[0] = ["Birth Certificate", "Birth Certificate"];
                            $nidTypes[1] = ["NID", "NID"];
                            $nidTypes[2] = ["Passport", "Passport"];

                            $options = DropDown::createOptions($nidTypes);
                            // if ($isNewApplicant)
                            //     $options = DropDown::createOptions($nidTypes);
                            // else
                            //     $options = DropDown::createOptions($nidTypes, $applicant->idType);

                            $nidTypeCombo =
                                <<<HTML
                                        <select name="idType" class="validate formControl" title="Identity Type"
                                        data-swift-required="required" >
                                            <option value="">select<option>
                                            $options
                                        </select>
                                    HTML;
                            ?>
                            <!-- National identity type and number -->
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Identity Type</label>
                                        <?= $nidTypeCombo ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field nidNo">
                                        <label class="required">Identity Number</label>
                                        <input name="idNo" class="validate swiftInteger idNo formControl" type="text" value="" data-swift-required="required" data-swift-maxlen="20" data-swift-title="Identity Number">
                                    </div>
                                </div>
                            </div>
                            <!-- National identity type and number -->

                            <div class="sectionNavigation">
                                <div class="goToNextSection btn btn-default">Next
                                    <img src="<?= BASE_URL ?>/assets/images/next-button.png">
                                </div>
                            </div>
                        </section>
                        <!-- General info ends -->

                        <!-- Contact info starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25" style="display: none;">
                            <p>Step 2 of 6</p>
                            <h2>Contact Information Details</h2>

                            <!-- Contact number and email -->
                            <article style="margin-bottom: 5px;">
                                <div class="row">
                                    <!-- contactNo -------->
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="field">
                                            <label class="required">Contact Number</label>
                                            <input name="contactNo" class="validate swiftInteger formControl" data-swift-required="required" data-swift-datatype="mobile" data-swift-title="Contact Number" type="text" maxlen="11" value="<?php echo $isNewApplicant ? "" : $applicant->contactNo; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <div class="field">
                                            <label class="required">Retype Contact Number</label>
                                            <input name="reContactNo" class="validate swiftInteger formControl" data-swift-required="required" data-swift-datatype="mobile" data-swift-title="Retype Contact Number" type="text" maxlen="11" value="<?php echo $isNewApplicant ? "" : $applicant->contactNo; ?>">
                                        </div>
                                    </div>
                                    <!-- contactNo -------->

                                    <!--email -->
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="field">
                                            <label class="">Email</label>
                                            <input name="email" data-swift-required="optional" class="validate lower-case formControl" type="text" data-swift-datatype="email" data-swift-maxlen="40" data-swift-title="Email" value="<?php echo $isNewApplicant ? "" : $applicant->email; ?>" title="Email Address">
                                        </div>
                                    </div>
                                    <!--email -->
                                </div>
                            </article>

                            <!-- Present address starts -->
                            <article style="margin-bottom: 5px;">
                                <h3>Present address</h3>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="field">
                                            <label class="required">Detail Address</label>
                                            <textarea name="presentAddress" class="validate formControl" data-swift-required="required" data-swift-label="Present address detail" data-swift-maxlen="100" data-swift-title="Present Address"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <article class="district">
                                            <label class="required">District</label>
                                            <select name="presentDist"
                                            data-districttype="present"
                                            class="presentDistrict validate formControl district-combo" data-swift-required="required" data-swift-title="Present District">
                                                <option value="">select</option>
                                                <?php
                                                    foreach ($districts as $district) {
                                                ?>
                                                    <option value="<?= $district->name ?>"><?= $district->name ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </article>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <article class="thana">
                                            <label class="required">Thana/Upazila</label>
                                            <select name="presentThana" id="presentThana" class="presentThana validate formControl" data-swift-required="required" data-swift-title="Present Thana/Upazila">

                                            </select>
                                        </article>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <article class="">
                                            <label class="">Post Code</label>
                                            <input name="presentGpo" class="validate swiftInteger formControl" data-swift-required="optional" data-swift-exactLen="4" data-swift-title="Present Post Code" type="text" value="" maxlength="4">
                                        </article>
                                    </div>
                                </div>
                            </article>
                            <!-- Present address ends -->

                            <!-- Permanent address starts -->
                            <article style="margin-bottom: 5px;">
                                <h3>Permanent address</h3>

                                <div class="field">
                                    <label class="required">Detail Address</label>
                                    <textarea name="permanentAddress" class="validate formControl" data-swift-required="required" data-swift-maxlength="100" data-swift-title="Permanent Address"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="field">
                                            <label class="required">District</label>

                                            <select name="permanentDist"  
                                            data-districttype="permanent"
                                            class="permanentDistrict validate formControl district-combo" data-swift-required="required" data-swift-title="Permanent District">
                                            <option value="">select</option>
                                                <?php
                                                    foreach ($districts as $district) {
                                                ?>
                                                    <option value="<?= $district->name ?>"><?= $district->name ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <article class="">
                                            <label class="required">Thana/Upazila</label><img class="label-spinner hidden" src="../../../assets/images/spinner.svg">
                                            <select name="permanentThana" id="permanentThana" class="permanentThana validate formControl" data-swift-required="required" data-swift-title="Permanent Thana/Upazila">

                                            </select>
                                            
                                        </article>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <div class="field">
                                            <label class="">Post Code</label>
                                            <input name="permanentGpo" class="validate swiftInteger formControl" data-swift-required="optional" data-swift-exactLen="4" data-swift-title="Permanent Post Code" type="text" value="" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Permanent address ends -->

                            <div class="sectionNavigation">
                                <div class="goToPrevSection btn"><img src="<?= BASE_URL ?>/assets/images/prev-button.png">Previous</div>
                                <div class="goToNextSection btn">Next <img src="<?= BASE_URL ?>/assets/images/next-button.png"></div>
                            </div>
                        </section>
                        <!-- Contact info ends -->

                        <!-- Education starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25" style="display: none;">
                            <p>Step 3 of 6</p>
                            <H2>Educational Information</H2>

                            <!-- SSC starts -->
                            <article class="" style="margin-bottom:35px;">
                                <h4>S.S.C/Equivalent</h4>
                                <!-- SSC Exam Name, Roll, Regi starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Exam Name</label>
                                            <select name="sscExamName" class="validate formControl" data-swift-title="S.S.C/Equivalent Examination Name" data-swift-required="required">
                                                <option value="">select exam</option>
                                                <?php
                                                $sql = "SELECT examination_name AS value, examination_name AS text FROM examinations WHERE level='secondary' AND is_active='yes' ORDER BY serial_number";
                                                $secondaryExams = $db->select($sql)->fromSQL()->fetchArray()->toList();
                                                echo Helpers::createOptions($secondaryExams);
                                                //required for editing mode
                                                // echo Helpers::createOptions($secondaryExams, $applicant->secondary_examination_id);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Roll No.</label>
                                            <input name="sscRollNo" class="validate formControl swiftInteger" data-swift-title="S.S.C/Equivalent Examination Roll No." data-swift-required="required" data-swift-datatype="integer" maxlength="15" type="text" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Registration No.</label>
                                            <input name="sscRegiNo" class="validate formControl swiftInteger" data-swift-title="S.S.C/Equivalent Examination Registration No." data-swift-required="required" data-swift-datatype="integer" maxlength="15" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC Exam Name, Roll, Regi ends -->

                                <!-- SSC Board starts -->
                                <div class="row">
                                    <div class="col">
                                        <div class="field">
                                            <label class="required">Board</label>
                                            <select name="sscBoard" class="formControl" data-swift-title="Board">
                                                <option value="">select board</option>
                                                <?php
                                                $sql = "SELECT `name` AS value, `name` AS text FROM education_boards ORDER BY `name`";
                                                $boards = $db->select($sql)->fromSQL()->fetchArray()->toList();
                                                echo Helpers::createOptions($boards);
                                                //Required in editing mode
                                                // echo Helpers::createOptions($boards, $applicant->secondary_education_board_id );
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC Board ends -->

                                <!-- SSC Result Type starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field">
                                            <label class="required">Result Type</label>
                                            <select name="sscResultType" class="sscResultType formControl validate" data-swift-title="S.S.C/Equivalent Result Type" data-swift-required="required">
                                                <option></option>
                                                <option value="Division">Division</option>
                                                <option value="Grade">Grade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC Result Type ends -->


                                <!-- SSC Division starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field sscDivisionDetails hidden">
                                            <label class="required">Division</label>
                                            <select name="sscDivision" class="formControl validate" data-swift-title="S.S.C/Equivalent Result in Division" data-swift-required="required">
                                                <option></option>
                                                <option value="1st Division">1st Division</option>
                                                <option value="2nd Division">2nd Division</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC Division ends -->

                                <!-- SSC GPA & Scale starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <!-- .sscGradeDetails is required to dynamically show hide -->
                                        <div class="field sscGradeDetails hidden">
                                            <label class="required">GPA</label>
                                            <input name="sscGpa" class="validate formControl swiftFloat" data-swift-title="S.S.C/Equivalent Result in GPA" data-swift-required="required" data-swift-datatype="float" data-swift-minval="0.01" data-swift-maxval="5.00" type="text" placeholder="must be in 0.00 format">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-6">
                                        <!-- .sscGradeDetails is required to dynamically show hide -->
                                        <div class="field sscGradeDetails hidden">
                                            <label class="required">Scale</label>
                                            <select name="sscScale" class="validate formControl" data-swift-title="S.S.C/Equivalent GPA Scale" data-swift-required="required">
                                                <option value="">select scale</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC GPA & Scale ends -->

                                <!-- SSC Group, Passing Year starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="field">
                                            <label class="required">Group</label>
                                            <select name="sscGroup" class="validate formControl" data-swift-title="S.S.C Group" data-swift-required="required">
                                                <option value="">select group</option>
                                                <option value="Science">Science</option>
                                                <option value="Humanities">Humanities</option>
                                                <option value="Business Studies">Business Studies</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="field">
                                            <label class="required">Passing Year</label>
                                            <input name="sscYear" class="validate formControl swiftYear swiftInteger" data-swift-title="S.S.C Passing Year" data-swift-required="required" type="text" value="" maxlength="4" autoComplete="off">
                                        </div>
                                    </div>
                                </div>
                                <!-- SSC Group, Passing Year starts -->

                            </article>
                            <!-- SSC ends -->


                            <!-- HSC starts -->
                            <article style="margin-bottom:35px;">
                                <h4>H.S.C/Equivalent</h4>
                                <!-- HSC Exam Name, Roll, Regi starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Exam Name</label>
                                            <select name="hscExamName" class="validate formControl" data-swift-title="H.S.C/Equivalent Examination Name" data-swift-required="required">
                                                <option value="">select exam</option>
                                                <?php
                                                $sql = "SELECT examination_name AS value, examination_name AS text FROM examinations WHERE level='higher_secondary' AND is_active='yes' ORDER BY serial_number";
                                                $secondaryExams = $db->select($sql)->fromSQL()->fetchArray()->toList();
                                                echo Helpers::createOptions($secondaryExams);
                                                //required for editing mode
                                                // echo Helpers::createOptions($secondaryExams, $applicant->secondary_examination_id);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Roll No.</label>
                                            <input name="hscRollNo" class="validate formControl swiftInteger" data-swift-title="H.S.C/Equivalent Examination Roll No." data-swift-required="required" data-swift-datatype="integer" maxlength="15" type="text" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-4">
                                        <div class="field">
                                            <label class="required">Registration No.</label>
                                            <input name="hscRegiNo" class="validate formControl swiftInteger" data-swift-title="H.S.C/Equivalent Examination Registration No." data-swift-required="required" data-swift-datatype="integer" maxlength="15" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Exam Name, Roll, Regi ends -->

                                <!-- HSC Board starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field">
                                            <label class="required">Board</label>
                                            <select name="hscBoard" class="validate formControl" data-swift-title="Board">
                                                <option value="">select board</option>
                                                <?php
                                                $sql = "SELECT `name` AS value, `name` AS text FROM education_boards ORDER BY `name`";
                                                $boards = $db->select($sql)->fromSQL()->fetchArray()->toList();
                                                echo Helpers::createOptions($boards);
                                                //Required in editing mode
                                                // echo Helpers::createOptions($boards, $applicant->secondary_education_board_id );
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Board ends -->

                                <!-- HSC Result Type starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field">
                                            <label class="required">Result Type</label>
                                            <select name="hscResultType" class="hscResultType formControl validate" data-swift-title="H.S.C/Equivalent Result Type" data-swift-required="required">
                                                <option></option>
                                                <option value="Division">Division</option>
                                                <option value="Grade">Grade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Result Type ends -->


                                <!-- HSC Division starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field hscDivisionDetails hidden">
                                            <label class="required">Division</label>
                                            <select name="hscDivision" class="formControl validate" data-swift-title="H.S.C/Equivalent Result in Division" data-swift-required="required">
                                                <option></option>
                                                <option value="1st Division">1st Division</option>
                                                <option value="2nd Division">2nd Division</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Division ends -->

                                <!-- HSC GPA & Scale starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <!-- .hscGradeDetails is required to dynamically show hide -->
                                        <div class="field hscGradeDetails hidden">
                                            <label class="required">GPA</label>
                                            <input name="hscGpa" class="validate formControl swiftFloat" type="text" placeholder="must be in 0.00 format" data-swift-title="H.S.C/Equivalent Result in GPA" data-swift-required="required" data-swift-datatype="float" data-swift-minval="0.01" data-swift-maxval="5.00">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-6">
                                        <!-- .hscGradeDetails is required to dynamically show hide -->
                                        <div class="field hscGradeDetails hidden">
                                            <label class="required">Scale</label>
                                            <select name="hscScale" class="validate formControl" data-swift-title="H.S.C/Equivalent GPA Scale" data-swift-required="required">
                                                <option value="">select scale</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC GPA & Scale ends -->

                                <!-- HSC Group, Passing Year starts -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="field">
                                            <label class="required">Group</label>
                                            <select name="hscGroup" class="validate formControl" data-swift-title="H.S.C Group" data-swift-required="required">
                                                <option value="">select group</option>
                                                <option value="Science">Science</option>
                                                <option value="Humanities">Humanities</option>
                                                <option value="Business Studies">Business Studies</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="field">
                                            <label class="required">Passing Year</label>
                                            <input name="hscYear" class="validate formControl swiftYear swiftInteger" data-swift-title="H.S.C Passing Year" data-swift-required="required" type="text" value="" maxlength="4" autoComplete="off">
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Group, Passing Year starts -->

                            </article>
                            <!-- HSC ends -->



                            <!--  LL.B (Hons.) or LL.B (Pass) starts -->
                            <article style="margin-bottom:35px;">
                                <h4>Graduation (LL.B)</h4>
                                <!-- llbExam -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-7">
                                        <div class="field">
                                            <label class="required">Exam Name</label>
                                            <!-- .examName is required to dynamically load result details html markup from server -->
                                            <select name="llbExam" class="examName validate formControl" data-swift-title="Graduation (LL.B) Examination Name" data-swift-required="required">
                                                <option value="">select exam</option>
                                                <option value="LL.B (Hons)">LL.B (Hons)</option>
                                                <option value="LL.B (Pass)">LL.B (Pass)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-5">
                                        <div class="field">
                                            <label class="required">ID/Roll/Registration No.</label>
                                            <input name="llbId" class="validate formControl" data-swift-title="LL.B ID/Roll/Registration" data-swift-required="required" data-swift-maxlen="20" type="text" maxlength="20" value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- llbExam -->

                                <div class="field">
                                    <label class="required">Degree Obtained From Country</label>
                                    <input name="llbCountry"
                                    value="Bangladesh"
                                     class="country formControl" type="text" placeholder="write country name" data-swift-required="required" data-swift-title="LL.B Exam Country name">
                                </div>

                                <div class="field">
                                    <label class="required">University/Institute</label>
                                    <input name="llbUni" class="universityName formControl" data-swift-required="required" data-swift-title="University" type="text">
                                </div>

                                <!-- Graduation (LLB) Result Type starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="field">
                                            <label class="required">Result Type</label>
                                            <!-- .higherEducationResultType is required to load result details html markup from server-->
                                            <select name="llbResultType" class="higherEducationResultType formControl validate" data-examname="llb" data-swift-title="H.S.C/Equivalent Result Type" data-swift-required="required">
                                                <option></option>
                                                <option value="Division">Division</option>
                                                <option value="Class">Class</option>
                                                <option value="Grading">Grading</option>
                                                <option value="Appeared">Appeared</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- HSC Result Type ends -->

                                <div class="dynamicContent">
                                    <!-- content comes on  .higherEducationResultType change event-->
                                </div>
                            </article>
                            <!-- LL.B (Hons.) or LL.B (Pass) ends -->











                            <!-- Graduation (in other discipline) starts -->
                            <article class="" style="margin-bottom:35px;">
                                <?php // .educationDetailsToggle is required to handle checkbox change event 
                                ?>
                                <h4><input name="hasOtherGrad" class="educationDetailsToggle" value="hasOtherGrad" type="checkbox"> Graduation (Other)</h4>
                                <p class="justify">Optional. If you have any graduation degree other than LL.B (Hons.) or LL.B (Pass), please put tick on the checkbox above and provide the information below. </p>

                                <!-- <div class="visibleWrapper" style="display: none;"> -->
                                <div class="toggleVisibleWrapper hidden">
                                    <!-- graduationOther -->
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-7">
                                            <div class="field">
                                                <label class="required">Exam Name</label>
                                                <!-- .examName is required to dynamically load result details html markup from server -->
                                                <select name="gradOtherExam" class="examName validate formControl checkVisibility" data-swift-title="Graduation(Other) Examination Name" data-swift-required="required">
                                                    <option value="">select exam</option>
                                                    <option value="B.B.A">B.B.A</option>
                                                    <option value="B.Com (Hons)">B.Com (Hons)</option>
                                                    <option value="B.Com (Pass)">B.Com (Pass)</option>
                                                    <option value="B.Sc (Hons)">B.Sc (Hons)</option>
                                                    <option value="B.Sc (Pass)">B.Sc (Pass)</option>
                                                    <option value="B.S.S (Hons)">B.S.S (Hons)</option>
                                                    <option value="B.S.S (Pass)">B.S.S (Pass)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-5">
                                            <div class="field">
                                                <label class="required">ID/Roll/Registration No.</label>
                                                <input name="gradOtherId" class="validate formControl checkVisibility" data-swift-title="Graduation (Other) ID/Roll/Registration" data-swift-required="required" data-swift-maxlen="20" type="text" maxlength="20" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- llbExam -->

                                    <div class="field">
                                        <label class="required">Degree Obtained From Country</label>
                                        <input name="gradOtherCountry" class="country checkVisibility formControl" 
                                        value="Bangladesh"
                                        data-swift-required="required" data-swift-title="Graduation (Other) Country Name" type="text" placeholder="write country name">
                                    </div>

                                    <div class="field">
                                        <label class="required">University/Institute</label>
                                        <input name="gradOtherUni" class="universityName checkVisibility formControl" data-swift-required="required" data-swift-title="University" type="text">
                                    </div>

                                    <!-- Graduation (Other) Result Type starts -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="field">
                                                <label class="required">Result Type</label>
                                                <!-- .higherEducationResultType is required to load result details html markup from server-->
                                                <select name="gradOtherResultType" class="higherEducationResultType formControl validate checkVisibility" data-examname="llb" data-swift-title="H.S.C/Equivalent Result Type" data-swift-required="required">
                                                    <option></option>
                                                    <option value="Division">Division</option>
                                                    <option value="Class">Class</option>
                                                    <option value="Grading">Grading</option>
                                                    <option value="Appeared">Appeared</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- HSC Result Type ends -->

                                    <div class="dynamicContent">
                                        <!-- content comes on  .higherEducationResultType change event-->
                                    </div>
                                </div>

                            </article>
                            <!-- Graduation (in other discipline) ends -->










                            <!-- Masters/ Post Graduation starts -->
                            <article style="margin-bottom:35px;">
                                <?php // .educationDetailsToggle is required to handle checkbox change event 
                                ?>
                                <h4><input name="hasMasters" class="educationDetailsToggle" value="hasMasters" type="checkbox"> Post Graduation</h4>
                                <p>Optional. If you have any post graduation or masters degree, please put tick on the checkbox above and provide the information below. </p>
                                <div class="toggleVisibleWrapper hidden">
                                    <!-- style="display: none;" -->
                                    <!-- llbExam -->
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-7">
                                            <div class="field">
                                                <label class="required">Exam Name</label>
                                                <!-- .examName is required to dynamically load result details html markup from server -->
                                                <select name="mastersExam" class="examName validate checkVisibility formControl" data-swift-title="Post Graduation Examination Name" data-swift-required="required">
                                                    <option value="">select exam</option>
                                                    <option value="LL.M">LL.M</option>
                                                    <option value="M.B.A">M.B.A</option>
                                                    <option value="M.Sc">M.Sc</option>
                                                    <option value="M.Com">M.Com</option>
                                                    <option value="M.S.S">M.S.S</option>
                                                    <option value="M.A">M.A</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-5">
                                            <div class="field">
                                                <label class="required">ID/Roll/Registration No.</label>
                                                <input name="mastersId" class="validate formControl checkVisibility" type="text" maxlength="20" value="" data-swift-title="LL.B ID/Roll/Registration" data-swift-required="required" data-swift-maxlen="20">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- llbExam -->

                                    <div class="field">
                                        <label class="required">Degree Obtained From Country</label>
                                        <input name="mastersCountry" class="country checkVisibility formControl" type="text" 
                                        value="Bangladesh"
                                        placeholder="write country name" data-swift-required="required" data-swift-title="Masters Degree Country name">
                                    </div>

                                    <div class="field">
                                        <label class="required">University/Institute</label>
                                        <input name="mastersUni" class="universityName checkVisibility formControl" data-swift-required="required" data-swift-title="University" type="text">
                                    </div>

                                    <!-- Masters Result Type starts -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="field">
                                                <label class="required">Result Type</label>
                                                <!-- .higherEducationResultType is required to load result details html markup from server-->
                                                <select name="mastersResultType" class="higherEducationResultType formControl validate checkVisibility" data-examname="llb" data-swift-title="LL.B Result Type" data-swift-required="required">
                                                    <option></option>
                                                    <option value="Division">Division</option>
                                                    <option value="Class">Class</option>
                                                    <option value="Grading">Grading</option>
                                                    <option value="Appeared">Appeared</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- HSC Result Type ends -->

                                    <div class="dynamicContent">
                                        <!-- content comes on  .higherEducationResultType change event-->
                                    </div>
                                </div>
                            </article>
                            <!-- Post Graduation ends -->


                            <div class="sectionNavigation">
                                <div class="goToPrevSection btn"><img src="<?= BASE_URL ?>/assets/images/prev-button.png">Previous</div>
                                <div class="goToNextSection btn">Next <img src="<?= BASE_URL ?>/assets/images/next-button.png"></div>
                            </div>
                        </section>
                        <!-- Education ends -->

                        <!-- Other information starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25 " style="display: none;">
                            <p>Step 4 of 6</p>
                            <h2>Other information</h2>

                            <?php
                            $pupilageNoHtml =
                                <<<HTML
                                        <div class="field pupilageNo">
                                            <label class="required">Pupilage No.</label>
                                            <input name="pupilageNo" class="pupilageNo formControl swiftInteger validate" type="text" value=""
                                            data-swift-title="Pupilage Number"
                                            data-swift-required="required" />
                                        </div>
                                    HTML;

                            $pupilageOfHtml =
                                <<<HTML
                                        <div class="field pupilageOf">
                                            <label class="required">Pupilage Of</label>
                                            <input name="pupilageOf" class="pupilageOf formControl validate" type="text" value=""
                                            data-swift-title="Pupilage Of"
                                            data-swift-required="required" />
                                        </div>
                                    HTML;

                            $barName = trim($registration->barName);
                            $barName = str_replace("S/o.", "", $barName);
                            $barName = str_replace("D/o.", "", $barName);
                            $barName = trim($barName);
                            $readOnly = "readonly";
                            if (empty($barName)) {
                                $readOnly = "";
                            }

                            $barAssosiationNameHtml =
                                <<<HTML
                                        <div class="field barAssosiationName">
                                            <label class="required">Name of the Bar Assosiation which he/she intends to join</label>
                                            <input name="barAssosiationName" class="validate formControl upper-case"
                                                type="text" value="{$barName}" {$readOnly} 
                                                data-swift-title="Bar Assosiation Name"
                                                data-swift-required="required" data-swift-maxlen="100"  />
                                        </div>
                                     HTML;


                            $seniorAdvocateName = trim($registration->seniorAdvocateName);
                            $seniorAdvocateName = str_replace("S/o.", "", $seniorAdvocateName);
                            $seniorAdvocateName = str_replace("D/o.", "", $seniorAdvocateName);
                            $seniorAdvocateName = trim($seniorAdvocateName);
                            $readOnly = "readonly";
                            if (empty($seniorAdvocateName)) {
                                $readOnly = "";
                            }


                            $seniorAdvocateNameHtml =
                                <<<HTML
                                        <div class="field seniorAdvocateName">
                                            <label class="required">Name of Senior Advocate</label>
                                            <input name="seniorAdvocateName" class="validate formControl upper-case" 
                                                type="text" value="{$seniorAdvocateName}" {$readOnly}
                                                data-swift-title="Senior Advocate Name"
                                                data-swift-required="required" data-swift-maxlen="100"  />
                                        </div>
                                    HTML;
                            ?>

                            <!-- //Pupilage No -->
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    <?= $pupilageOfHtml ?>
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <?= $pupilageNoHtml ?>
                                </div>
                            </div>
                            <!--Pupilage No// -->

                            <!-- //Bar assosiation -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $barAssosiationNameHtml ?>
                                </div>
                            </div>


                            <!-- //Senior advocate -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $seniorAdvocateNameHtml ?>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="field">
                                        <label class="label required">Whether he/she is engaged in any business profession, service or vocation in Bangladesh, if so, the nature thereof and the place at which it is carried on</label>
                                        <div class="radio-group formControl">
                                            <label class="radio-label">
                                                <input type="radio" class="radio validate formControl" name="isEngaged" value="yes" data-swift-required="required" data-swift-label="Engagement in any business information">Yes
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="radio formControl" name="isEngaged" value="no">No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--is_engaged// -->

                            <!-- //natureOfEngagement -->
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <!-- .natureOfEngagementField is required to show/hide this div -->
                                    <div class="field natureOfEngagementField hidden">
                                        <label class="required">Nature of engagement</label>
                                        <input name="natureOfEngagement" class="validate formControl" type="text" data-swift-required="required" value="" />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <!-- .placeOfEngagementField is required to show/hide this div -->
                                    <div class="field placeOfEngagementField hidden">
                                        <label class="required">Place of engagement</label>
                                        <input name="placeOfEngagement" class="validate placeOfEngagement formControl" data-swift-required="required" type="text" value="" />
                                    </div>
                                </div>
                            </div>
                            <!--business_profession_place// -->

                            <!-- //insolvent -->

                            <div class="row">
                                <div class="col-sm-12">
                                    <article class="">
                                        <label class="required">Whether the applicant has been declared Insolvent</label>
                                        <div class="radio-group formControl">
                                            <label class="radio-label">
                                                <input type="radio" class="radio validate " data-swift-required="required" name="isDeclaredInsolvent" value="yes">Yes
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="radio" name="isDeclaredInsolvent" value="no">No
                                            </label>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <!--insolvent// -->

                            <!-- //is dismissed -->

                            <div class="row">
                                <div class="col-sm-12">
                                    <article class="">
                                        <label class="label required">Whether the applicant has been dismissed from the service of Government or of a public statutry coporation, if so, date and reason thereof</label>
                                        <div class="radio-group formControl">
                                            <label class="radio-label">
                                                <input type="radio" class="validate formControl" name="isDismissed" data-swift-required="required" data-swift-label="Dismissal information" value="yes">Yes
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="radio formControl" name="isDismissed" value="no">No
                                            </label>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <!-- is dismissed// -->

                            <!-- //dismissal date -->
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <!-- .dismissalDateField is required to show/hide this div -->
                                    <div class="field dismissalDateField hidden">
                                        <label class="label required">Dismissal date</label>
                                        <input name="dismissalDate" class="validate swiftDate formControl" data-swift-required="required" data-swift-datatype="date" type="text" value="" />
                                    </div>
                                </div>

                                <!-- dismissal date// -->


                                <!-- //dismissal reason -->

                                <div class="col-lg-9 col-sm-12">
                                    <!-- .dismissalReasonField is required to show/hide this div-->
                                    <div class="field dismissalReasonField hidden">
                                        <label class="label required">Dismissal reason</label>
                                        <input name="dismissalReason" class="validate formControl" data-swift-required="required" type="text" value="" />
                                    </div>
                                </div>
                            </div>
                            <!-- dismissal reason// -->

                            <!-- //is convicted -->
                            <div class="row">
                                <div class="col-sm-12">

                                    <label class="label required">Whether the applicant has been convicted of any offecne involving moral turpitude, if so, date and particulars thereof</label>
                                    <div class="radio-group formControl">
                                        <label class="radio-label">
                                            <input type="radio" class="validate formControl" name="isConvicted" data-swift-required="required" data-swift-label="Convicted information" value="yes">Yes
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" class="radio formControl" name="isConvicted" value="no">No
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- is convicted// -->

                            <!-- //conviction date -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="field convictionDateField hidden">
                                        <label class="label required">Conviction date</label>
                                        <input name="convictionDate" class="validate swiftDate formControl" type="text" value="" data-swift-required="required" data-swift-datatype="date" />
                                    </div>
                                </div>
                            </div>
                            <!-- conviction date// -->


                            <!-- //conviction particulars -->
                            <div class="row convictionDetails">
                                <div class="col-sm-12">
                                    <!-- .convictionParticularsField is required to show/hide this div -->
                                    <div class="field convictionParticularsField hidden">
                                        <label class="label required">Conviction particulars</label>
                                        <input name="convictionParticulars" class="validate formControl" type="text" value="" data-swift-title="Conviction Particulars" data-swift-required="required" data-swift-maxlen="50" />
                                    </div>
                                </div>
                            </div>
                            <!-- conviction particulars// -->

                            <!-- //isCancelledByBar -->

                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="label required">Whether the enrolment of the applicant has previously been cancelled by the Bar Council?</label>
                                    <div class="radio-group formControl">
                                        <label class="radio-label">
                                            <input type="radio" class="validate formControl" name="isCancelledByBar" data-swift-required="required" data-swift-label="Previous cancellation information" value="yes">Yes
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" class="radio formControl" name="isCancelledByBar" value="no">No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- isCancelledByBar// -->

                            <br><br>
                            <div class="sectionNavigation">
                                <div class="goToPrevSection btn"><img src="<?= BASE_URL ?>/assets/images/prev-button.png">Previous</div>
                                <div class="goToNextSection btn">Next <img src="<?= BASE_URL ?>/assets/images/next-button.png"></div>
                            </div>
                        </section>
                        <!-- Other information ends -->

                        <!-- Payment info starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25" style="display: none;">
                            <p>Step 5 of 6</p>
                            <h2>Payment information</h2>
                            <?php
                            $isPaidHtml = <<<HTML
                                <article class="isPaid">
                                <label class="label required">Paid previously?</label>
                                    <div class="radio-group formControl">
                                        <label class="radio-label">
                                            <input type="radio" class="validate formControl" name="hasPaidPreviously" data-swift-label="Payment information" value="yes">Yes
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" class="radio formControl" name="hasPaidPreviously" value="no">No
                                        </label>
                                    </div>
                                </article>
                            HTML;

                            $paymentChannelHtml = <<<HTML
                                <div class="field hidden">
                                    <span></span><label class="required">Payment Type</label> <!-- {$createSerial($infoSerialNo)} -->
                                    <select name="prevPaymentType" class="formControl validate paymentChannel" 
                                        data-swift-required="required">
                                        <option value=""></option>
                                        <option value="bankdraft">Bank-draft</option>
                                        <option value="bankslip">Bank-slip</option>
                                    </select>
                                </div>
                            HTML;

                            $paymentDetailHtml =
                                <<<HTML
                                    <div class="field hidden">
                                        <span></span><label class="required">Payment Detail</label>
                                        <input name="prevPaymentDetails" class="formControl validate paymentDetail" type="text" value=""/>
                                    </div>
                                HTML;

                            $bankNameHtml =
                                <<<HTML
                                <div class="field hidden">
                                    <span></span><label class="required">Bank Name</label>
                                    <input name="bankName" class="formControl validate bankName" type="text" value=""/>
                                </div>
                            HTML;

                            $branchNameHtml =
                                <<<HTML
                                <div class="field hidden">
                                    <span></span><label class="required">Branch Name</label>
                                    <input name="branchName" class="formControl validate branchName" type="text" value=""/>
                                </div>
                            HTML;

                            $feeAmountHtml =
                                <<<HTML
                                <div class="field hidden">
                                    <span></span><label class="required">Amount</label>
                                    <input name="feeAmount" class="formControl validate feeAmount" type="text" value=""/>
                                </div>
                            HTML;

                            $draftOrSlipNoHtml =
                                <<<HTML
                                <div class="field hidden">
                                    <span></span><label class="required">Draft or Slip No</label>
                                    <input name="draftOrSlipNo" class="formControl validate draftOrSlipNo" type="text" value=""/>
                                </div>
                            HTML;

                            $paymentSlipScanCopy =
                                <<<HTML
                            <div class="field hidden">
                                <span></span><label class="required">Payment Slip Scan Copy</label>
                                <input name="paymentSlipScanCopy" class="formControl validate paymentSlipScanCopy" type="file" accept="image/jpeg"/>
                            </div>
                        HTML;
                            ?>

                            <article>
                                <div class="row">
                                    <!-- is paid -->
                                    <div class="col-sm-12">
                                        <?= $isPaidHtml ?>
                                    </div>
                                    <!-- is paid -->

                                    <!-- payment channel -->
                                    <div class="col-sm-12">
                                        <?= $paymentChannelHtml ?>
                                    </div>
                                    <!-- payment channel -->

                                    <!-- //Bank Name -->
                                    <div class="col-sm-12 col-lg-12">
                                        <?= $bankNameHtml ?>
                                    </div>
                                    <!-- //Bank Name -->

                                    <!-- //Branch Name -->
                                    <div class="col-sm-12 col-lg-12">
                                        <?= $branchNameHtml ?>
                                    </div>
                                    <!-- //Branch Name -->

                                    <!-- //Fee Amount -->
                                    <div class="col-sm-12 col-lg-12">
                                        <?= $feeAmountHtml ?>
                                    </div>
                                    <!-- //Fee Amount -->

                                    <!-- //Draft or Slip No. -->
                                    <div class="col-sm-12 col-lg-12">
                                        <?= $draftOrSlipNoHtml ?>
                                    </div>
                                    <!-- //Draft or Slip No. -->

                                    <div class="col-sm-12 col-lg-12">
                                        <?= $paymentSlipScanCopy ?>
                                    </div>
                                </div>
                            </article>


                            <div class="sectionNavigation">
                                <div class="goToPrevSection btn"><img src="<?= BASE_URL ?>/assets/images/prev-button.png">Previous</div>
                                <div class="goToNextSection btn">Next <img src="<?= BASE_URL ?>/assets/images/next-button.png"></div>
                            </div>
                        </section>
                        <!-- Payment info ends -->

                        <section class="formSection box-shadow padding-all-25 margin-bottom-25" style="display: none;">
                            <p>Step 6 of 6</p>
                            <!-- Photo upload starts -->
                            <?php
                            $photo_path = BASE_URL . "/assets/images/default-photo.jpg";
                            $signature_path = BASE_URL . "/assets/images/default-signature.jpg";
                            // if ($isNewApplicant) {
                            //     $photo_path = BASE_URL . "assets/images/default-photo.jpg";
                            //     $signature_path = BASE_URL . "assets/images/default-signature.jpg";
                            // } 
                            // else {
                            //     $photo_path = BASE_URL . 'applicant-images/photos/' . $applicant->invoiceCode . '.jpg';
                            //     $signature_path = BASE_URL . '/applicant-images/signatures/' . $applicant->invoiceCode . '.jpg';
                            // }
                            ?>

                            <div class="uploader field formControl">
                                <div style="border:0;">
                                    <h2>Upload Photo</h2>
                                    <div class="preview-and-instruction">
                                        <div class="preview">
                                            <img name="ApplicantPhoto" id="ApplicantPhotoImage" src="<?= $photo_path; ?>" style="width: 150px;">
                                        </div>
                                        <div class="instruction">Photo dimension must be 300X300 pixels and size less than 100 kilobytes.</div>
                                    </div>
                                    <div class="file-input">
                                        <input type="file" title="Applicant's Photo" name="ApplicantPhoto" id="ApplicantPhoto" class="photo formControl"
                                        data-swift-required="required" data-swift-title="Applicant's Photo" accept="image/jpeg">
                                    </div>
                                </div>

                                <div style="border:0;">
                                    <h2>Upload Signature</h2>
                                    <div class="preview-and-instruction">
                                        <div class="preview">
                                            <img name="ApplicantSignature" id="ApplicantSignatureImage" src="<?php echo $signature_path; ?>" style="width:150px;">
                                        </div>
                                        <div class="instruction">
                                            Photo dimension must be 300X80 pixels and size less than 100 kilobytes.
                                        </div>
                                    </div>
                                    <div class="file-input">
                                        <input type="file" title="Applicant's Signature" name="ApplicantSignature" id="ApplicantSignature" class="photo formControl"
                                        data-swift-required="required" data-swift-title="Applicant's Signature" accept="image/jpeg">
                                    </div>
                                </div>
                            </div>
                            <!-- Photo upload ends -->

                            <article class="margin-bottom-25">
                                <h2>Declaration</h2>
                                <input type="checkbox" id="DeclarationApproval" class="formControl" style="margin-left: -1px; margin-right: 13px; margin-top: 5px;"> I declare that the information provided in this form is correct, true and complete to the best of my knowledge and belief. If any information is found false, incorrect and incomplete or if any ineligibility is detected before or after the examination, any action can be taken against me by the Commission.
                            </article>

                            <div class="sectionNavigation">
                                <div class="goToPrevSection btn">Previous</div>
                                <div class="btn" id="showPreview">Preview</div>
                            </div>


                        </section>

                        <div id="submitSection" style="display: none;">
                            <div id="closePreview" class="btn">Back to form</div>
                            <!-- Submit button is here -->
                            <?php
                            if (ENVIRONMENT == "DEVELOPMENT") {
                                $sumitButton =
                                    <<<HTML
                                        <!-- <div class="btn" id="showPreview" style="margin:auto; position:fixed; top:150px; right:50px;">Preview</div> -->
                                        <!-- <button id="submit-button" class="form-submit-button" style="height:60px; width:200px; margin:auto; position:fixed; top:50px; right:50px;">Submit</button> -->
                                        <button id="submit" class="form-submit-button" style="height:60px; width:200px; margin:auto; position:fixed; top:50px; right:50px;">Submit</button>
                                    HTML;
                            } else {
                                $sumitButton =
                                    <<<HTML
                                        <!-- <button id="submit-button" class="form-submit-button btn btn-lg btn-success">Submit</button> -->
                                    <button id="submit" class="form-submit-button btn btn-lg btn-success">Submit</button>
                                    HTML;
                            }
                            echo $sumitButton;
                            ?>
                        </div>
                    </form>
                </div>
            </main>
            <footer>
                <?php
                Required::footer();
                ?>
            </footer>
        </div>

        <script>
            var baseUrl = '<?php echo BASE_URL; ?>';
            var isNewApplicant = '<?php echo $isNewApplicant ? "yes" : "no" ?>';
        </script>
        <?php
        Required::jquery()->hamburgerMenu()->sweetModalJS()->airDatePickerJS()->moment()->mobileValidator()->swiftSubmit()->swiftChanger()->swiftNumericInput();
        ?>
        <script src="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.min.js" ;></script>
        <script src="js/hc-written-exam-application-form.js?v=<?= $dateTime->now()->asFormat("Y-m-d-H-i-s") ?>"></script>

    </body>

    </html>
<?php
    // ob_end_flush();
} catch (\Exception $exp) {
    $logger->createLog($exp->getMessage());
   
    exit("<script>location.href = '" . BASE_URL . "sorry.php?msg=';</script>");
}
?>