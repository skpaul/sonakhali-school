<?php

require_once("../Required.php");

Required::SwiftLogger()
    ->Session()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor();

$session = new Session();
$session->start();
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$logger = new SwiftLogger(ROOT_DIRECTORY);
$isLoggedIn = false;
if($session->has("isLoggedIn")){
    $isLoggedIn = true;
}
else{
    header('Location:' . BASE_URL . "session-expired.php", true, 303);
}

$applicantId = $session->get("applicantId");
$postId = $session->get("postId");
$applicant = $db->select()->from("cinfo")->find($applicantId);
$higher_education = $db->select()->from("higher_educations")->where("applicantId")->equalTo($applicantId)->single();

$datetime = new SwiftDatetime();
$now = $datetime->now()->asYmdHis();
$post = $db->select()->from("post_configurations")->find($postId);
$reference = $post->reference;


//Check the datetime limitations------>
$isAdmitCardAvailable = true;
$admitCardStart = $datetime->value($post->admit_card_start_datetime)->asObject();
if(!isset($admitCardStart) || empty($admitCardStart)){
    $isAdmitCardAvailable = false;
    $message = "Admit card is not available right now.";
}
else{
    $admitCardEnd = $datetime->value($post->admit_card_end_datetime)->asObject();
    $currentDatetime = $datetime->now()->asObject();
    if($currentDatetime < $admitCardStart){
        $isAdmitCardAvailable = false;
        $message= 'Admit card will be available from '. $datetime->value($admitCardStart)->ashis() .' on ' . $datetime->value($admitCardStart)->asdmY(). '.';
    }
    if($currentDatetime > $admitCardEnd){
        $isAdmitCardAvailable = false;
        $message = 'Last date of submission expired at '. $datetime->value($admitCardEnd)->ashis() .' on ' . $datetime->value($admitCardEnd)->asdmY(). '.';
    }
}



