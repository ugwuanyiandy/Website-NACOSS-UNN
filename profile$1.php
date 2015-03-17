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

require_once './functions.php';
$array = getUserData();
?>
<div>
    <h2>Profile</h2>
    <div class="row">
        <a class="place-right button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="logout.php">
            Log out
        </a>
        <div class="place-right">
            &nbsp;
        </div>
        <a class="place-right button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="profile.php?p=2">
            Edit Profile
        </a>
    </div>
    <div class="row bg-grayLighter">
        <div class="padding5">
            
        </div>
    </div>
</div>