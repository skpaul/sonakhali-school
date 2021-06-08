<?php
require_once("../Required.php");

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


$logger = new SwiftLogger(ROOT_DIRECTORY, false);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();

$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$dateTime = new SwiftDatetime();
$now = $dateTime->now()->asYmdHis();

$districts = $db->select("name")->from("districts")->orderBy("name")->toList();



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
                           

                         

                           

                            $fathersNameHtml =
                                <<<HTML
                                   
                                HTML;

                            $motherNameHtml =
                                <<<HTML
                                    
                                HTML;

                            $genderOptions =
                                <<<HTML
                                    
                                HTML;

                            $genderCombo = <<<HTML
                                  
                                HTML;
                            ?>


                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                <div class="field">
                                        <label class="required">Name</label>
                                        <input name="fullName" class="validate formControl upper-case" 
                                            type="text" value=""
                                            data-swift-title="Name"
                                            data-swift-required="required"   
                                            data-swift-maxlen="100" 
                                            >
                                    </div>
                                </div>
                            </div>

                            <!-- Father & mother starts -->
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                <div class="field">
                                        <label class="required">Father's Name</label>
                                        <input name="fatherName" class="validate formControl upper-case" 
                                            type="text" value="" 
                                            data-swift-title="Father's Name"
                                            data-swift-required="required"   
                                            data-swift-maxlen="100"
                                            >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                <div class="field">
                                        <label class="required">Mother's Name</label>
                                        <input name="motherName" class="validate formControl upper-case" type="text" value=""
                                            data-swift-title="Mother's name"
                                            data-swift-required="required" 
                                            data-swift-maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <!-- Father & mother ends -->

                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                <div class="field">
                                        <label class="required">Gender</label>
                                        <select name="gender" class="validate formControl" 
                                            data-swift-title="Gender"
                                            data-swift-required="required">
                                            <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="field">
                                        <label class="required">Date of Birth</label>
                                        <input name="dob" class="validate swiftDate formControl" data-swift-title="Date of Birth" data-swift-required="required" data-swift-datatype="date" type="text" autocomplete="off" value="">
                                    </div>
                                </div>
                               
                            </div>

                        </section>
                        <!-- General info ends -->

                        <!-- Contact info starts -->
                        <section class="formSection box-shadow padding-all-25 margin-bottom-25">
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
                                            <label class="required">Village</label>
                                            <input type="text" name="presentVillage" class="validate formControl" data-swift-required="required" data-swift-maxlen="100" data-swift-title="Present Village">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <article class="district">
                                            <label class="required">District</label>
                                            <select name="presentDist" data-districttype="present" class="presentDistrict validate formControl district-combo" data-swift-required="required" data-swift-title="Present District">
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

                                            <select name="permanentDist" data-districttype="permanent" class="permanentDistrict validate formControl district-combo" data-swift-required="required" data-swift-title="Permanent District">
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
                                        <input type="file" title="Applicant's Photo" name="ApplicantPhoto" id="ApplicantPhoto" class="photo formControl" data-swift-required="required" data-swift-title="Applicant's Photo" accept="image/jpeg">
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
                                        <input type="file" title="Applicant's Signature" name="ApplicantSignature" id="ApplicantSignature" class="photo formControl" data-swift-required="required" data-swift-title="Applicant's Signature" accept="image/jpeg">
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
           
        </script>
        <?php
        Required::jquery()->hamburgerMenu()->sweetModalJS()->airDatePickerJS()->moment()->mobileValidator()->swiftSubmit()->swiftChanger()->swiftNumericInput();
        ?>
        <script src="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.min.js" ;></script>
        <script src="js/registration-form.js?v=<?= $dateTime->now()->asFormat("Y-m-d-H-i-s") ?>"></script>

    </body>

    </html>
<?php
    // ob_end_flush();
} catch (\Exception $exp) {
    $logger->createLog($exp->getMessage());
    exit("<script>location.href = '" . BASE_URL . "sorry.php?msg=';</script>");
}
?>