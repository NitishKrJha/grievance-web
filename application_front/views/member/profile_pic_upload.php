<?php //pr($memberMoreData); ?>
<link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo CSS_IMAGES_JS_BASE_URL;?>/css/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jcrop/jquery.Jcrop.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jcrop/script.js" type="text/javascript" charset="utf-8"></script>
<section class="main-container">
    <div class="container-fluid">
        <div class="row">
           
            <div class="col-md-12">
                
                
                <div class="row">
                    <div class="">
                      <form id="upload_form" enctype="multipart/form-data" method="post" action="<?= base_url('member/ChangeProfileImgWithResizeCrop')?>" onsubmit="return checkForm()">
                            <!-- hidden crop params -->
                            <input type="hidden" id="x1" name="x1" />
                            <input type="hidden" id="y1" name="y1" />
                            <input type="hidden" id="x2" name="x2" />
                            <input type="hidden" id="y2" name="y2" />

                            <!--<h2>Step1: Please select image file</h2>-->
                            <div class="loadFile">
                                <div class="btn btn-small download-upload">
                                <span><i class="fa fa-upload" aria-hidden="true"></i> File</span>
                                    <input style="display:block;" type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" accept="image/*" />
                                </div>
                            </div>

                            <div class="error"></div>

                            <div class="step2">
                                <!--<h2>Step2: Please select a crop region</h2>-->
                                <img id="preview" />

                                <div class="info">
                                    <input type="hidden" id="filesize" name="filesize" />
                                     <input type="hidden" id="filetype" name="filetype" />
                                     <input type="hidden" id="filedim" name="filedim" />
                                     <input type="hidden" id="w" name="w" />
                                     <input type="hidden" id="h" name="h" />
                                </div>

                                <div class="uploadOtr"><input type="submit" value="Upload" class="uploadBtn" /></div>
                            </div>
                        </form>  
			     
			        </div>
                </div>
                
            </div>
           
        </div>
    </div>
</section>
<!-- <div id="chatAppend"></div> -->
<!-- Modal -->
