<?php
require_once './Adminfunctions.php';
$isFormRequest = filter_input(INPUT_POST, "submit");
if ($isFormRequest) {
    $type = filter_input(INPUT_POST, "type");
    $id = filter_input(INPUT_POST, "id");
    $password = filter_input(INPUT_POST, "password");
    
    
    $success = false;
    $error_message = "";
} elseif (activateLogin()) { //If session still active
    switch (getAdminType()) {
        case "WEBMASTER":
            header("location: webmaster.php");
            break;
        case "PRO":
            header("location: news.php");
            break;
        case "LIBRARIAN":
            header("location: library.php");
            break;
        default:
            clearAdminCookies();
            break;
    }
}
?>
<!DOCTYPE html>
<!--
Copyright 2015 NACOSS UNN Developers Group (NDG).

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <link href="../css/metro-bootstrap.css" rel="stylesheet">
        <link href="../css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="../css/iconFont.css" rel="stylesheet">
        <link href="../js/prettify/prettify.css" rel="stylesheet">

        <script src="../js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="../js/jquery/jquery.min.js"></script>
        <script src="../js/jquery/jquery.widget.min.js"></script>
        <script src="../js/jquery/jquery.mousewheel.js"></script>
        <script src="../js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="../js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <script src="../js/docs.js"></script>
        <script src="../js/github.info.js"></script>

        <!-- Page Title -->
        <title>CPanel</title>      

    </head>
    <body class="metro">
        <div class="ribbed-darkGreen">
            <div class="container bg-white">            
                <?php require_once './header.php'; ?>
                <div class="padding20">
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <div class="offset3 span6 panel shadow">
                        <h2 class="panel-header bg-grayDark fg-white">
                            NACOSS UNN CPanel
                        </h2>
                        <?php if ($isFormRequest && !$success) { ?>
                            <div class="panel-content">
                                <p class="fg-red"><?= $error_message ?></p>
                            </div>
                        <?php } ?>
                        <div  class="panel-content">                                
                            <form method='post' action='index.php'>
                                <!--Login form-->
                                <div class="grid">
                                    <div class="text-center">
                                        <input type="radio" name="type" value="WEBMASTER" /> Web Master&nbsp;
                                        <input type="radio" name="type" value="PRO"/> PRO &nbsp;
                                        <input type="radio" name="type" value="LIBRARIANS"/> Librarian
                                    </div>
                                    <br/>
                                    <input name="type" value="1" hidden=""/>
                                    <div class="row ntm">
                                        <label class="span1">Username</label>
                                        <div class="span4">
                                            <input class="text" name='id' maxlength="11" style="width: inherit" required type='text' 
                                                   <?= $isFormRequest ? "value='$id'" : ""; ?> tabindex='1' />
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <label class="span1">Password</label>
                                        <div class="span4">
                                            <input class="password" name='password' style="width: inherit" type='password' tabindex='2' />
                                        </div>
                                    </div>
                                    <div class="no-phone" style="padding-left: 80px">
                                        <input class="button default bg-NACOSS-UNN bg-hover-dark" style="width: 300px" type='submit'
                                               name='submit' value='Login' tabindex='3'/>
                                        <br/>
                                        <a href="resetPassword.php" class=""> &nbsp;&nbsp;forgot password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
                <br/>
                <?php require_once './footer.php'; ?>
            </div>
        </div>
    </body>
</html>

