<?php
require_once("../../Required.php");

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
        <title>Registration Copy - <?=ORGANIZATION_FULL_NAME?></title>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

        <?php
        Required::metaTags()->favicon()->teletalkCSS()->sweetModalCSS()->bootstrapGrid();
        ?>
        
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
                <h2 class="text-center margin-bottom-25">Registration Copy</h2>
                <form action="applicant-copy_.php" method="post" class="small box-shadow padding-all-25">
                    <div class="field">
                        <label class="required">Registration No.</label>
                        <input type="text" value="" name="regNo" class="validate swiftInteger" data-swift-required="required" data-swift-maxlen="10" data-swift-datatype="integer">
                    </div>
                    
                    <div class="field">
                        <label class="required">Mobile No.</label>
                        <input type="text" name="contactNo" class="validate swiftInteger" maxlength="11" data-swift-required="required"  data-swift-datatype="mobile">
                    </div>
                    
                 
                    

                    <input type="submit" class="btn btn-dark btn-large form-submit-button" value="Submit">
                    <!-- <a class="recover" href="auth/recover-user-id.php">Forget User ID? Click here to recover.</a> -->

                </form>
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

            $(".swiftInteger").swiftNumericInput({ allowFloat: false, allowNegative: false });

            $("form").swiftSubmit({
                redirect: true
            }, null, null, null, null, null);
        })
    </script>

</body>

</html>