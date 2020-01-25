<style>
.panel-green {
    border-color: #5cb85c;
}
.panel-green > .panel-heading {
    border-color: #5cb85c;
    color: white;
    background-color: #5cb85c;
}
.panel-yellow {
    border-color: #f0ad4e;
}
.panel-yellow > .panel-heading {
    border-color: #f0ad4e;
    color: white;
    background-color: #f0ad4e;
}
.panel-red {
    border-color: #d9534f;
}
.panel-red > .panel-heading {
    border-color: #d9534f;
    color: white;
    background-color: #d9534f;
}
.huge {
    font-size: 40px;
}
</style>
<section id="main-content">
  <section class="wrapper site-min-height">
		<div class="col-md-12">
			<center><h1>Welcome To Dashboard</h1></center>
			<div class="row">
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            </div>
			<div class="row" style="margin-top: 10px;">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
									<i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $userCount; ?></div>
                                    <div>User</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('users/index/0/1'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $supervisorCount; ?></div>
                                    <div>Supervisor</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('supervisor/index/0/1'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
		</div>
  </section>
</section>
