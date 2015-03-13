<?php
if (isset($_POST['submit'])) {
    //ini_set('display_errors',1);
    require_once 'constants.php';
    //Set values
    $contact_email = $GLOBALS['contact_email'];

    $user_email = filter_input(INPUT_POST, "email");
    $company = filter_input(INPUT_POST, "company");
    $comment = filter_input(INPUT_POST, "message");
    $name = filter_input(INPUT_POST, "name");
    $address = filter_input(INPUT_POST, "address");
    $city = filter_input(INPUT_POST, "city");
    $region = filter_input(INPUT_POST, "region");
    $phone = filter_input(INPUT_POST, "phone");

    //Message
    $message = "Client name: " . $name;
    $message .= "\r\nCompany: " . $company;
    $message .= "\r\nAddress: " . $address;
    $message .= "\r\nCity: " . $city;
    $message .= "\r\nState/Region: " . $region;
    $message .= "\r\nPhone: " . $phone;
    $message .= "\r\n\n" . $comment;


    if (isset($user_email) && isset($contact_email) && isset($comment)) {
        try {
            if (mail($contact_email, "Subject: Interested Customer", wordwrap($message, 70, "\r\n"), "From: " . $user_email . "\r\n" .
                            'Reply-To: ' . $contact_email . "\r\n" .
                            'X-Mailer: PHP/' . phpversion())) {
                $success = true;
                $comment = "";
//                empty($_POST);
                $_POST = "";
            } else {
                $success = false;
            }
        } catch (Exception $exc) {
            $success = false;
        }
    } else {
        $success = false;
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
        <meta name="description" content="NACOSS UNN official website">
        <meta name="author" content="NACOSS UNN Developers">
        <meta name="keywords" content=" metro ui, NDG, NACOSS UNN">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link href="js/prettify/prettify.css" rel="stylesheet">

        <script src="js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <script src="js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>

        <!-- Page Title -->
        <title>NACOSS UNN : Contact Us</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <br/>
            <div class="padding20" id="inquiries">
                <p>If you would like to contact NACOSS UNN Chapter, here’s how you can reach us:</p>
                <br/>
                <div class="panel bg-white no-border">
                    <strong>CALL <i class="icon-phone-2"></i></strong>
                    <br/>
                    <span class="fg-lightBlue">+23412345678</span>,
                    <span class="fg-lightBlue">+23487654321</span>
                </div>
                <br/>
                <div>
                    <p id="">
                        <strong>Email Inquiries</strong><br />
                        If you would prefer to contact us via email, simply fill out the form below.
                    </p>
                    <br/>

                    <?php if (isset($_POST['submit'])) { ?>
                        <div class="row container">
                            <div class="label">
                                <?php if ($success) { ?>
                                    <h2 class="success fg-green">Thank You!</h2>
                                    <p>Your message has been sent, we will reply in a while.</p>
                                <?php } else { ?>
                                    <h2 class="error fg-red">Sorry, we could not send your message at the moment.</h2>
                                    <p>
                                        please check and make sure your details are correct
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <form method='post' enctype='multipart/form-data' id='gform_1'  
                          action='contact.php#inquiries'>
                        <div  class="container">
                            <div class="grid" id='gform_fields_1' >
                                <div class="row" id='field_1_1' >
                                    <label class="span2" for='input_1_1'>Name<span class="fg-red">*</span></label>
                                    <div class="span7">
                                        <input name='name' required style="width: inherit" id='input_1_1' type='text' <?php
                                        if (isset($_POST['submit'])) {
                                            echo "value='$name'";
                                        }
                                        ?>  tabindex='1' />
                                    </div>
                                </div>
                                <div class="row" id='field_1_4'  >
                                    <label class="span2" for='input_1_4'>Company</label>
                                    <div class="span7">
                                        <input name='company' style="width: inherit" id='input_1_4' type='text' <?php
                                        if (isset($_POST['submit'])) {
                                            echo "value='$company'";
                                        }
                                        ?>  tabindex='2'   />
                                    </div>
                                </div>
                                <div class="row" id='field_1_8'  >
                                    <label class="span2" for='input_1_8_1'>Address<span class="fg-red">*</span></label>
                                    <div class="span7" id='input_1_8'>
                                        <input type='text' required placeholder="Street Address" name='address' style="width: inherit" 
                                               id='input_1_8_1' <?php
                                               if (isset($_POST['submit'])) {
                                                   echo "value='$address'";
                                               }
                                               ?> tabindex='3' />
                                        <label for='input_1_8_1'  id='input_1_8_1_label'></label>
                                        <input type='text' required placeholder="City" name='city'
                                               id='input_1_8_3' <?php
                                               if (isset($_POST['submit'])) {
                                                   echo "value='$city'";
                                               }
                                               ?> tabindex='4' />
                                        <label for='input_1_8_3' id='input_1_8_3_label'></label>
                                        <input type='text' required placeholder="State / Region" name='region' 
                                               id='input_1_8_4' <?php
                                               if (isset($_POST['submit'])) {
                                                   echo "value='$region'";
                                               }
                                               ?> tabindex='5'   />
                                        <label for='input_1_8_4' id='input_1_8_4_label'></label>

                                    </div>
                                </div>

                                <div class="row" id='field_1_5'  >
                                    <label class="span2" for='input_1_5'>Phone</label>
                                    <div class="span7">
                                        <input name='phone' id='input_1_5' type='tel' <?php
                                        if (isset($_POST['submit'])) {
                                            echo "value='$phone'";
                                        }
                                        ?>  tabindex='6'  />
                                    </div>
                                </div>
                                <div class="row" id='field_1_2'  >
                                    <label class="span2" for='input_1_2'>Email Address<span class="fg-red">*</span>
                                    </label>
                                    <div class="span7">
                                        <input name='email' required style="width: inherit" id='input_1_2' type='email' <?php
                                        if (isset($_POST['submit'])) {
                                            echo "value='$user_email'";
                                        }
                                        ?>   tabindex='7'   />
                                    </div>
                                </div>
                                <div class="row" id='field_1_3'>
                                    <label class="span2" for='input_1_3'>Comments<span class="fg-red">*</span>
                                    </label>
                                    <div class="span7">
                                        <textarea name='message' required style="width: inherit" id='input_1_3'  tabindex='8' rows='10'><?php
                                            if (isset($_POST['submit'])) {
                                                echo $comment;
                                            }
                                            ?></textarea>
                                    </div>
                                </div>
                                <div class="row no-phone offset2">
                                    <input class="button default bg-lightBlue bg-hover-amber" type='submit'
                                           name='submit' id='gform_submit_button_1'  value='Send Message' tabindex='9'/>
                                </div>
                                <div class="row on-phone no-tablet no-desktop padding20 ntp nbp">
                                    <input class="button default bg-lightBlue bg-hover-amber" type='submit'
                                           name='submit' id='gform_submit_button_1'  value='Send Message' tabindex='9'/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
