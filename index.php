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
            /* background-image: url(assets/images/5.jpg);
            background-size: cover; */

            background-image: url(photo-collage.png);
    /* background-size: cover; */
    background-repeat: no-repeat;
    background-position: center;
        }

        marquee{
            font-size: 23px;
            color: red;
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

        <marquee direction="left" onmouseover="this.stop();"
           onmouseout="this.start();">
        Registration for re-union-2021 will be continued upto 31st July, 2021. 
        
        <a href="<?=BASE_URL?>/reunion-2021/registration/intro.php">Register Now</a>
        </marquee>
        <div class="background">
                    <div class="cube" style="background-color: red;"></div>
                    <div class="cube" style="background-color: #B7885E;"></div>
                    <div class="cube" style="background-color: #C9D8DF;"></div>
                    <div class="cube" style="background-color: #e4af28;"></div>
                    <div class="cube" style="background-color: red;"></div>
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