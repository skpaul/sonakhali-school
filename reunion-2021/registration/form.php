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
        <title>Reunion-2021</title>
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


            form.classic label {
                font-size: 12px;
            }

            .btn {
                background-color: #dcdcdc !important;
                border: 2px solid #6b6b6b !important;
                color: #0a0909 !important;
                padding-top: 2px;
                padding-bottom: 2px;
            }

            #left-first {
                position: fixed;
                width: 400px;
                height: auto;
                left: -50px;
                top: 90px;
                opacity: 0.3;
            }

            #right-first {
                position: fixed;
                width: 400px;
                height: auto;
                right: -50px;
                bottom: 70px;
                opacity: 0.3;
            }

            .edu-row {
                display: flex;
            }

            .edu-row input {
                margin-top: 0 !important;
            }

            .edu-col-1 {
                width: 20%;
            }

            .edu-col-2 {
                width: 30%;
            }

            .edu-col-3 {
                width: 50%;
            }
        </style>

    </head>

    <body>
        <div class="master-wrapper">
            <main id="applicant-info">
                <h2 class="text-center">Registration Form</h2>

                <img id="left-first" src="../assets/images/2.png">

                <div class="container">
                    <form class="classic" style="max-width: 650px; margin:auto;" id="application-form" action="form-s.php" method="post" enctype="multipart/form-data">

                        <!-- General info starts -->
                        <section class="formSection">
                            <div class="row">
                                

                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Name</label>
                                        <input name="name" class="validate formControl upper-case" type="text"   data-swift-required="required">
                                    </div>
                                </div>

                            </div>

                            <!-- Father & mother starts -->
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Father's Name</label>
                                        <input name="fatherName" class="validate formControl upper-case" type="text"  data-swift-required="required">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Mother's Name</label>
                                        <input name="motherName" class="validate formControl upper-case" type="text"  data-swift-required="required">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Gender</label>
                                        <select name="gender" class="validate formControl" data-swift-required="required">
                                            <option value=""></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Date of Birth</label>
                                        <input name="dob" class="validate swiftDate formControl"  data-swift-required="required" data-swift-datatype="date" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Contact Number</label>
                                        <input name="contactNo" class="validate swiftInteger formControl" data-swift-required="required" data-swift-datatype="mobile" type="text" maxlen="11">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="">Email</label>
                                        <input name="email" data-swift-required="optional" class="validate lower-case formControl" type="text" data-swift-datatype="email" data-swift-maxlen="40" data-swift-title="Email" value="" title="Email Address">
                                    </div>
                                </div>
                            </div>

                            <img id="right-first" src="../assets/images/1.png" alt="">

                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="field">
                                        <label class="required">Occupation Details</label>
                                        <textarea name="occupationDetails" class="validate formControl upper-case" data-swift-required="required"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Admitted into class</label>
                                        <select name="admissionClass" class="validate formControl upper-case" data-swift-required="required">
                                            <option>select</option>
                                            <?php
                                                for ($i=1; $i < 11; $i++) { 
                                            ?>
                                                <option value="Class-<?=$i?>">Class-<?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Admission Year</label>
                                        <input name="admissionYear" class="validate formControl swiftNumeric swiftYear" type="text" data-swift-required="required">
                                    </div>
                                </div>
                            </div>
                        </section>



                        <section class="formSection">
                            <!-- Present address starts -->
                            <article style="margin-bottom: 5px;">
                                <h5>Present address</h5>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="field">
                                            <label class="required">Village</label>
                                            <input type="text" name="presentVillage" class="validate formControl" data-swift-required="required" data-swift-maxlen="100" data-swift-title="Present Village">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-12">
                                        <div class="field">
                                            <label class="">Post Code</label>
                                            <input name="presentGpo" class="validate swiftNumeric formControl" data-swift-required="optional" data-swift-exactLen="4" data-swift-title="Present Post Code" type="text" value="" maxlength="4">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
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

                                    <div class="col-lg-6 col-sm-12">
                                        <article class="thana">
                                            <label class="required">Thana/Upazila</label>
                                            <select name="presentThana" id="presentThana" class="presentThana validate formControl" data-swift-required="required" data-swift-title="Present Thana/Upazila">

                                            </select>
                                        </article>
                                    </div>
                                </div>
                            </article>

                            <!-- Permanent address starts -->
                            <article style="margin-bottom: 5px;">
                                <h5>Permanent address</h5>

                                <div class="row">
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="field">
                                            <label class="required">Village</label>
                                            <input type="text" name="permanentVillage" class="validate formControl" data-swift-required="required" data-swift-maxlength="100" data-swift-title="Permanent Village">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="field">
                                            <label class="">Post Code</label>
                                            <input name="permanentGpo" class="validate swiftInteger formControl" data-swift-required="optional" data-swift-exactLen="4" data-swift-title="Permanent Post Code" type="text" value="" maxlength="4">
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
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
                                    <div class="col-lg-6 col-sm-12">
                                        <article class="">
                                            <label class="required">Thana/Upazila</label><img class="label-spinner hidden" src="../../../assets/images/spinner.svg">
                                            <select name="permanentThana" id="permanentThana" class="permanentThana validate formControl" data-swift-required="required" data-swift-title="Permanent Thana/Upazila">

                                            </select>

                                        </article>
                                    </div>


                                </div>
                            </article>
                        </section>

                        <section class="formSection">
                            <h5>Educational Qualifications</h5>
                            <div class="edu-row">
                                <div class="edu-col-1">
                                    <input type="text" value="Exam Name" readonly>
                                </div>
                                <div class="edu-col-2">
                                    <input type="text" value="Passing Year" readonly>
                                </div>
                                <div class="edu-col-3">
                                    <input type="text" value="Institute name" readonly>
                                </div>
                            </div>
                            <div class="edu-row">
                                <div class="edu-col-1">
                                    <input type="text" value="S.S.C" readonly>
                                </div>
                                <div class="edu-col-2">
                                    <input type="text" name="sscYear" class="swiftNumeric swiftYear">
                                </div>
                                <div class="edu-col-3">
                                    <input type="text" name="sscInst">
                                </div>
                            </div>

                            <div class="edu-row">
                                <div class="edu-col-1">
                                    <input type="text" value="H.S.C" readonly>
                                </div>
                                <div class="edu-col-2">
                                    <input type="text" name="hscYear" class="swiftNumeric swiftYear">
                                </div>
                                <div class="edu-col-3">
                                    <input type="text" name="hscInst">
                                </div>
                            </div>

                            <div class="edu-row">
                                <div class="edu-col-1">
                                    <input type="text" value="Graduation" readonly>
                                </div>
                                <div class="edu-col-2">
                                    <input type="text" name="gradYear" class="swiftNumeric swiftYear">
                                </div>
                                <div class="edu-col-3">
                                    <input type="text" name="gradInst">
                                </div>
                            </div>

                            <div class="edu-row">
                                <div class="edu-col-1">
                                    <input type="text" value="Masters" readonly>
                                </div>
                                <div class="edu-col-2">
                                    <input type="text" name="mastersYear" class="swiftNumeric swiftYear">
                                </div>
                                <div class="edu-col-3">
                                    <input type="text" name="mastersInst">
                                </div>
                            </div>

                            <br>
                            <br>
                            If not passed S.S.C, then fillup the following info-
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="">Dropout Class</label>
                                        <select name="dropOutClass" class="formControl upper-case" data-swift-required="required">
                                            <option value="">select</option>
                                            <?php
                                                for ($i=1; $i < 11; $i++) { 
                                            ?>
                                                <option value="Class-<?=$i?>">Class-<?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="">Dropout Year</label>
                                        <input name="dropOutYear" class="validate formControl swiftNumeric swiftYear" type="text" data-swift-required="optional" data-swift-datatype="integer" data-swift-maxlen="4">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="formSection">
                            <h5>Registration Payment Details</h5>
                        <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                <div class="field">
                                        <label class="required">Registration Fee Amount</label>
                                        <input name="feeAmount" class="validate swiftFloat formControl" data-swift-required="required" type="text" maxlen="4">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Payment Date</label>
                                        <input name="paymentDate" class="validate swiftDate formControl"  data-swift-required="required" data-swift-datatype="date" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Paid To (School bKash No.)</label>
                                        <input name="schoolBkashNo" class="validate swiftInteger formControl" 
                                                value="01914762300"
                                        data-swift-required="required" data-swift-datatype="mobile" 
                                        type="text" maxlen="11" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="field">
                                        <label class="required">Paid From (your bKash No.)</label>
                                        <input name="senderBkashNo" class="validate swiftInteger formControl" data-swift-required="required" data-swift-datatype="mobile" type="text" maxlen="11">
                                    </div>
                                </div>
                               
                            </div>
                        </section>

                        <section class="formSection  padding-all-25 margin-bottom-25">
                            
                            <!-- Photo upload starts -->
                            <?php
                            $photo_path = BASE_URL . "/assets/images/default-photo.jpg";
                            $signature_path = BASE_URL . "/assets/images/default-signature.jpg";
                         
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

                              
                            </div>
                            <!-- Photo upload ends -->

                          

                          


                        </section>

                        <div id="submitSection">
                           
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
               sdf
            </footer>
        </div>

        <script>
            var baseUrl = '<?php echo BASE_URL; ?>';
        </script>
        <?php
        Required::jquery()->sweetModalJS()->airDatePickerJS()->moment()->mobileValidator()->swiftSubmit()->swiftNumericInput();
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