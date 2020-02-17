<?php
$user_id =  get_user_id();
$ctrl = $this->uri->segment(1);
$action = $this->uri->segment(2);
?>

<!-- MOBILE MENU -->
<section>
    <div class="ed-mob-menu">
        <div class="ed-mob-menu-con">
            <div class="ed-mm-left">
                <div class="wed-logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php  echo CSS_IMAGES_JS_BASE_URL;?>assets/images/logo.png" alt="" />
        </a>
                </div>
            </div>
            <div class="ed-mm-right">
                <div class="ed-mm-menu">
                    <a href="#!" class="ed-micon"><i class="fa fa-bars"></i></a>
                    <div class="ed-mm-inn">
                        <a href="<?php echo base_url(); ?>" class="ed-mi-close"><i class="fa fa-times"></i></a>
                        <h4>Home pages</h4>
                        <!-- <ul>
                            <li><a href="booking-all.html">Home page 1</a></li>
                            <li><a href="booking-all.html">Home page 2</a></li>
                            <li><a href="booking-tour-package.html">Home page 3</a></li>
                            <li><a href="booking-hotel.html">Home page 4</a></li>
                            <li><a href="booking-car-rentals.html">Home page 5</a></li>
                            <li><a href="booking-flight.html">Home page 6</a></li>
                            <li><a href="booking-slider.html">Home page 7</a></li>
                        </ul> -->
                        <!-- <h4>Tour Packages</h4>
                        <ul>
                            <li><a href="all-package.html">All Package</a></li><li><a href="family-package.html">Family Package</a></li>
                            <li><a href="honeymoon-package.html">Honeymoon Package</a></li>
                            <li><a href="group-package.html">Group Package</a></li>
                            <li><a href="weekend-package.html">WeekEnd Package</a></li>
                            <li><a href="regular-package.html">Regular Package</a></li>
                            <li><a href="custom-package.html">Custom Package</a></li>
                        </ul> -->
                        <!-- <h4>Sighe Seeings Pages</h4>
                        <ul>
                            <li><a href="places.html">Seight Seeing 1</a></li>
                            <li><a href="places-1.html">Seight Seeing 2</a></li>
                            <li><a href="places-2.html">Seight Seeing 3</a></li>
                        </ul> -->
                        <!-- <h4>User Dashboard</h4>
                        <ul>
                            <li><a href="dashboard.html">My Bookings</a></li>
                            <li><a href="db-my-profile.html">My Profile</a></li>
                            <li><a href="db-my-profile-edit.html">My Profile edit</a></li>
                            <li><a href="db-travel-booking.html">Tour Packages</a></li>
                            <li><a href="db-hotel-booking.html">Hotel Bookings</a></li>
                            <li><a href="db-event-booking.html">Event bookings</a></li>
                            <li><a href="db-payment.html">Make Payment</a></li>
                            <li><a href="db-refund.html">Cancel Bookings</a></li>
                            <li><a href="db-all-payment.html">Prient E-Tickets</a></li>
                            <li><a href="db-event-details.html">Event booking details</a></li>
                            <li><a href="db-hotel-details.html">Hotel booking details</a></li>
                            <li><a href="db-travel-details.html">Travel booking details</a></li>
                        </ul>
                        <h4>Other pages:1</h4>
                        <ul>
                            <li><a href="tour-details.html">Travel details</a></li>
                            <li><a href="hotel-details.html">Hotel details</a></li>
                            <li><a href="all-package.html">All package</a></li><li><a href="hotels-list.html">All hotels</a></li>
                            <li><a href="booking.html">Booking page</a></li>
                        </ul> -->
                        <h4 class="ed-dr-men-mar-top">User</h4>
                        <ul>
                        <?php if($this->nsession->userdata('member_login') && $this->nsession->userdata('member_login')==1){
                            ?>
                            <li><a href="<?php echo base_url('logout'); ?>">Logout</a>
                            </li>
                            <?php
                        }else{
                            ?>
                            <li><a href="<?php echo base_url('login'); ?>">Sign In</a>
                            </li>
                            <li><a href="<?php echo base_url('register'); ?>">Sign Up</a>
                            </li>
                            <?php
                        } ?>
                        </ul>
                        <!-- <h4>Other pages:2</h4>
                        <ul>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="testimonials.html">Testimonials</a></li>
                            <li><a href="events.html">Events</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="tips.html">Tips Before Travel</a></li>
                            <li><a href="price-list.html">Price List</a></li>
                            <li><a href="discount.html">Discount</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="sitemap.html">Site map</a></li>
                            <li><a href="404.html">404 Page</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--HEADER SECTION-->
<section>
    <!-- TOP BAR -->
    <div class="ed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class="ed-com-t1-left">
                        <ul>
                            <li><a href="#">Contact: Lake Road, Suite 180 Farmington Hills, U.S.A.</a>
                            </li>
                            <li><a href="#">Phone: +101-1231-1231</a>
                            </li>
                        </ul>
                    </div> -->
                    <div class="ed-com-t1-right">
                        <ul>
                            <?php if($this->nsession->userdata('member_login') && $this->nsession->userdata('member_login')==1){
                                ?>
                                <li><a href="<?php echo base_url('logout'); ?>">Logout</a>
                                </li>
                                <?php
                            }else{
                                ?>
                                <li><a href="<?php echo base_url('login'); ?>">Sign In</a>
                                </li>
                                <li><a href="<?php echo base_url('register'); ?>">Sign Up</a>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </div>
                    <!-- <div class="ed-com-t1-social">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- LOGO AND MENU SECTION -->
    <div class="top-logo" data-spy="affix" data-offset-top="250">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wed-logo">
                        <a href="<?php echo base_url(); ?>"><img src="<?php  echo CSS_IMAGES_JS_BASE_URL;?>assets/images/logo.png" alt="" />
                        </a>
                    </div>
                    <div class="main-menu">
                        <ul>
                            <li><a href="<?php echo base_url(); ?>">Home</a>
                            </li>
                            <li><a href="<?php echo base_url('page/contactUs'); ?>">Contact us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="search-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-form">
                        <form>
                            <div class="sf-type">
                                <div class="sf-input">
                                    <input type="text" id="sf-box" placeholder="Search course and discount courses">
                                </div>
                                <div class="sf-list">
                                    <ul>
                                        <li><a href="course-details.html">Accounting/Finance</a></li>
                                        <li><a href="course-details.html">civil engineering</a></li>
                                        <li><a href="course-details.html">Art/Design</a></li>
                                        <li><a href="course-details.html">Marine Engineering</a></li>
                                        <li><a href="course-details.html">Business Management</a></li>
                                        <li><a href="course-details.html">Journalism/Writing</a></li>
                                        <li><a href="course-details.html">Physical Education</a></li>
                                        <li><a href="course-details.html">Political Science</a></li>
                                        <li><a href="course-details.html">Sciences</a></li>
                                        <li><a href="course-details.html">Statistics</a></li>
                                        <li><a href="course-details.html">Web Design/Development</a></li>
                                        <li><a href="course-details.html">SEO</a></li>
                                        <li><a href="course-details.html">Google Business</a></li>
                                        <li><a href="course-details.html">Graphics Design</a></li>
                                        <li><a href="course-details.html">Networking Courses</a></li>
                                        <li><a href="course-details.html">Information technology</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sf-submit">
                                <input type="submit" value="Search Course">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</section>
<!--END HEADER SECTION-->

<!--HEADER SECTION-->

<!--END HEADER SECTION-->