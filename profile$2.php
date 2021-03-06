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
    <div class="row bg-grayLighter grid">
        <div class="padding10">
            <form method="post" action="profile.php?p=2">
                <div class="row ntm" >
                    <h2 class="bg-grayLight padding5">Personal Information</h2>
                    <div class="row ntm">
                        <label class="span2">Name<span class="fg-red">*</span></label>
                        <div class="span6">
                            <input class="span3" type='text' required maxlength="30" placeholder="Last name" name='last_name'
                                   <?= isset($array['last_name']) ? "value='" . $array['last_name'] . "'" : ""; ?> tabindex='3' />
                            <input class="span3" type='text' required maxlength="30" placeholder="First name" name='first_name'
                                   <?= isset($array['first_name']) ? "value='" . $array['first_name'] . "'" : ""; ?> tabindex='4' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Other names</label>
                        <div class="span4">
                            <input type='text' maxlength="30" style="width: inherit" name='other_names'
                                   <?= isset($array['other_names']) ? "value='" . $array['other_names'] . "'" : ""; ?> tabindex='5'   />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Reg. Number<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input name='regno' required style="width: inherit" maxlength="11" type='text' 
                                   <?= isset($array['regno']) ? "value='" . $array['regno'] . "'" : ""; ?>  tabindex='6'  />
                        </div>
                    </div>                    
                    <div class="row" >
                        <label class="span2">Date of Birth</label>
                        <div class="span4">
                            <div class="input-control text" data-role="datepicker"
                                 data-date="<?= isset($array['dob']) ? $array['dob'] : "2015-01-01"; ?>"
                                 data-format="dddd, mmmm d, yyyy"
                                 data-position="top"
                                 data-effect="slide">
                                <input type="text" name="dob">
                                <button class="btn-date"></button>
                            </div>
                        </div>
                    </div>                    
                    <div class="row" >
                        <label class="span2">Bio</label>
                        <div class="span4">
                            <textarea name='bio' style="width: inherit" tabindex='7'><?=
                                isset($array['bio']) ?
                                        $array['bio'] :
                                        "";
                                ?></textarea>
                        </div>
                    </div>
                    <h2 class="bg-grayLight padding5">Contact Information</h2>
                    <div class="row" >
                        <label class="span2">Phone<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input name='phone' required style="width: inherit" type='tel' 
                                   <?= isset($array['phone']) ? "value='" . $array['phone'] . "'" : ""; ?> tabindex='8'  />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Email<span class="fg-red">*</span>
                        </label>
                        <div class="span4">
                            <input name='email' style="width: inherit" required type='email' 
                                   <?= isset($array['email']) ? "value='" . $array['email'] . "'" : ""; ?>  tabindex='9'   />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Address 1</label>
                        <div class="span4">
                            <textarea name='address1' style="width: inherit" tabindex='10'><?=
                                isset($array['address1']) ?
                                        $array['address1'] :
                                        "";
                                ?></textarea>
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Address 2</label>
                        <div class="span4">
                            <textarea name='address2' style="width: inherit" tabindex='11'><?=
                                isset($array['address2']) ?
                                        $array['address2'] :
                                        "";
                                ?></textarea>
                        </div>
                    </div>
                    <h2 class="bg-grayLight padding5">Education</h2>
                    <div class="row">
                        <label class="span2">Department</label>
                        <div class="span4">
                            <select name="dept">
                                <option>COMPUTER SCIENCE</option>
                                <option>COMPUTER SCIENCE/MATHEMATICS</option>
                                <option>COMPUTER SCIENCE/STATISTICS</option>
                                <option>COMPUTER SCIENCE/PHYSICS</option>
                                <option>COMPUTER SCIENCE/GEOLOGY</option>
                            </select>
                            <select name="level">
                                <option>100 Level</option>
                                <option>200 Level</option>
                                <option>300 Level</option>
                                <option>400 Level</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Class of</label>
                        <div class="span4">
                            <input name='entry_year' style="width: inherit" required type='text' 
                                   <?= isset($array['entry_year']) ? "value='" . $array['entry_year'] . "'" : ""; ?>  tabindex='9'   />
                        </div>
                    </div>
                    <h2 class="bg-grayLight padding5">Change Password</h2>
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

                    <div class="row no-phone offset2">
                        <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                               name='editProfileForm' value='Update' tabindex='9'/>
                    </div>
                    <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                        <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                               name='editProfileForm' value='Update' tabindex='9'/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
