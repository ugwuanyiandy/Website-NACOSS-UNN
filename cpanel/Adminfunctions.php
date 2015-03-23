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
    $query = "select password from admins where username = '" . getAdminID() . "'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $match = strcasecmp($row['password'], getAdminPassword());
        return empty($row['password']) ? false : $match === 0;
    }
    return false;
}

function activateLogin() {
    return isLoggedIn() ?
            setAdminCookies(getAdminID(), getAdminPassword(), getAdminType()) :
            false;
}

function isUserDeleted($ID) {
    $query = "select is_deleted from users where regno = '$ID'";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['is_deleted'] == 1;
    }
    return true; //Restrict access if record does not exist
}

function isUserSuspended($ID) {
    $query = "select is_suspended from users where regno = '$ID'";
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

function getNews() {
    $array = array();
    $query = "select * from news";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($array, $row);
        }
    }
    return $array;
}

function getFAQs() {
    $array = array();
    $query = "select * from faq";
    $link = getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($array, $row);
        }
    }
    return $array;
}

/**
 * @returns user display name
 */
function getDisplayName() {
    return getAdminID();
}

/**
 * Validates user details and set cookies
 * @param type $ID user's registration number
 * @param type $password user's password
 * @return boolean true if user was successfully validated and cookies was sucessfully set, false otherwise
 */
function loginAdmin($ID, $password) {
    if (!(empty($ID) | empty($password))) {
        $query = "select password from admins where id = '$ID'";
        $link = getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $password = sha1($password);
            $match = strcasecmp($password, $row['password']);
            return $match === 0 ? setAdminCookies($ID, $password, $row['type']) : false;
        }
    }
    return false;
}

function updateAdminInfo($id, $password) {
    $ok = false;
    $link = getDefaultDBConnection();
    if (strlen($id) > 6 && strlen($password) > 8) {
        $ok = true;
        $password = sha1($password);
    }
    if ($ok) {
        $query = "update admins set username='$id ',password='$password'"
                //Add more field as needed
                . "where username='" . getAdminID() . "'";
        $ok = mysqli_query($link, $query);
    }
    return $ok;
}

/**
 * @returns admins username from cookies
 */
function getAdminID() {
    return filter_input(INPUT_COOKIE, "id");
}

/**
 * @returns admins password from cookies
 */
function getAdminPassword() {
    return filter_input(INPUT_COOKIE, "pwd");
}

/**
 * @returns admins type from cookies
 */
function getAdminType() {
    return filter_input(INPUT_COOKIE, "t");
}

/**
 * Sets cookies
 * @param type $id
 * @param type $password
 * @return type
 */
function setAdminCookies($id, $password, $type) {
    $expire = time() + (60 * 60 * 1); //1 hour i.e 60secs * 60mins * 1hr
    $ok = setcookie("id", $id, $expire);
    if ($ok) {
        $ok = setcookie("pwd", $password, $expire);
    }
    if ($ok) {
        $ok = setcookie("t", $type, $expire);
    }
    return $ok;
}

/**
 * Clears all cookies
 * @return type true if all cookies were removed, false otherwise
 */
function clearAdminCookies() {
    $clearIDOk = setcookie("id", "", time() - 3600);
    $clearPwdOk = setcookie("pwd", "", time() - 3600);
    $clearTypeOk = setcookie("t", "", time() - 3600);
    return $clearIDOk && $clearPwdOk && $clearTypeOk;
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
