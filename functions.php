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
 * returns true if user is logged in, else false
 */
function isLoggedIn() {
    return !empty(getID());
}

/**
 * @returns user display name
 */
function getDisplayName() {
    if (isLoggedIn()) {
        $query = "select first_name, last_name from users where regno = '" . getID() . "'";
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
 * @returns students registration number 
 */
function getID() {
    return filter_input(INPUT_COOKIE, "id");
}

function setID($id) {
    $expire = time() + (60 * 60 * 24 * 7); //1 week i.e 60secs * 60mins * 2hhrs * 7days
    $ok = setcookie("id", $id, $expire);
    return $ok;
}

function clearID() {
    $ok = setcookie("id", "", time() - 3600);
    return $ok;
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
