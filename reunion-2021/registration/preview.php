<?php

require_once("../../../Required.php");


Required::SwiftLogger()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Validable()
    ->AgeCalculator();


$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$logger = new SwiftLogger(ROOT_DIRECTORY, false);

$applicantId = $endecrytor->decrypt($_GET["id"]);

$applicant = $db->select()->from("hc_written_cinfo")->find($applicantId);
$hEdu = $db->select()->from("hc_written_higher_educations")->where("applicantId")->equalTo($applicantId)->single();

$datetime = new SwiftDatetime();
$now = $datetime->now()->asYmdHis();
// $post = $db->select()->from("post_configurations")->find($postId);
// $reference = $post->reference;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Preivew Application- <?= ORGANIZATION_FULL_NAME ?></title>
    <?php
    Required::metaTags()->favicon()->teletalkCSS();
    ?>

    <script>
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.pushState(null, null, document.URL);
        });
    </script>
    <style>
        .fixed-width label {
            width: 67px;
        }    
    </style>
</head>

<body>
    <div id="master-wrapper">
        <header>
            <?php
            require_once(ROOT_DIRECTORY . '/inc/header.php');
            echo prepareHeader(ORGANIZATION_FULL_NAME);
            ?>
        </header>
        <main>
            <div class="container">
                <div class="text-center margin-bottom-25">
                    <button type="button" class="create-pdf btn btn-dark btn-large">Download</button>
                    <!-- <a href="applicant-info.php" style="text-decoration: none;" class="btn btn-outline-dark" role="button">Back to form</a> -->
                </div>
            </div>

            <div id="pdfdiv" class="non-responsive printable" style="border: 1px solid; margin:0 auto; width: 660px; padding: 10px 20px;">

                <!-- header -->
                <section>
                    <div class="header">
                        <div class="left">
                            <div class="brand" style="display: flex;">
                                <div>
                                    <img class="logo" src="<?= BASE_URL ?>/assets/images/govt-logo.png">
                                </div>
                                <div class="govt-org">
                                    <div class="govt">
                                        Government of the People's Republic of Bangladesh</div>
                                    <div class="organization"><?= ORGANIZATION_FULL_NAME ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div>
                                Applicant's Copy
                            </div>
                        </div>
                    </div>
                </section>

                <!-- applicant's biodata -->
                <section>
                    <div class="fixed-width">
                    <div class="margin-bottom-10">
                        <div class="grid">
                            <div class="col-auto">
                                <div class="field">
                                    <label class="border-right">User ID</label>
                                    <div class="text"><?= $applicant->userId ?></div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="field">
                                    <label class="border-right border-left">Post Name</label>
                                    <div class="text">Application for HC</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="field">
                                    <label class="border-right border-left">Reference</label>
                                    <div class="text"></div>
                                </div>
                            </div>
                        </div>
                        <div class="grid border-bottom">
                            <div class="col-auto">
                                <div class="field">
                                    <label class="border-right">Reg. No.</label>
                                    <div class="text"><?= $applicant->regNo ?></div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="field">
                                    <label class="border-right border-left">Reg. Year</label>
                                    <div class="text"><?= $applicant->regYear ?></div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <!-- <div class="field">
                                    <label class="border-right border-left"></label>
                                    <div class="text"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- .special-row is used to show applicant's photo on right side. -->
                    <div class="special-row">
                        <div>
                            <div class="grid no-border">
                                <div class="col-12 flex column">
                                    <div class="field border-bottom">
                                        <label class="border-right fixed-width">Name</label>
                                        <div class="text"><?= $applicant->fullName; ?></div>
                                    </div>

                                    <div class="field border-bottom">
                                        <label class="border-right fixed-width">Father</label>
                                        <div class="text"><?= $applicant->fatherName; ?></div>
                                    </div>

                                    <div class="field border-bottom">
                                        <label class="border-right fixed-width">Mother</label>
                                        <div class="text"><?= $applicant->motherName; ?></div>
                                    </div>
                                    <div class="flex border-bottom">
                                        <div class="field">
                                            <label class="border-right fixed-width">Date of Birth</label>
                                            <div class="text"><?= $datetime->value($applicant->dob)->asdmY() ?></div>
                                        </div>
                                        <div class="field">
                                            <label class="border-right border-left fixed-width">Gender</label>
                                            <div class="text"><?= $applicant->gender; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="field border-bottom">
                                        <label class="border-right fixed-width">Nationality</label>
                                        <div class="text">Bangladeshi</div>
                                    </div>
                                    <div class="field ">
                                        <label class="border-right fixed-width">NID</label>
                                        <div class="text"><?= $applicant->idNo ?></div>
                                    </div>
                                 
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $photoPath = BASE_URL . "/applicant-images/photos/" . $applicant->userId . ".jpg";
                            ?>
                            <img src="<?= $photoPath ?>">
                        </div>
                    </div>




                    <div class="grid">
                        <div class="col-auto">
                            <div class="field border-right">
                                <label class="border-right fixed-width">Contact Number</label>
                                <div class="text"><?= $applicant->contactNo ?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right">Email</label>
                                <div class="text"><?= $applicant->email ?></div>
                            </div>
                        </div>
                    </div>


                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Pupilage No</label>
                                <div class="text"><?= $applicant->pupilageNo ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Pupilage Of</label>
                                <div class="text"><?= $applicant->pupilageOf ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Bar Assosiation Name</label>
                                <div class="text"><?= $applicant->barAssosiationName ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Senior Advocate Name</label>
                                <div class="text"><?= $applicant->seniorAdvocateName ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- is engaged -->
                    <?php
                    if ($applicant->isEngaged) {
                        $engagement = <<<HTML
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Nature of Engagement</label>
                                            <div class="text">$applicant->natureOfEngagement</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Place of Engagement</label>
                                            <div class="text">$applicant->placeOfEngagement</div>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                    } else {
                        $engagement = <<<HTML
                            <div class="grid">
                                <div class="col-auto">
                                    <div class="field">
                                        <label class="border-right fixed-width">Engagement</label>
                                        <div class="text">No</div>
                                    </div>
                                </div>
                            </div>
                        HTML;
                    }
                    echo $engagement;
                    ?>

                    <!-- is insolvent -->
                    <?php
                    $isDeclaredInsolvent = $applicant->isDeclaredInsolvent ? "Yes" : "No";
                    $html =
                        <<<HTML
                            <div class="grid">
                                <div class="col-auto">
                                    <div class="field">
                                        <label class="border-right fixed-width">Declared Insolvent</label>
                                        <div class="text">$isDeclaredInsolvent</div>
                                    </div>
                                </div>
                            </div>
                        HTML;
                    echo $html;
                    //Dismissal -->
                    if ($applicant->isDismissed) {
                        $dismissalDate = $datetime->value($applicant->dismissalDate)->asdmY();
                        $dismissal = <<<HTML
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Is Dismissed ?</label>
                                            <div class="text">Yes</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right border-left fixed-width">Dismissal Date</label>
                                            <div class="text">$dismissalDate</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Dismissal Reason</label>
                                            <div class="text">$applicant->dismissalReason</div>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                    } else {
                        $dismissal =
                            <<<HTML
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Is Dismissed ?</label>
                                            <div class="text">No</div>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                    }
                    echo $dismissal;
                    //Dismissal ends

                    if ($applicant->isConvicted) {
                        $convictionDate = $datetime->value($applicant->convictionDate)->asdmY();
                        $convictionHtml =
                            <<<HTML
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Is Convicted?</label>
                                            <div class="text">Yes</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right border-left fixed-width">Conviction Date</label>
                                            <div class="text">$convictionDate</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Conviction Particulars</label>
                                            <div class="text">$applicant->convictionParticulars</div>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                    } else {
                        $convictionHtml =
                            <<<HTML
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Is Convicted?</label>
                                            <div class="text">No</div>
                                        </div>
                                    </div>
                                </div>

                            HTML;
                    }

                    echo $convictionHtml;

                    //is cancelled by bar --->
                    $isCancelledByBar = $applicant->isCancelledByBar ? "Yes" : "No";
                    $cancelHtml =
                        <<<HTML
                              <div class="grid">
                                    <div class="col-auto">
                                        <div class="field">
                                            <label class="border-right fixed-width">Is Cancelled by Bar?</label>
                                            <div class="text">$isCancelledByBar</div>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                    echo $cancelHtml;
                    //is cancelled by bar ends
                    ?>



                    <!-- Permanent & Present Address -->
                    <div class="grid">
                        <div class="col-auto">
                            <div class="field vertical ">
                                <label class="border-bottom border-right">Present Address</label>
                                <div class="text">
                                    <b>Address Details: </b> <?php echo strtoupper($applicant->presentAddress); ?> <br>
                                    <b>Thana: </b><?php echo strtoupper($applicant->presentThana); ?> <br>
                                    <b>District: </b><?php echo strtoupper($applicant->presentDist); ?> <br>
                                    <b>Post Code: </b><?php echo strtoupper($applicant->presentGpo); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field vertical">
                                <label class="border-bottom">Permanent Address</label>
                                <div class="text">
                                    <b>Address Details: </b><?php echo strtoupper($applicant->permanentAddress); ?> <br>
                                    <b>Thana: </b><?php echo strtoupper($applicant->permanentThana); ?><br>
                                    <b>District: </b><?php echo strtoupper($applicant->permanentDist); ?> <br>
                                    <b>Post Code: </b><?php echo strtoupper($applicant->permanentGpo); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Educations -->
                    <div class="grid">
                        <div class="col-auto">
                            <!-- ================================ -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Examination/Degree</th>
                                        <th>Year</th>
                                        <th>Board/University/Institute</th>
                                        <th>Division/Class/Grade/CGPA</th>
                                        <th>Major Subject/Group</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $applicant->sscExamName; ?></td>
                                        <td><?php echo $applicant->sscYear; ?></td>
                                        <td><?php echo strtoupper($applicant->sscBoard); ?></td>
                                        <td><?php echo $applicant->sscGpa . " " . $applicant->sscGrade . "" . $applicant->sscDivision; ?></td>
                                        <td><?php echo strtoupper($applicant->sscGroup); ?></td>
                                    </tr>

                                    <tr>
                                        <td><?php echo $applicant->hscExamName; ?></td>
                                        <td><?php echo $applicant->hscYear; ?></td>
                                        <td><?php echo strtoupper($applicant->hscBoard); ?></td>
                                        <td><?php echo $applicant->hscGpa . " " . $applicant->hscGrade . "" . $applicant->hscDivision; ?></td>
                                        <td><?php echo strtoupper($applicant->hscGroup); ?></td>
                                    </tr>

                                    <?php

                                    //LL.B (Hons/Pass) -->
                                    $examName = $hEdu->llbExam;
                                    $llbResultType = $hEdu->llbResultType;
                                    $result = "";
                                    switch (strtolower($llbResultType)) {
                                        case "appeared":
                                            $llbExamConcludedDate = $datetime->value($hEdu->llbExamConcludedDate)->asdmY();
                                            $passingYear  = "Appeared. Concluded date - " . $llbExamConcludedDate;
                                            $result = "Appeared";
                                            break;
                                        case "division":
                                            $passingYear = $hEdu->llbPassingYear;
                                            $result = $hEdu->llbDivision
                                                . ". Obtained Marks-" . $hEdu->llbMarksPercentage . "%";
                                            break;
                                        case "class":
                                            $passingYear = $hEdu->llbPassingYear;
                                            $result = $hEdu->llbClass
                                                . ". Obtained Marks-" . $hEdu->llbMarksPercentage . "%";
                                            break;
                                        case "grading":
                                            $passingYear = $hEdu->llbPassingYear;
                                            $result = $hEdu->llbCgpa
                                                . " out of " . $hEdu->llbCgpaScale;
                                            break;
                                    }

                                    $course_duration = $hEdu->llbCourseDuration . " Years";

                                    $University = $hEdu->llbUni;

                                    $llbDetails = '<tr>
                                                            <td>' .  $examName . '</td>
                                                            <td>' . $passingYear . '</td>
                                                            <td>' . strtoupper($University) . '</td>
                                                            <td>' . $result . '</td>
                                                            <td>-</td>
                                                        </tr>';
                                    echo $llbDetails;
                                    //LL.B (Hons/Pass) ends.

                                    //Graduation (Others)
                                    if ($hEdu->hasOtherGrad) {
                                        $examName = $hEdu->gradOtherExam;
                                        $gradOtherResultType = $hEdu->gradOtherResultType;
                                        $result = "";
                                        switch (strtolower($gradOtherResultType)) {
                                            case "appeared":
                                                $gradOtherExamConcludedDate = $datetime->value($hEdu->gradOtherExamConcludedDate)->asdmY();
                                                $passingYear  = "Appeared. Concluded date - " . $gradOtherExamConcludedDate;
                                                $result = "Appeared";
                                                break;
                                            case "division":
                                                $passingYear = $hEdu->gradOtherPassingYear;
                                                $result = $hEdu->gradOtherDivision
                                                    . ". Obtained Marks-" . $hEdu->gradOtherMarksPercentage . "%";
                                                break;
                                            case "class":
                                                $passingYear = $hEdu->gradOtherPassingYear;
                                                $result = $hEdu->gradOtherClass
                                                    . ". Obtained Marks-" . $hEdu->gradOtherMarksPercentage . "%";
                                                break;
                                            case "grading":
                                                $passingYear = $hEdu->gradOtherPassingYear;
                                                $result = $hEdu->gradOtherCgpa
                                                    . " out of " . $hEdu->gradOtherCgpaScale;
                                                break;
                                        }

                                        $course_duration = $hEdu->gradOtherCourseDuration . " Years";

                                        $University = $hEdu->gradOtherUni;

                                        $gradOtherDetails = '<tr>
                                                                    <td>' .  $examName . '</td>
                                                                    <td>' . $passingYear . '</td>
                                                                    <td>' . strtoupper($University) . '</td>
                                                                    <td>' . $result . '</td>
                                                                    <td>-</td>
                                                                </tr>';
                                        echo $gradOtherDetails;
                                    }
                                    //Graduation (Others) ends




                                    //Masters
                                    if ($hEdu->hasMasters) {
                                        $examName = $hEdu->mastersExam;
                                        $mastersResultType = $hEdu->mastersResultType;
                                        $result = "";
                                        switch (strtolower($mastersResultType)) {
                                            case "appeared":
                                                $mastersExamConcludedDate = $datetime->value($hEdu->mastersExamConcludedDate)->asdmY();
                                                $passingYear  = "Appeared. Concluded date - " . $mastersExamConcludedDate;
                                                $result = "Appeared";
                                                break;
                                            case "division":
                                                $passingYear = $hEdu->mastersPassingYear;
                                                $result = $hEdu->mastersDivision
                                                    . ". Obtained Marks-" . $hEdu->mastersMarksPercentage . "%";
                                                break;
                                            case "class":
                                                $passingYear = $hEdu->mastersPassingYear;
                                                $result = $hEdu->mastersClass
                                                    . ". Obtained Marks-" . $hEdu->mastersMarksPercentage . "%";
                                                break;
                                            case "grading":
                                                $passingYear = $hEdu->mastersPassingYear;
                                                $result = $hEdu->mastersCgpa
                                                    . " out of " . $hEdu->mastersCgpaScale;
                                                break;
                                        }

                                        $course_duration = $hEdu->mastersCourseDuration . " Years";

                                        $University = $hEdu->mastersUni;

                                        $mastersDetails = '<tr>
                                                                    <td>' .  $examName . '</td>
                                                                    <td>' . $passingYear . '</td>
                                                                    <td>' . strtoupper($University) . '</td>
                                                                    <td>' . $result . '</td>
                                                                    <td>-</td>
                                                                </tr>';
                                        echo $mastersDetails;
                                    }
                                    //Masters ends
                                    ?>

                                </tbody>
                            </table>
                            <!-- ===================================== -->
                        </div>
                    </div>



                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Bank Name</label>
                                <div class="text"><?= $applicant->bankName ?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right border-left fixed-width">Branch Name</label>
                                <div class="text"><?= $applicant->branchName ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Fee?</label>
                                <div class="text"><?= $applicant->fee == 1 ? "Yes" : "No" ?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right border-left fixed-width">Draft/Slip No.</label>
                                <div class="text"><?= $applicant->draftOrSlipNo ?></div>
                            </div>
                        </div>
                    </div>




                    <div class="grid">
                        <div class="col-auto">
                            <div class="field border-bottom">
                                <label class="border-right">Declaration</label>
                                <div class="text">
                                    I declare that the information provided in this form is correct, true and complete to the best of my knowledge and belief. If any information is found false, incorrect and incomplete or if any ineligibility is detected before or after the examination, any action can be taken against me by the Commission.
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="signature">
                        <?php
                        $photoPath = BASE_URL . "/applicant-images/signatures/" . $applicant->userId . ".jpg";
                        ?>
                        <img src="<?= $photoPath ?>">
                    </div>
                </section>

                <section>
                    <footer>

                        <div class="copyright">
                            ©<?php echo date("Y"); ?>, <?= ORGANIZATION_FULL_NAME ?>, All Rights Reserved.
                        </div>

                        <div class="powered-by">
                            Powered By:
                            <a href="http://www.teletalk.com.bd/" target="_blank">
                                <img class="logo" alt="teletalk Logo" title="Powered By: Teletalk" src="<?= BASE_URL ?>/assets/images/teletalk-logo.png">
                            </a>
                        </div>
                    </footer>
                </section>
            </div>


        </main>
        <footer>
            <?php
            Required::footer();
            ?>
        </footer>
    </div>

    <?php
    Required::jquery()->hamburgerMenu()->html2pdf();
    ?>
    <script>
        history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function(event) {
            history.pushState(null, document.title, location.href);
        });

        $(function() {
            $(".create-pdf").click(function() {
                var element = document.getElementById('pdfdiv');
                var opt = {
                    margin: 0.5,
                    filename: 'Applicant Copy.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'A4',
                        orientation: 'portrait'
                    }
                };

                html2pdf(element, opt);
            });
        })
    </script>
</body>

</html>