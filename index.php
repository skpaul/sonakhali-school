<?php
require_once("Required.php");

Required::SwiftLogger()
    ->ZeroSQL()
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Helpers();


$logger = new SwiftLogger(ROOT_DIRECTORY, false);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
// $db->connect();

$year = date("Y");
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Home - <?=ORGANIZATION_FULL_NAME?></title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PHR09TLL18"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-PHR09TLL18');
        </script>

        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

        <?php
        Required::metaTags()->favicon()->teletalkCSS()->sweetModalCSS()->bootstrapGrid();
        ?>

       
<link href="index1.css" rel="stylesheet">
        <style>
        .master-wrapper {
            background-image: url(assets/images/5.jpg);
            background-size: cover;
        }
        </style>
        
    </head>

<body>

    <div class="master-wrapper">

   

        <header>
            <?php
            require_once(ROOT_DIRECTORY . "/inc/header.php");
            echo prepareHeader(ORGANIZATION_FULL_NAME);
            ?>
        </header>
        <main>

        <div class="background">
                    <div class="cube"></div>
                    <div class="cube"></div>
                    <div class="cube"></div>
                    <div class="cube"></div>
                    <div class="cube"></div>
                </div>
                
            <!-- <div class="container">
               
            </div> -->
        </main>
        <footer>
            <?php
            Required::footer();
            ?>
        </footer>
    </div>


    <?php
    Required::jquery()->hamburgerMenu()->sweetModalJS();
    ?>
    <script>
        $(function() {

         
        })
    </script>

</body>

</html>