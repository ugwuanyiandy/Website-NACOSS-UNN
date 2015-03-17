<?php

/*
 * Copyright 2015 NACOSS UNN Developers Group (NDG).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


require_once './constants.php';

/**
 * Validates user cookies against user details in database
 * @return boolean true if user cookies match user details in database, else false
 */
function isLoggedIn() {
    $query = "select password from users where regno = '" . getUserID() . "'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $match = strcasecmp($row['password'], getUserPassword());
        return empty($row['password']) ? false : $match === 0;
    }
    return false;
}

function isUserDeleted() {
    $query = "select is_deleted from users where regno = '" . getUserID() . "'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['is_deleted'] == 1;
    }
    return true; //Restrict access if record does not exist
}

function isUserSuspended() {
    $query = "select is_suspended from users where regno = '" . getUserID() . "'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['is_suspended'] == 1;
    }
    return false; //Restrict access if record does not exist
}

function getContactEmail() {
    $query = "select value from settings where name = 'email'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['value'];
    }
    return "";
}

function getContactNumbers() {
    $query = "select value from settings where name = 'help_lines'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return empty($row['value']) ? array() : explode(",", $row['value']);
    }
    return array();
}

function getHomePageSliderImages() {
    $array = array();
    $query = "select * from home_page_slider limit 10";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while($row = mysqli_fetch_array($result)){
            array_push($array, $row);
        }
    }
    return $array;
}

function getFAQs() {
    $array = array();
    $query = "select * from faq limit 20";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while($row = mysqli_fetch_array($result)){
            array_push($array, $row);
        }
    }
    return $array;
}

/**
 * @returns user display name
 */
function getDisplayName() {
    if (isLoggedIn()) {
        $query = "select first_name, last_name from users where regno = '" . getUserID() . "'";
        $link = getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row['first_name'] . " " . $row['last_name'];
        }
    }
    return "";
}

/**
 * Validates user details and set cookies
 * @param type $ID user's registration number
 * @param type $password user's password
 * @return boolean true if user was successfully validated and cookies was sucessfully set, false otherwise
 */
function loginUser($ID, $password) {
    if (!(empty($ID) | empty($password))) {
        $query = "select password from users where regno = '$ID'";
        $link = getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $password = sha1($password);
            $match = strcasecmp($password, $row['password']);
            return $match === 0 ? setUserCookies($ID, $password) : false;
        }
    }
    return false;
}

/**
 * Update the data of user having the given ID with given values 
 * @param type $array array of fields mapped to values
 * @return boolean returns true if user's data was successfully updated, false otherwise
 */
function updateUserInfo($array) {
    $link = getDefaultDBConnection();
    foreach ($array as $key => $value) {
        if (strcasecmp($key, "password") === 0) {
            $array[$key] = sha1($value);
        } else {
            $array[$key] = mysqli_escape_string($link, $value);
        }
    }
    $ok = validateInfo($array["regno"], $array["password"], $array["email"], $array["first_name"], $array["last_name"], $array["phone"]);
    if ($ok) {
        $query = "update users set password='" . $array["password"] . "',email='" . $array["email"] . "',"
                . "first_name='" . $array["first_name"] . "',last_name='" . $array["last_name"] . "',"
                . "other_names='" . $array["other_names"] . "',department='" . $array["department"] . "',"
                . "level='" . $array["level"] . "',phone='" . $array["phone"] . "' "
                //Add more field as needed
                . "where regno='" . $array["regno"] . "'";
        $ok = mysqli_query($link, $query);
    }
    return $ok;
}

/**
 * Returns error messages for parameters with invalid values (from profile or registration form)
 * @param type $array array of fields mapped to values
 * @return string error message in respect to any invalid parameter found, else an empty string
 */
function getInvalidParameters($array) {
    foreach ($array as $key => $value) {
        switch (strtolower($key)) {
            case 'regno':
                $chunks = explode("/", $value);
                if (strlen($chunks[0]) != 4 || strlen($chunks[1]) != 6) {
                    return "Invalid registration number";
                }
                break;
            case 'first_name':
                if (strlen($value) < 2) {
                    return "first name must contain atleast 2 characters";
                }
                break;
            case 'last_name':
                if (strlen($value) < 2) {
                    return "last name must contain atleast 2 characters";
                }
                break;
            case 'password': //For time passwords
                if (strlen($value) < 8) {
                    return "Password must contain atleast 8 characters";
                }
                break;
            case 'password1': //For passwords with confirmations
                if (strlen($value) < 8) {
                    return "Password must contain atleast 8 characters";
                }
                break;
            case 'password2': //confirmation passwords
                if (strcasecmp($value, $array["password1"]) !== 0) {
                    return "Passwords do not match";
                }
                break;
            case 'email':
                if (filter_var($value, FILTER_VALIDATE_EMAIL) === FALSE) {
                    return "Check email address";
                }
                break;
            case 'dob':
                break;
            case 'phone':
                break;
            //Add more parameter cases as needed
            default :
                break;
        }
    }
    return "";
}

