<?php echo $this->element('top_slider');  ?>
<div class="about_us">
 <div class="container">
    <h3 class="title">Policies</h3>
     <dl id="accordion">
		<?php if(isset($record) && !empty($record)){ ?>
			<?php foreach($record as $value){ ?>
				<dt><?php echo $value['Policy']['title']; ?></dt>
				<dd>
					<div class="accordin_contain">
						<?php echo $value['Policy']['description']; ?>
					</div>
				</dd>
			<?php } ?>
		<?php } else {?>
		<div class="not_found"></div>
		<?php } ?>
		
    </dl>

 </div>

</div>