<script>
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 1,
      max: 1000,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount_from" ).val(ui.values[0]);
        $( "#amount_till" ).val(ui.values[1]);
      }
    });
    $( "#amount_from" ).val($("#slider-range").slider("values",0));
    $( "#amount_till" ).val($("#slider-range").slider("values",1));
  });
  $(function() {
	  $(".date_from").datepicker({
		  format: "dd-mm-yyyy",
		  startDate: "<?php echo $startDateFrom; ?>",
		endDate: "<?php echo $endDateFrom; ?>",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	  }).change(function(dateChanged){
		 
	  });
	  $(".date_to").datepicker({
		  format: "dd-mm-yyyy",
		  startDate: "<?php echo $startDateTo; ?>",
		endDate: "<?php echo $endDateTo; ?>",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	  });
  });
  </script>
<div class="searchpage">
	<?php echo $this->element('menu');?>
</div>
<div class="right_profile">
  <div class="container">
        <div class="search_view searches">
          <div class="row"> 
			<form method="get" action="<?php echo $this->here; ?>">
            <div class="col-md-6 col-sm-6">
                <div class="date_section">
                  <h5>Dates</h5>
					<!--<?php echo $this->Html->image('date.png',array('class'=>'img-responsive'));?>-->
					<input type="text" name="date_from" class="form-control date_from" value="<?php echo $date_from;?>">
							 to 
					<input type="text" name="date_to" class="form-control date_from" value="<?php echo $date_to;?>">
                </div>
            </div>
			
             <div class="col-md-6 col-sm-6">
                <div class="date_section">
                  <h5>Price</h5>
				  $<input type="text" name="min_price" id="amount_from" readonly style="border:0; color:#25ad9f; font-weight:bold;"> - $<input type="text" name="max_price" id="amount_till" readonly style="border:0; color:#25ad9f; font-weight:bold;">
				  <div id="slider-range"></div>
                 <br>
                  <!-- <span class="price_style">$500</span><span class="price_style">$500</span> -->
                </div>
            </div>
				<div class="col-md-6 col-sm-6">
					<div class="date_section">
					  <input placeholder="Keyword" class="form-control" type="text" name="keyword" value="<?php echo $keyword;?>"/>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="date_section">
						<button class="btn btn-primary" type="submit">Search</button>
					</div>
				</div>
			</form>
          </div>
          <iframe class="map_section"src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d14225.20871080889!2d75.77783465!3d26.9573285!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1425548507703" width="100%" height="280" frameborder="0" style="border:1"></iframe>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#sectionA">Host Jumpers</a></li>
        <li><a data-toggle="tab" href="#sectionB">Jump Hosts</a></li>
        <li><a data-toggle="tab" href="#sectionC">Jumps</a></li>
      </ul>
          <div class="row">
       <div class="tab-content">
              <div id="sectionA" class="col-md-12 col-sm-12 tab-pane fade in active" >
                <div class="date_section">
					<?php if(isset($host_jumpers) && !empty($host_jumpers)) { ?>
					<?php foreach($host_jumpers as $key => $value) {?>
					  <div class="col-md-4 col-sm-6 col-xs-12">
						<div class="person_detail">
							<?php
								$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
								$file_name		=	$value['User']['image'];
								if($file_name && file_exists($file_path . $file_name)) {
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',80,80,base64_encode($file_path),$file_name),true);
									echo $this->Html->image($image_url,array('class'=>''));
								}
								else 
								{
									echo $this->Html->image('user1.png',array('class'=>''));
								}
							?>
						<div class="people_name"><h4 class="user_name"><?php $full_name = $value['User']['firstname'].' '.$value['User']['lastname']; ?><?php echo $this->Html->link($full_name,array('controller'=>'host_jumpers','action'=>'index',$value['User']['slug']));?></h4>
						  <p><?php echo $value['User']['city'];  ?> <?php echo $value['User']['country'];  ?></p></div>
					   </div>
					 </div>
					 <?php }  ?>
					 <?php } else { ?>
						<div class="no-record">No Host Jumpers Found</div>
					 <?php } ?>
                   <!--<ul class="pagination">
                    <li>
                      <a href="#" aria-label="Previous">
                        <span class="fa fa-caret-left"></span>
                      </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">8</a></li>

                    <li>
                      <a href="#" aria-label="Next">
                        <span class="fa fa-caret-right"></span>
                      </a>
                    </li>
                  </ul>-->
                </div>
              </div>
               <div id="sectionB" class="col-md-12 col-sm-12 tab-pane fade">
               <div class="date_section">
                   <div class="row">
					<?php  if(isset($JumpHost_record) && !empty($JumpHost_record)) { ?>
					<?php foreach($JumpHost_record as $key =>$value){ ?>
                      <div class="col-xs-4 hotel">
                         <div class="">
							 <?php
								$file_path		=	ALBUM_UPLOAD_JUMP_HOST_IMAGE_PATH;
								$file_name		=	$value['JumpHost']['image'];
								if($file_name && file_exists($file_path . $file_name)) {
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',350,450,base64_encode($file_path),$file_name),true);
									echo $this->Html->image($image_url,array('class'=>'img-responsive search_Jumphost_Image','url'=>array('controller'=>'jump_hosts','action'=>'detail',$value['JumpHost']['slug'])));
								}
								else 
								{
									echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));
								}
							?>
                           <!-- <div class="hotel_star">
                             <div class="star">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                          </div>-->
                         </div>
                      </div>
					  <?php } ?>
					  <?php } else{ ?>
					  
					  <div class="no-record">No JumpHost Record Found</div>
					  
					  <?php } ?>
						<ul class="pagination">
						  <li>
								<?php echo $this->element('pagination'); ?>
						  </li>
						</ul>
                  </div>
               </div>
              </div>
			  <div id="sectionC" class="col-md-12 col-sm-12 tab-pane fade">
               <div class="date_section">
                   <div class="row">
					<?php  if($jump_record){ ?>
					<?php foreach($jump_record as $key => $value){ ?>
					<div class="col-md-4">
						<div class="profile">
						  <div class="top_title">
						  <a href="#">
							<?php
								$file_path		=	ALBUM_UPLOAD_IMAGE_PATH;
								$image_name 	= 	$value['Jump']['logo']['User']['image'];
								if($image_name !='') {
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',40,41,base64_encode($file_path),$image_name),true);
									echo $this->Html->image($image_url,array('class'=>'img_radius'));
								}else {
									echo $this->Html->image('main_profile.png',array('class'=>''));
								}
								?>
							<?php //echo $this->html->image('johndoe.png',array('class'=>''))?>
						<?php $full_name = $value['Jump']['logo']['User']['firstname'].' '.$value['Jump']['logo']['User']['lastname'];?><?php echo $this->Html->link($full_name,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?></a>
						  <div class="date"><?php echo date('d M y',strtotime($value['Jump']['created']));?></div>
						</div>
						<?php
								$file_path		=	ALBUM_UPLOAD_JUMP_IMAGE_PATH;
								$image_name 	= 	$value['Jump']['image'];
								if($image_name !='') {
									$image_url		=	$this->Html->url(array('plugin'=>'imageresize','controller' => 'imageresize', 'action' => 'get_image',470,309,base64_encode($file_path),$image_name),true);
									$images =  $this->Html->image($image_url,array('class'=>'img-responsive profile_img'));
									 echo $this->Html->link($images,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']),array('escape'=>false));
								}else {
									echo $this->Html->image('main_profile.png',array('class'=>'img-responsive profile_img'));
								}
								?>
						<?php //echo $this->html->image('02_main_profile_v4_03.jpg',array('class'=>'img-responsive profile_img'))?>
						<div class="bottom_title">
						<?php $title = $this->Text->truncate($value['Jump']['title'],20); ?>
						  <?php echo $this->Html->link($title,array('plugin'=>false,'controller'=>'jumps','action'=>'index',$value['Jump']['slug']));?>
						  <a class="comment" href="#"><i class="fa fa-comment-o"></i> 7</a>
						</div>
						</div>
					</div>
					<?php } ?>
					<?php } else {?>
					<div class="no-record">No Jump Record Found</div>
					 <?php } ?>
						<ul class="pagination">
						  <li>
								<?php echo $this->element('pagination'); ?>
						  </li>
						</ul>
                  </div>
               </div>
              </div>
      			</div>
        </div>			
      </div>
	</div>
</div>