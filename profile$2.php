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

    <div class="row">
        <a class="place-right button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="profile.php?p=1">
            Cancel Edit
        </a>
    </div>
    <div class="row bg-grayLighter">
        <div class="padding5">
            <form method="post" action="profile.php?p=2">
                <div class="row" >
                    <div class="row ntm">
                        <label class="span2">Name<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input type='text' required maxlength="30" placeholder="Last name" name='last_name'
                                   <?= $array['last_name'] != null ? "value='".$array['last_name']."'" : ""; ?> tabindex='3' />
                            <input type='text' required maxlength="30" placeholder="First name" name='first_name'
                                   <?= $array['first_name'] != null ? "value='".$array['first_name']."'" : ""; ?> tabindex='4' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Other names</label>
                        <div class="span4">
                            <input type='text' maxlength="30" style="width: inherit" name='other_names'
                                   <?= $array['other_names'] != null ? "value='".$array['other_names']."'" : ""; ?> tabindex='5'   />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Reg. Number<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input name='regno' style="width: inherit" maxlength="11" type='text' 
                                   <?= $array['regno'] != null ? "value='".$array['regno']."'" : ""; ?>  tabindex='6'  />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Password<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="password" name='password1' style="width: inherit" type='password' tabindex='2' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Confirm Password<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="password" name='password2' style="width: inherit" type='password' tabindex='2' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Phone<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input name='phone' style="width: inherit" type='tel' 
                                   <?= $array['phone'] != null ? "value='".$array['phone']."'" : ""; ?> tabindex='6'  />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Email<span class="fg-red">*</span>
                        </label>
                        <div class="span4">
                            <input name='email' style="width: inherit" required type='email' 
                                   <?= $array['email'] != null ? "value='".$array['email']."'" : ""; ?>  tabindex='7'   />
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2">Department</label>
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
                    <div class="row no-phone offset2">
                        <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                               name='submit' value='Update' tabindex='9'/>
                    </div>
                    <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                        <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                               name='submit' value='Update' tabindex='9'/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
