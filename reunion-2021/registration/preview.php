<?php

require_once("../../Required.php");


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

$applicant = $db->select()->from("registration")->find($applicantId);

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
                                <!-- <div>
                                    <img class="logo" src="<?= BASE_URL ?>/assets/images/govt-logo.png">
                                </div> -->
                                <div class="govt-org">
                                    <div class="govt">
                                    ESTD: 1935, P.O: Sonakhali, PS: Amtali, Dist: Barguna</div>
                                    <div class="organization" style="font-size: 25px;"><?= ORGANIZATION_FULL_NAME ?></div>
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
                <div class="grid border-bottom">
                                <div class="col-6">
                                    <div class="field">
                                        <label class="border-right">Registration No.</label>
                                        <div class="text"><?= $applicant->id ?></div>
                                    </div>
                                </div>
                            
                                <div class="col-auto">
                                    <div class="field">
                                        <label class="border-right border-left">Date</label>
                                        <div class="text">
                                            <?php
                                                $appliedDatetime = $datetime->value($applicant->appliedDatetime)->asdmY();
                                                echo $appliedDatetime;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

<br>
                    <!-- .special-row is used to show applicant's photo on right side. -->
                    <div class="special-row">
                        <div>
                            <div class="grid no-border">
                                <div class="col-12 flex column">
                                    <div class="field border-bottom">
                                        <label class="border-right fixed-width">Name</label>
                                        <div class="text"><?= $applicant->name; ?></div>
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
                                        <label class="border-right fixed-width">Contact No.</label>
                                        <div class="text"><?= $applicant->contactNo ?></div>
                                    </div>
                                    <div class="field ">
                                        <label class="border-right fixed-width">Email</label>
                                        <div class="text"><?= $applicant->email ?></div>
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
                            <div class="field">
                                <label class="border-right fixed-width">Admission Class</label>
                                <div class="text"><?= $applicant->admissionClass ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Admission Year</label>
                                <div class="text"><?= $applicant->admissionYear ?></div>
                            </div>
                        </div>
                    </div>


                    <!-- Permanent & Present Address -->
                    <div class="grid">
                        <div class="col-auto">
                            <div class="field ">
                                <label class="border-right  fixed-width">Present Address</label>
                                <div class="text">
                                    <b>Village: </b> <?php echo strtoupper($applicant->presentVillage); ?> 
                                    <b>Thana: </b><?php echo strtoupper($applicant->presentThana); ?> 
                                    <b>District: </b><?php echo strtoupper($applicant->presentDist); ?>
                                    <b>Post Code: </b><?php echo strtoupper($applicant->presentGpo); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid">
                        <div class="col-auto">
                            <div class="field ">
                                <label class="border-right fixed-width">Permanent Address</label>
                                <div class="text">
                                    <b>Village: </b> <?php echo strtoupper($applicant->permanentVillage); ?> 
                                    <b>Thana: </b><?php echo strtoupper($applicant->permanentThana); ?> 
                                    <b>District: </b><?php echo strtoupper($applicant->permanentDist); ?>
                                    <b>Post Code: </b><?php echo strtoupper($applicant->permanentGpo); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field ">
                                <label class="border-right  fixed-width">Occupation</label>
                                <div class="text">
                                    <b>Occupation: </b> <?php echo strtoupper($applicant->occupation); ?> 
                                    <b>Organization: </b><?php echo strtoupper($applicant->orgName); ?> 
                                    <b>District: </b><?php echo strtoupper($applicant->orgDist); ?>
                                    <b>Thana: </b><?php echo strtoupper($applicant->orgThana); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-auto">
                            <div class="field border-right">
                                <label class="border-right fixed-width">Dropout Class</label>
                                <div class="text"><?= $applicant->dropOutClass ?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right">Drouout Year</label>
                                <div class="text"><?= $applicant->dropOutYear ?></div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>S.S.C</td>
                                        <td><?php echo $applicant->sscYear; ?></td>
                                        <td><?php echo strtoupper($applicant->sscInst); ?></td>
                                    </tr>
                                    <tr>
                                        <td>H.S.C</td>
                                        <td><?php echo $applicant->hscYear; ?></td>
                                        <td><?php echo strtoupper($applicant->hscInst); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Graduation</td>
                                        <td><?php echo $applicant->gradYear; ?></td>
                                        <td><?php echo strtoupper($applicant->gradInst); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Post Graduation</td>
                                        <td><?php echo $applicant->mastersYear; ?></td>
                                        <td><?php echo strtoupper($applicant->mastersInst); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ===================================== -->
                        </div>
                    </div>



                    <div class="grid">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">Fee Amount</label>
                                <div class="text"><?= $applicant->feeAmount ?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right border-left fixed-width">Date of Payment</label>
                                <div class="text"><?= $datetime->value($applicant->paymentDate)->asdmY() ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid border-bottom">
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right fixed-width">School bKash No.</label>
                                <div class="text"><?= $applicant->schoolBkashNo?></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="field">
                                <label class="border-right border-left fixed-width">Sender bKash No.</label>
                                <div class="text"><?= $applicant->senderBkashNo ?></div>
                            </div>
                        </div>
                    </div>
                    <br>                   
                </section>

                <section>
                    <footer>
                        <div class="copyright">
                            ©<?php echo date("Y"); ?>, <?= ORGANIZATION_FULL_NAME ?>, All Rights Reserved.
                        </div>

                        <div class="powered-by">
                            Dev Team:
                            <a href="https://winbip.com/" target="_blank">
                                <img class="logo" alt="Winbip Logo" title="Powered By: Winbip" src="<?= BASE_URL ?>/assets/images/winbip-logo.png">
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