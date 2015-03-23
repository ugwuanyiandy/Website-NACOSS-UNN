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
?>

<div class="">
    <div class="navigation-bar dark">
        <div class="container">
            <div class="navigation-bar-content">
                <a class="element" href="index.php">DashBoard</a>
                <span class="element-divider"></span>
                <a class="element1 pull-menu" href="#"></a>
                <ul class="element-menu">
                    <li>
                        <a class=""  href="../index.php">Visit site</a>
                    </li>
                </ul>
                <?php if (isLoggedIn()) { ?>
                    <a href="logout.php" title="Logout" class="element place-right">
                        <i class="icon-exit"></i> Logout
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>