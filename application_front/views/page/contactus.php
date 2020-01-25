<?php
$global_phone_number = $this->functions->getGlobalInfo('global_phone_number');
$global_contact_email = $this->functions->getGlobalInfo('global_contact_email');
$global_map_url = $this->functions->getGlobalInfo('global_map_url');
$global_address = $this->functions->getGlobalInfo('global_address');
?>
  <section class="contact-section-wrap ">
  	<div class="contact">
      <div class="contact-pageheader">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="contact-caption">
                <h1 class="contact-title">My Missing Rib</h1>
                <p class="contact-text">We would love to hear from you!. For all other requests, please fill out and submit the form. </p>
              </div>
            </div>
            <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
              <div class="contact-form">
                <h3 class="contact-info-title">Contact Us</h3>
                <div class="row">
                  <form class="subscribe-frm" name="mycontact" action="<?php echo base_url().'page/do_contact'; ?>" method="post" id="mycontact">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label class="control-label sr-only " for="Name"></label>
                        <input id="name" name="name" type="text" placeholder="Name" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label class="control-label sr-only " for="email"></label>
                        <input id="email" name="email" type="text" placeholder="Email" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label class="control-label sr-only " for="Phone"></label>
                        <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
                      <div class="form-group">
                        <label class="control-label sr-only" for="textarea"></label>
                        <textarea class="form-control pdt20" id="query" name="query" rows="4" placeholder="Queries, Suggestions, Comments, Any Enquiry"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                      <button class="btn btn-primary btn-lg ">Send message</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="space-medium">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb60">
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
       
           <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.812772318256!2d-95.59563824982305!3d29.956063581825717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640d22f7cb8ed7b%3A0xd55b3d3250bc79cf!2s12515+Hideaway+Park+Dr%2C+Cypress%2C+TX+77429%2C+USA!5e0!3m2!1sen!2sin!4v1528960764685"  frameborder="0" style="border:0" allowfullscreen></iframe>-->
		          <div id="map-container-2" class="z-depth-1" style="height: 400px"></div>
            <?php //echo isset($global_map_url)? htmlspecialchars_decode($global_map_url):'';?>
          
            </div>
            <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-6 col-xs-12">
              <div class="title-details">
                <h3 class="title-bold">Contact Info</h3>
                <p>Please help us serve you better by sharing the following information. </p>
              </div>
              <div class="contact-section">
                <div class="contact-icon"><i class="fa fa-map-marker"></i></div>
                <div class="contact-info">
                  <p><?php echo isset($global_address)?$global_address:'';?></p>
                </div>
              </div>
              <div class="contact-section">
                <a href="tel:<?php echo isset($global_phone_number)?$global_phone_number:'';?>">
                <div class="contact-icon"><i class="fa fa-phone"></i></div>
                <div class="contact-info">
                  <p><?php echo isset($global_phone_number)?$global_phone_number:'';?></p>
                </div>
                </a>
              </div>
               <div class="contact-section">
               <a href="mailto:<?php echo isset($global_contact_email)?$global_contact_email:'';?>">
                <div class="contact-icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                <div class="contact-info">
                  <p><?php echo isset($global_contact_email)?$global_contact_email:'';?></p>
                </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBcTzVAS3dm4ydHvmlK6rx6qNr0aozSX88"></script>
<script>
 $(function() { 
	
  $("form[name='mycontact']").validate({
	
    // Specify validation rules
    rules: {
      name: {
  		  required: true
  	  },
  	  phone:{
  		  required: true
  	  },
  	  email:{
  		  required: true,
  		  email: true
  	  },
  	  query:{
  		  required: true
  	  }
    },
    // Specify validation error messages
    messages: {
      name: "Enter your name.",
      phone: "Enter your phone number.",
  	  query: "Enter your query.",
  	 
  	  sum: "Enter Right value."
    },
    submitHandler: function(form) {
      var data=$("form[name='mycontact']").serialize();
      do_contact(data,'Subscribe');
    }
  });
}); 

function do_contact(formData,type){
       
         var url="<?php echo base_url('page/do_contact/');?>";
       
       // var btnname='make'+type+'Register';
        $.ajax({
          type:'POST',
          url: url,
          data:formData,
        
          success:function(msg){ 
            var response=$.parseJSON(msg);
			
            if(response = true){ 
				       window.location.reload();
            }else{
               window.location.reload();
            }
          },
          error: function () {
          
            messagealert('Error','Technical issue , Please try later','error');
          }
        });
      }

</script>

<script>
  // Custom map
function custom_map() {

    var var_location = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);

    var var_mapoptions = {
        center: var_location,
        zoom: 8
    };

    var var_map = new google.maps.Map(document.getElementById("map-container-2"),
        var_mapoptions);

    var var_marker = new google.maps.Marker({
        position: var_location,
        map: var_map,
        title: "MMR"
    });
}

// Initialize maps
google.maps.event.addDomListener(window, 'load', custom_map);
</script>