//<-------Check the datetime limitations

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admit Card - Bangladesh Judicial Service Commission</title>
        <?php
        require_once(ROOT_DIRECTORY . '/inc/favicon.php');
        Required::teletalkCSS()->gridCSS();
        ?>
       
    </head>

    <body>
        <div class="master-wrapper">
            <header>
                <?php
                    require_once(ROOT_DIRECTORY . '/inc/header.php');
                    echo prepareHeader($isLoggedIn);
                ?>
            </header>
            <main>
                <?php
                    if(!$isAdmitCardAvailable){
                        $html =<<<HTML
                            <div class="container">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Attention!</strong> $message
                                </div>
                            </div>
                            HTML;
                        echo $html;
                       
                    }
                    else {
                      
                ?>
                        <div class="container">
                            <div class="text-center margin-bottom-25">
                                <button type="button" class="create-pdf btn btn-dark btn-large">Download</button>
                            </div>
                        </div>

                        <div id="pdfdiv" class="non-responsive printable" style="border: 1px solid; margin:0 auto; width: 660px; padding: 10px 20px;">

                            <!-- header -->
                            <section>
                                <div class="header">
                                    <div class="left">
                                        <div class="brand" style="display: flex;">
                                            <div>
                                                <img class="logo" src="<?= BASE_URL ?>assets/images/bjsc-logo-big.png">
                                            </div>
                                            <div class="govt-org">
                                                <div class="govt">
                                                    Government of the People's Republic of Bangladesh</div>
                                                <div class="organization">Bangladesh Public Service Commission</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div>
                                            Admit Card
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- applicant's biodata -->
                            <section class="margin-bottom-20 border-bottom">
                                <div class="margin-bottom-10">
                                    <div class="grid border-bottom">
                                        <div class="col-auto">
                                            <div class="field">
                                                <label class="border-right">User ID</label>
                                                <div class="text"><?= $applicant->invoiceCode ?></div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="field">
                                                <label class="border-right border-left">Post Name</label>
                                                <div class="text"><?= strtoupper($post->post_name) ?></div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="field">
                                                <label class="border-right border-left">Reference</label>
                                                <div class="text"><?= strtoupper($post->reference) ?></div>
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

                                                    <label class="border-right width-3">Name</label>
                                                    <div class="text"><?= $applicant->applicant_name; ?></div>
                                                </div>

                                                <div class="field border-bottom">
                                                    <label class="border-right width-3">Father</label>
                                                    <div class="text"><?= $applicant->father_name; ?></div>
                                                </div>

                                                <div class="field border-bottom">
                                                    <label class="border-right width-3">Mother</label>
                                                    <div class="text"><?= $applicant->mother_name; ?></div>
                                                </div>
                                                <div class="field border-bottom">
                                                    <label class="border-right width-3">Date of Birth</label>
                                                    <div class="text"><?= $datetime->value($applicant->date_of_birth)->asdmY(); ?></div>
                                                </div>
                                                <div class="field border-bottom">
                                                    <label class="border-right width-3">Place of Birth</label>
                                                    <div class="text"><?= $applicant->place_of_birth; ?></div>
                                                </div>
                                                <div class="field">
                                                    <label class="border-right width-3">Gender</label>
                                                    <div class="text"><?= $applicant->gender; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                        $photoPath = BASE_URL . "applicant-images/photos/" . $applicant->invoiceCode . ".jpg";
                                        ?>
                                        <img src="<?= $photoPath ?>">
                                    </div>
                                </div>
                            </section>


                            <!-- General instructions -->
                            <section class="margin-bottom-10">
                                <div class="grid">
                                    <div class="col-auto">
                                        <div class="field vertical border-bottom">
                                            <label>General instructions</label>
                                            <div class="instructions">
                                                <ol>
                                                    <li >This Admit Card is valid for preliminary, written and oral (viva voce) examination and must be carried with the examinee during
                                                        every examination.</li>
                                                    <li style="font-weight: bold;">It is strictly prohibited to bring bag, book, calculator, electronic clock, wristwatch, mobile phone, any other type of data transmitting
                                                        device in the examination centre. </li>
                                                    <li >  Examinee must enter the examination centre at least 30 minutes prior to the start of examination.</li>
                                                    <li >Examinee must not be allowed to enter the examination hall after the distribution of question paper. </li>

                                                        <li >Only the black ink ball point pen can be used for filling up the OMR sheet of the preliminary examination. </li>
                                                    <li > Examinee must not leave the hall before the preliminary examination ends and prior to lapse of 1(one) hour since the start of
                                                        written examination, excepting unavoidable reasons. </li>
                                                    <li >The signature of the examinee must be same on all the examination related documents e.g. application, attendance sheet, answer
                                                        script etc. </li>
                                                    <li >Examinee is required to report 30 minutes prior to the scheduled time of viva voce and to produce the original copies of all of
                                                        her/his necessary documents. </li>
                                                    <li> Examinee, found guilty of adopting unfair means, copying, misconduct, misbehaviour and anything tantamount to the infringement
                                                        of instruction, must be expelled by the principal invigilator, on the basis of the report submitted by the invigilator concerned of the
                                                        examination centre.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>


                            <section>
                                <div class="authority">
                                    <div>
                                        <strong>Controller of Examinations</strong><br>
                                        Bangladesh Judicial Service Commission Secretariat Dhaka. <br>
                                        <i>[Electronically generated, signature not required]</i>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <footer>
                                    <div class="copyright">
                                        ©2020, Bangladesh Bar Council, All Rights Reserved.
                                    </div>

                                    <div class="powered-by">
                                        Powered By:
                                        <a href="http://www.teletalk.com.bd/" target="_blank">
                                            <img class="logo" alt="teletalk Logo" title="Powered By: Teletalk" src="<?= BASE_URL ?>assets/images/teletalk-logo.png">
                                        </a>
                                    </div>
                                </footer>
                            </section>
                        </div>
                <?php
                    }
                ?>
            </main>
            <footer>
                <?php
                require_once(ROOT_DIRECTORY . '/inc/footer.php');
                ?>
            </footer>
        </div>

        <?php
            Required::jquery()->hamburgerMenu()->html2pdf();
        ?>
        <script>
            $(function() {
                $(".create-pdf").click(function() {
                    var element = document.getElementById('pdfdiv');
                    var opt = {
                        margin: 0.5,
                        filename: 'Applicant-Info.pdf',
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