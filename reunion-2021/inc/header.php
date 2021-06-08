<?php
    function prepareHeader($organizationFullName = ""){
        // $numberOfArguments = func_num_args();
        // $arguments = func_get_args();
        // $isLoggedIn = $arguments[0];
        // $queryString = "";
        // if($numberOfArguments>1)
        //     $queryString = "?".  $arguments[1];
            
        // $homeUrl = sprintf("%sindex.php%s",BASE_URL, $queryString);
        $homeUrl = BASE_URL . "/index.php";
        $menu = 
        <<<HTML
            <li><a href="$homeUrl">Home</a></li>
        HTML;
        
        $applicantCopyUrl =  BASE_URL . "/court-higher/written/applicant-copy/index.php";
        $admitCardUrl =  BASE_URL . "/admit-card/index.php";
        // $admitCardUrl = sprintf('href="%sadmit-card/admit-card.php%s"',BASE_URL, $queryString);
        // $paymentStatusUrl = sprintf('href="%spayment-status/payment-query.php%s"',BASE_URL, $queryString);
        $paymentStatusUrl = BASE_URL . "/court-higher/written/payment-status/payment-status.php";

        
        $menu .= 
        <<<HTML
            <li><a href="$applicantCopyUrl">Applicant Copy</a></li>
            <li><a href="#">Admit Card</a></li>
            <li><a href="$paymentStatusUrl">Payment Status</a></li>
            <li><a href="https://www.photobip.com" target="_blank">Photo Resizer</a></li>
            <li><a href="#">Help</a></li>
           
        HTML;
      
        $logoSrc = sprintf("%s/assets/images/govt-logo.png", BASE_URL);
        $hamburgerSrc = sprintf("%s/assets/images/hamburger-1.png", BASE_URL);

        $html = 
            <<<HTML
                    <div class="top">
                        <div class="left">
                            <div class="brand">
                                <div class="logo-container">
                                    <img class="logo" src="$logoSrc" alt="Bangladesh Govt. Logo">
                                </div>
                                <div class="govt-org">
                                    <div class="govt">Government of the People's Republic of Bangladesh</div>
                                    <div class="organization" style="font-size:17px">$organizationFullName</div>
                                </div>
                            </div>         
                        </div>
                        <div class="right mobile-menu">
                            <div class="hamburger-icon-container">
                            <a href="javascript:void(0);" class="icon" onclick="hamburgerMenu()">  
                                <img class="hamburger" src="$hamburgerSrc" alt="Mobile Menu">
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="nav-container" id="nav-container">
                            <nav class="top-nav">
                                <ul>
                                    $menu
                                </ul>
                            </nav> 
                        </div>
                    </div>
            HTML;

        return $html;
    }
?>

