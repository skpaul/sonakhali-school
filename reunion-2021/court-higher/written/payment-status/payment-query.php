<?php

require_once("../Required.php");

Required::SwiftLogger()
    ->ZeroSQL()
    ->SwiftDatetime()
    ->EnDecryptor();

$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

$logger = new SwiftLogger(ROOT_DIRECTORY,true);


$applicant = $db->select()->from("applicants")->find($applicantId);


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Payment Status - Bangladesh Judicial Service Commission</title>
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
                    if($applicant->fee){
                        $html =<<<HTML
                            <div class="container">
                                <div class="alert alert-success" role="alert">
                                    <strong>Thanks!</strong> Payment received successfully.
                                </div>
                            </div>
                            HTML;
                        echo $html;
                       
                    }
                    else {
                        $html =<<<HTML
                            <div class="container">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Attention!</strong> Payment has not been received yet.
                                </div>
                            </div>
                            HTML;
                        echo $html;
              
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