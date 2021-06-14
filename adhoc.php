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
    <title>Adhoc Committee - <?= ORGANIZATION_FULL_NAME ?></title>
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
            padding:66px 0 ;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        thead{
            background-color: rgba(255, 255, 255, 0.7);
    color: #3d3c3c;
    text-align: left;
        }

        tbody tr:nth-child(odd) {
            background-color: rgba(255,255,255,0.1);
        }

        tbody tr:nth-child(even) {
            background-color: rgba(255,255,255,0.2);
        }

        td {
            vertical-align: top;
            padding: 10px !important;
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
                    <h1 class="text-center" style="color:white;">Adhoc Committee</h1>
                    <table>
                        <thead>
                            <tr><th>SL</th><th>NAME</th><th>POSITION</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>MU MAHBUBUL ALAM</td><td>PRESIDENT</td></tr>
                            <tr><td>2</td><td>MD. JAKIR HOSSEN</td><td>REPRESENTATIVE OF TEACHERS</td></tr>
                            <tr><td>3</td><td>MD. ABUL QASHEM</td><td>REPRESENTATIVE OF GUARDIANS</td></tr>
                            <tr><td>4</td><td>MD. USUF ALI</td><td>MEMBER SECRETARY</td></tr>
                        </tbody>
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