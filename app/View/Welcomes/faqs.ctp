<?php echo $this->element('top_slider');  ?>
<div class="about_us">
 <div class="container">
    <h3 class="title">Faqs</h3>
     <dl id="accordion">
		<?php if($record){ ?>
			<?php foreach($record as $value){ ?>
				<dt><?php echo $value['Faq']['question']; ?></dt>
				<dd>
					<div class="accordin_contain">
						<?php echo $value['Faq']['answer']; ?>
					</div>
				</dd>
			<?php } ?>
		<?php } else {?>
		<div class="not_found"></div>
		<?php } ?>
    </dl>
 </div>
</div>
