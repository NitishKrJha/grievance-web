<div class="banner">
    <div class="camera_wrap" id="slider">
        <?php foreach($banners as $banner) {?>
        <div data-src="<?php echo file_upload_base_url();?>banner/<?php echo $banner['icon']; ?>"></div>
        <?php } ?>
    </div>
    <div class="camera_caption fadeIn">
        <?php echo html_entity_decode($bannerContent['content']); ?>
        <div class="banner_form_sec">
            <div class="rd-mailform1 mt-rd-mailform1">
                <form action="<?php echo base_url('property/rent_property'); ?>" method="Post">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="form-group"><label for="bedsSelect">Beds</label>
                                    <div class="select"><select name="beds">
                                        <option value="">All</option>
                                        <option value="100">Studio</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group no_border"><label class="lft_less" for="priceSelect">Min
                                    Price</label>
                                    <div class="select"><select name="min_price">
                                        <option value="">No Min</option>
                                        <option value="300">$300/Bedroom</option>
                                        <option value="400">$400/Bedroom</option>
                                        <option value="500">$500/Bedroom</option>
                                        <option value="600">$600/Bedroom</option>
                                        <option value="700">$700/Bedroom</option>
                                        <option value="800">$800/Bedroom</option>
                                        <option value="1000">$1000/Bedroom</option>
                                        <option value="1200">$1200/Bedroom</option>
                                    </select></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group no_border"><label class="lft_less" for="priceSelect">Max
                                    Price</label>
                                    <div class="select"><select name="max_price">
                                        <option value="">No Max</option>
                                        <option value="550">$550/Bedroom</option>
                                        <option value="650">$650/Bedroom</option>
                                        <option value="750">$750/Bedroom</option>
                                        <option value="850">$850/Bedroom</option>
                                        <option value="950">$950/Bedroom</option>
                                        <option value="1050">$1050/Bedroom</option>
                                        <option value="1150">$1150/Bedroom</option>
                                        <option value="1350">$1350/Bedroom</option>
                                    </select></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn-send_1" type="submit">
                                <img class="img-responsive" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/search_icon.png">
                            </button>
                        </div>
                    </div>
                </form>
            </div>        <!--<p class="srch-txt">or search by <a href="rent_properties.php">Map Search</a></p>-->
        </div>
    </div>
</div>