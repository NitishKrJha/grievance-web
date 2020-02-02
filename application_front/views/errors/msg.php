<?php if(!empty($succmsg)){
    ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $succmsg; ?>
    </div>
    <?php
} ?>
<?php if(!empty($errmsg)){
    ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> <?php echo $errmsg; ?>
    </div>
    <?php
} ?>