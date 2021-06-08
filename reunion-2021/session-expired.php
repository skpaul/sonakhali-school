<?php
    require_once("Required.php");
    $message = "Session Not Found";

    if(isset($_GET["reason"]) && !empty($_GET["reason"])){
        $reason = trim($_GET["reason"]);
        switch ($reason) {
            case '1':
                $message = "Session Not Found";
                break;
            case '2':
                $message = "Session Expired";
                break;
            default:
                break;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?=$message?></title>
        <?php
        Required::metaTags()->favicon()->teletalkCSS()->bootstrapGrid();
        ?>
    </head>

    <body>
        <div id="master-wrapper">
            <header>
                <?php
                    $isLoggedIn = false;
                    require_once(ROOT_DIRECTORY . '/inc/header.php');
                    echo prepareHeader(ORGANIZATION_FULL_NAME);
                ?>
            </header>

            <main style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">

                <div><img src="<?= BASE_URL ?>/assets/images/session_inactive.png"></div>

                <div style="font-family: ARIAL, sans-serif; font-size: 47px; color: darkgray;  margin-bottom: 50px;"><?=$message?></div>

                <a href="<?php echo BASE_URL; ?>" style="background-color: #4db240; padding: 10px; text-decoration: none; color: white; font-family: arial, sans-serif; letter-spacing: 0.04245rem; border-radius: 7px;">Start again</a>

            </main>
            <footer>
                <?php
                Required::footer();
                ?>
            </footer>
        </div>
    </body>

</html>