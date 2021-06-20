<?php
require_once("../../Required.php");

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




try {
    //code...

?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Reunion-2021</title>

        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PHR09TLL18"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PHR09TLL18');
</script>

        <?php
        Required::metaTags()->favicon()->teletalkCSS()->bootstrapGrid()->sweetModalCSS()->airDatePickerCSS();
        ?>

        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.structure.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>/assets/js/plugins/jquery-ui/jquery-ui.theme.min.css" rel="stylesheet">
        <link href="css/animation.css" rel="stylesheet">

        <!-- <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet"> -->

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">

        <style>
            .formSection {
                margin-bottom: 50px !important;
            }


          p.p{
            line-height: 1.5;
            margin-bottom: 25px;
            /* font-family: 'Great Vibes', cursive; */
            font-family: 'Courgette', cursive;
            font-size: 18px;
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

            .register-link{
                text-decoration: none;
                border: 1px solid gray;
                border-radius: 23px;
                padding: 6px;
                color: gray;

            }

            .register-link:hover{
                background-color: black;
                color: white;
            }


          
        </style>

    </head>

    <body>
        <div class="master-wrapper">
            <header>
                <?php
                require_once(ROOT_DIRECTORY . '/inc/header.php');
                echo prepareHeader(ORGANIZATION_FULL_NAME, "");
                ?>
            </header>
            <main id="applicant-info">
                <h2 class="text-center" style=" font-family: 'Courgette', cursive;">Re-union-2021</h2>



                <img id="right-first" src="<?= BASE_URL ?>/assets/images/1.png" alt="">

                <img id="left-first" src="<?= BASE_URL ?>/assets/images/2.png">

                <div class="container">

                    <div style="max-width: 500px; margin: 0 auto; text-align: justify;">
                        <p class="p">
                        This is an immense pleasure to announce that the first-ever Re-union of the school is going to be held soon.
                        </p>

                        <p class="p">
                        Relive those old golden cherished memories. Reconnect with the "buddies and mates" you missed over the decade.
                        Reminisce about days gone by and share in life experiences both old & new.
                        </p>

                        <p class="p">
                        The event would be honoured and glorius with your sincere cooperation & spontaneous participation.
                        </p>
                        <p class="p" style="font-weight: bold;">
                        
                        Be There
                        </p>

                        <!-- <div class="anim">Registration will start soon!!!</div> -->
                        <a class="register-link" href="<?=BASE_URL?>/reunion-2021/registration/form.php">Register Now</a>
                    </div>
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