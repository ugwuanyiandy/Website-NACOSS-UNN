<?php
require_once './Adminfunctions.php';
if (activateLogin()) {
    
} else {
    header("location: index.php");
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
                    <div class="grid">
                        <div class="row">
                            <div class="span3">
                                <nav class="sidebar light">
                                    <ul class="">
                                        <li class="">
                                            <a href="#">Post News</a>
                                        </li>
                                        <li class="">
                                            <a href="#">View All</a>
                                        </li>
                                        <li class="">
                                            <a href="#">FAQ</a>
                                        </li>
                                        <li class="">
                                            <a href="#">Settings</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                            <div class="span9">

                            </div>
                        </div>
                    </div>

                </div>
                <br/>
                <?php require_once './footer.php'; ?>
            </div>
        </div>
    </body>
</html>
