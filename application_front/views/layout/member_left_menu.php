<div class="db-l">
    <div class="db-l-1">
        <ul>
            <li><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/db-profile.jpg" alt="" /> </li>
        </ul>
    </div>
    <div class="db-l-2">
        <ul>
            <?php if($this->nsession->userdata('member_session_membertype') && $this->nsession->userdata('member_session_membertype')=='1'){
                ?>
                <li>
                    <a href=""><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl1.png" alt="" /> All Bookings</a>
                </li>
                <li>
                    <a href=""><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl2.png" alt="" /> My Bookings</a>
                </li>
                <li>
                    <a href=""><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl3.png" alt="" /> My Allotment</a>
                </li>
                <li>
                    <a href="<?php echo base_url('user/myprofile/0/1'); ?>"><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl6.png" alt="" /> My Profile</a>
                </li>
                <li>
                    <a href="<?php echo base_url('grievance/index/0/1'); ?>"><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl7.png" alt="" /> My Grievance</a>
                </li>
                <li>
                    <a href="<?php echo base_url('grievance/add'); ?>"><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl7.png" alt="" /> Add Grievance</a>
                </li>
                <?php
            } ?>
            <?php if($this->nsession->userdata('member_session_membertype') && $this->nsession->userdata('member_session_membertype')=='2'){
                ?>
                <li>
                    <a href=""><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl1.png" alt="" /> All Bookings</a>
                </li>
                <li>
                    <a href=""><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl3.png" alt="" /> All Allotment</a>
                </li>
                <li>
                    <a href="<?php echo base_url('supervisor/myprofile/0/1'); ?>"><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl6.png" alt="" /> My Profile</a>
                </li>
                <li>
                    <a href="<?php echo base_url('supervisor/index/0/1'); ?>"><img src="<?php echo  CSS_IMAGES_JS_BASE_URL;?>assets/images/icon/dbl7.png" alt="" /> All Grievance</a>
                </li>
                <li>
                    <a href="<?php echo base_url('supervisor/changePassword'); ?>"><i class="fa fa-key" aria-hidden="true"></i>  Change Password</a>
                </li>
                <?php
            } ?>
            
        </ul>
    </div>
</div>