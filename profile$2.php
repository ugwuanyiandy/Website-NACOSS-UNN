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
if (empty($array)) {
    $array = getUserData();
}
?>
<div>
    <h2>Edit Profile</h2>
    
    Array = <?= var_dump($array)?>
    
    <form method="post" action="profile.php?p=2">
        
        <div class="row" >
            <label class="span2">Department<span class="fg-red">*</span></label>
            <div class="span4">
                <select name="dept">
                    <option>COMPUTER MAJOR</option>
                    <option>COMPUTER/MATHEMATICS</option>
                    <option>COMPUTER/STATISTICS</option>
                    <option>COMPUTER/PHYSICS</option>
                    <option>COMPUTER/GEOLOGY</option>
                </select>
                <select name="level">
                    <option>100 Level</option>
                    <option>200 Level</option>
                    <option>300 Level</option>
                    <option>400 Level</option>
                </select>
            </div>
        </div>
        
    </form>
</div>
