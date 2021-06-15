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
    <title>About - <?= ORGANIZATION_FULL_NAME ?></title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PHR09TLL18"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-PHR09TLL18');
    </script>

    <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

    <?php
    Required::metaTags()->favicon()->teletalkCSS()->sweetModalCSS()->bootstrapGrid();
    ?>

    <style>
        .master-wrapper {
            background-image: url(assets/images/5.jpg);
            background-size: cover;
        }

        header {
            background-color: white;
        }

        .tableContainer {
            background-color: rgba(0, 0, 0, 0.3);
            font-size: 23px;
            color: #fff;
            letter-spacing: 0.0225478rem;

        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        tr {
            height: 20px;
        }

        td {
            vertical-align: top;
            padding: 10px !important;
        }

        tr>td:first-child {
            font-weight: bold;
        }
    </style>

</head>

<body>
    <!-- <div id="version"></div> -->
    <div class="master-wrapper">
        <header>
            <?php
            require_once(ROOT_DIRECTORY . "/inc/header.php");
            echo prepareHeader(ORGANIZATION_FULL_NAME);
            ?>
        </header>
        <main>
            <div class="container">

                <div class="tableContainer">
                    <table>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>UTTAR SONAKHALI SCHOOL &amp; COLLEGE</td>
                        </tr>
                        <tr>
                            <td>EIIN No.</td>
                            <td>:</td>
                            <td>100116</td>
                        </tr>
                        <tr>
                            <td>Established on</td>
                            <td>:</td>
                            <td>1935</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>Village: Sonakhali <br>
                                Post: Sonakhali <br>
                                Police station: Amtali <br>
                                District: Barguna <br></td>
                        </tr>
                        <tr>
                            <td>Education Level</td>
                            <td>:</td>
                            <td> School and College</td>
                        </tr>
                        <tr>
                            <td>Education Gender Type</td>
                            <td>:</td>
                            <td> Co-education</td>
                        </tr>
                        <tr>
                            <td>Contact for Information</td>
                            <td>:</td>
                            <td> 01712700408</td>
                        </tr>
                    </table>

                </div>




            </div>

        </main>
        <footer>
            <?php
            Required::footer();
            ?>
        </footer>
    </div>


    <?php
    Required::jquery()->hamburgerMenu()->sweetModalJS()->swiftSubmit()->swiftNumericInput();
    ?>
    <script>
        var base_url = '<?php echo BASE_URL; ?>';
        $(function() {

            $(".swiftInteger").swiftNumericInput({
                allowFloat: false,
                allowNegative: false
            });

            $("form").swiftSubmit({
                redirect: true
            }, null, null, null, null, null);
        })
    </script>

</body>

</html>