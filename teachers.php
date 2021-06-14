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
    <title>Teachers & Staffs - <?= ORGANIZATION_FULL_NAME ?></title>
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
            padding: 66px 0;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        thead {
            background-color: rgba(255, 255, 255, 0.7);
    color: #3d3c3c;
    text-align: left;
        }

        tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.2);
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
                <h1 class="text-center" style="color:white;">Teachers & Staffs</h1>

                    <table>
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>NAME </th>
                                <th>DESIGNATION</th>
                                <th>INDEX NO.</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>MD. USUF ALI</td>
                                <td>HEADMASTER</td>
                                <td>292839</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>MD. JAHIDUL ISLAM</td>
                                <td>ASSISTANT HEADMASTER</td>
                                <td>2017719</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>SOHELI AKTER</td>
                                <td>SENIOR TEACHER</td>
                                <td>288292</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>MD. JAHANGIR ALAM</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>1063586</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>MD. DULAL MIAH</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>1116633</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>JAKIR HOSSEN</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>1124502</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>MD. NURUL ISLAM</td>
                                <td>MOULVI</td>
                                <td>207077</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>MD. AZIZUL ISLAM</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>1079295</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>SAGAR CHANDRA HAWLADAR</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>1145941</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>SHAHINUR BEGUM</td>
                                <td>ASSISTANT LIBRARIAN</td>
                                <td>1132318</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>MD. KAMAL HOSSEN</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>204803</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>SUPRIYA RANI</td>
                                <td>ASSISTANT TEACHER</td>
                                <td>145948</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>MD. MAMUN MIA</td>
                                <td>OFFICE ASSISTANT</td>
                                <td>1137521</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>MD. BASHIR UDDIN</td>
                                <td>MLSS</td>
                                <td>752623</td>
                            </tr>
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