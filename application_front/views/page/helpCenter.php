<section class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="btm-section helpCenter">
                    <input type="text" class="form-control" id="helpSearch" name="search" placeholder="Have a Question?  Ask or enter a search term here.">
                    <h2>Answers on the Spot</h2>
                    <div class="row">
                        <div id="accordion">
                            <?php if(count($faqDatas)>0){
                                foreach ($faqDatas as $faqData){?>
                                    <h3><?php echo $faqData['question']; ?></h3>
                                    <div>
                                        <p>
                                            <?php echo $faqData['answer']; ?>
                                        </p>
                                    </div>
                              <?php  } }else{
                                echo "No Data found.";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
   /*  $(function() {
        $( "#accordion" ).accordion({
            active: false,
            collapsible: true
        });
    }); */
$(document).ready(function(){
    $("#helpSearch").keyup(function(){
        var bla = $('#helpSearch').val();
		var bla = bla.toUpperCase();
        $( "h3" ).each(function(){
            var htxt=$(this).text();
			htxt=htxt.toUpperCase();
            if (htxt.indexOf(bla) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>