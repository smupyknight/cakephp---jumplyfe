<?php echo $this->element('top_slider');  ?>
<div class="about_us">
 <div class="container">
    <h3 class="title"><?php echo $record[$model]['name']; ?></h3>
		<?php echo $record[$model]['body']; ?>
 </div>
</div>
<?php if($record[$model]['slug'] == 'about-us'){ ?>
<div class="client-section">
  <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3">
            <div class="client">
                <a href="javascript:void(0)"><?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'Dollarphotoclub_63720379.jpg',array('class'=>'img-responsive')); ?></a>
        
            </div>
        </div>
         <div class="col-md-3 col-sm-3">
            <div class="client">
                <a href="javascript:void(0)"><?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'Dollarphotoclub_51260871.jpg',array('class'=>'img-responsive')); ?></a>
            </div>
        </div>
         <div class="col-md-3 col-sm-3">
            <div class="client">
                <a href="javascript:void(0)"><?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'Dollarphotoclub_66374535.jpg',array('class'=>'img-responsive')); ?></a>
            </div>
        </div>
         <div class="col-md-3 col-sm-3">
            <div class="client">
                <a href="javascript:void(0)	"><?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'Dollarphotoclub_32435824.jpg',array('class'=>'img-responsive')); ?></a>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="map">
  <div class="container">
	<?php echo $this->Html->image(WEBSITE_IMAGE_PATH.'map.png'); ?>
  </div>
</div>
<?php  }  ?>
