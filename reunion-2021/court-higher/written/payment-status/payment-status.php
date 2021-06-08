<?php
require_once("../../../Required.php");

Required::SwiftLogger()
    ->ZeroSQL(2)
    ->SwiftDatetime()
    ->EnDecryptor()
    ->SwiftJSON()
    ->Helpers();

$logger = new SwiftLogger(ROOT_DIRECTORY, false);
$endecrytor = new EnDecryptor();
$db = new ZeroSQL();
$db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);
$db->connect();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment Status - <?=ORGANIZATION_FULL_NAME?></title>
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
                <h2 class="text-center margin-bottom-25">Payment Status</h2>
                <form action="<?=BASE_URL?>/court-higher/written/payment-status/payment-status_.php" method="post" class="small box-shadow padding-all-25">
                
                    <div class="field">
                        <label class="required">Registration No.</label>
                        <input type="text" name="regNo" class="validate" 
                        data-swift-title="Registration No."
                        data-swift-required="required" 
                        data-swift-datatype="integer"
                        data-swift-maxlen="11" >
                    </div>

                    <div class="field">
                        <label class="required">Year</label>
                        <input type="text" name="regYear" class="validate" 
                                data-swift-required="required" 
                                data-swift-title="Registration Year"
                                data-swift-maxlen="4"
                                data-swift-datatype="integer">
                    </div>
                    
                    <div class="field">
                        <label class="required">User Id</label>
                        <input type="text" value="" name="userId" class="validate" maxlength="12" data-swift-title="User Id" data-swift-required="required" data-swift-maxlen="12">
                    </div>

                    <input id="submitButton" type="submit" class="btn btn-dark btn-large form-submit-button" value="Check">
                    <!-- <a class="recover" href="auth/recover-user-id.php">Forget User ID? Click here to recover.</a> -->
                    <div id="paymentResponse" style="margin-left: 159px; margin-top: 20px; font-weight: 800;"></div>
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
        Required::jquery()->hamburgerMenu()->sweetModalJS()->swiftSubmit();
    ?>
    <script>
        var base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script>
        $(function(){
            //options,validationRules, onBeforeSend, onSuccess, onError, onComplete
            function onSuccess(response){
                $json = JSON.parse(response);
                console.log(response.message);
                $("#paymentResponse").html($json.message);
                $("#submitButton").removeAttr('disabled').val("Check");
            }
           $("form").swiftSubmit({redirect: false},null, null, onSuccess, null, null);
        })
    </script>

</body>

</html>