function getUserData() {
    $query = "select * from users where regno = '" . getUserID() . "'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $array = mysqli_fetch_array($result);
        return $array;
    }
    return array();
}

function validateInfo($ID, $password, $email, $first_name, $last_name, $phone) {
    return isset($ID) &&
            isset($password) &&
            isset($email) &&
            isset($password) &&
            isset($first_name) &&
            isset($last_name) &&
            isset($phone);
}

function addNewUser($ID, $password, $email, $first_name, $last_name, $phone) {
    $link = getDefaultDBConnection();
    $regno = mysqli_escape_string($link, $ID);
    $pwd = sha1($password);
    $email_address = mysqli_escape_string($link, $email);
    $fname = mysqli_escape_string($link, $first_name);
    $lname = mysqli_escape_string($link, $last_name);
    $phone_no = mysqli_escape_string($link, $phone);
    $query = "insert into users set regno = '$regno',"
            . "password='$pwd',"
            . "email='$email_address',"
            . "first_name='$fname',"
            . "last_name='$lname',"
            . "phone='$phone_no'";
    $ok = mysqli_query($link, $query);
    return $ok;
}

/**
 * Creates a new user with the given infomation
 * @param type $ID user's registration number
 * @param type $password user's password
 * @param type $email user's email address
 * @param type $first_name user's first name
 * @param type $last_name user's last name
 * @param type $phone user's phone number
 * @return boolean returns true if user's data was successfully registered, false otherwise
 */
function registerUser($ID, $password, $email, $first_name, $last_name, $phone) {
    // Validate details
    $ok = validateInfo($ID, $password, $email, $first_name, $last_name, $phone);
    // Add to database
    if ($ok) {
        $ok = addNewUser($ID, $password, $email, $first_name, $last_name, $phone);
    }
    // Mail login id and password to user
    if ($ok) {
        try {
            mail($email, "Subject: NACOSS UNN login details", wordwrap(getVerificationMessage($ID, $password), 70, "\r\n"), "From: NACOSS UNN\r\n"
                    . 'Reply-To: ' . $GLOBALS['contact_email'] . "\r\n"
                    . 'X-Mailer: PHP/' . phpversion());
        } catch (Exception $exc) {
            //Mailing failed
            writeToLog($exc);
//            return false;
        }
    }
    return $ok;
}

function getVerificationMessage($ID, $password) {
    $message = '<html>'
            . '<body">'
            . 'find your login details below:<br/>'
            . '<strong>ID:</strong> ' . $ID . '<br/>'
            . '<strong>Password:</strong> ' . $password . '<br/>'
            . '</body>'
            . '</html>';
    return $message;
}

/**
 * @returns students registration number from cookies
 */
function getUserID() {
    return filter_input(INPUT_COOKIE, "id");
}

/**
 * @returns students password from cookies
 */
function getUserPassword() {
    return filter_input(INPUT_COOKIE, "pwd");
}

/**
 * Sets cookies
 * @param type $id
 * @param type $password
 * @return type
 */
function setUserCookies($id, $password) {
    $expire = time() + (60 * 60 * 24 * 7); //1 week i.e 60secs * 60mins * 2hhrs * 7days
    $ok = setcookie("id", $id, $expire);
    if ($ok) {
        $ok = setcookie("pwd", $password, $expire);
    }
    return $ok;
}

/**
 * Clears all cookies
 * @return type true if all cookies were removed, false otherwise
 */
function clearUserCookies() {
    $clearIDOk = setcookie("id", "", time() - 3600);
    $clearPwdOk = setcookie("pwd", "", time() - 3600);
    return $clearIDOk && $clearPwdOk;
}

/**
 * 
 * @return connection to default database
 */
function getDefaultDBConnection() {
    $link = getConnection();
    if ($link) {
        $successful = mysqli_select_db($link, $GLOBALS['default_db_name']);
        if (!$successful) {
            die('Unable to select database: ' . mysql_error());
        }
    } else {
        die('Could not connect to database: ' . mysql_error());
    }
    return $link;
}

/**
 * creates a connection to the default database
 * @return connection
 */
function getConnection() {
    $link = mysqli_connect($GLOBALS['db_hostname'], $GLOBALS['db_username'], $GLOBALS['db_password']);
    return $link;
}

/**
 * Writes exception to log file
 * @param type $exception exception
 */
function writeToLog($exception) {
    $link = getDefaultDBConnection();
    $message = "File: " . $exception->getFile() . " [line " . $exception->getLine() . "]\n"
            . "Message: " . $exception->getMessage();
    $query = "insert into error_log set message = '$message'";
    mysqli_query($link, $query);
}
