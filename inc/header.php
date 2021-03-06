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
        
        $registrationUrl =  BASE_URL . "/reunion-2021/registration/intro.php";
        $applicantCopyUrl =  BASE_URL . "/reunion-2021/registration-copy/index.php";
        $aboutUrl =  BASE_URL . "/about.php";
        $teachersUrl =  BASE_URL . "/teachers.php";
        $adhocUrl =  BASE_URL . "/adhoc.php";
        
        $menu .= 
        <<<HTML
            <li><a style="color: red;" href="$registrationUrl">Re-union 2021</a></li>
            <li><a href="$applicantCopyUrl">Registration Copy</a></li>
            <li><a href="$teachersUrl">Teachers & Staffs</a></li>
            <li><a href="$adhocUrl">Adhoc Committee</a></li>
            <li><a href="$aboutUrl">About</a></li>
        HTML;
      
        $logoSrc = sprintf("%s/assets/images/govt-logo.png", BASE_URL);
        $hamburgerSrc = sprintf("%s/assets/images/hamburger-1.png", BASE_URL);

        $html = 
            <<<HTML
                    <div class="top">
                        <div class="left">
                            <div class="brand">
                                <!-- <div class="logo-container">
                                    <img class="logo" src="$logoSrc" alt="Bangladesh Govt. Logo">
                                </div> -->
                                <div class="govt-org">
                                    <div class="organization">$organizationFullName</div>
                                    <div class="govt">ESTD: 1935, P.O: Sonakhali, PS: Amtali, Dist: Barguna</div>
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

