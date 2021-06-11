<?php
    require_once("Required.php");
   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Couldn't Continue - BJSC</title>
        <?php
        Required::metaTags()->favicon()->teletalkCSS();
        ?>
    </head>

    <body>
        <div class="master-wrapper">
            <header>
                <?php
                    require_once(ROOT_DIRECTORY . '/inc/header.php');
                    echo prepareHeader(false)
                ?>
            </header>

            <main style="display: flex; flex-direction: column; align-items: center; height: 100vh;">

                <div><img style="height: 243px;" src="<?= BASE_URL ?>/assets/images/sorry-3.jpg"></div>

                <div style="font-family: ARIAL, sans-serif; font-size: 47px; color: darkgray;  margin-bottom: 5px;">Couldn't Continue</div>
                <div style="font-family: ARIAL, sans-serif; font-size: 20px; padding: 20px; color: #5e6161;">That is all we know at this moment. If you're middle of something, sorry for the inconvenience.</div>

                <a href="<?php echo BASE_URL; ?>" style="background-color: #4db240; padding: 20px; text-decoration: none; color: white; font-family: arial, sans-serif; letter-spacing: 0.04245rem; border-radius: 7px;">start again</a>

            </main>
            <footer>
                <?php
                Required::footer();
                ?>
            </footer>
        </div>
    </body>

</html>