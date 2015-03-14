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
 * @param type $ID registration number
 * @param type $password user password
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

function registerUser($ID, $password1, $password2, $email, $first_name, $last_name, $other_names, $dept, $level, $phone) {
    //Step 1: Validate details
    //Step 2: Add to database
    //Step 3: Mail login id and password to user
    try {
        mail($email, "Subject: NACOSS UNN login details", wordwrap(getVerificationMessage($ID, $password1), 70, "\r\n"), "From: NACOSS UNN\r\n"
                . 'Reply-To: ' . $GLOBALS['contact_email'] . "\r\n"
                . 'X-Mailer: PHP/' . phpversion());
    } catch (Exception $exc) {
        return false;
    }

    return false; //Disabled temporarily
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
    return

            filter_input(INPUT_COOKIE, "pwd");
}

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
