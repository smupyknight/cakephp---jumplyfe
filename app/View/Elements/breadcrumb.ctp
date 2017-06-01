<ul class="breadcrumb">
<?php foreach($breadcrumb['pages'] as $t => $l) { 

?>
    <li>
		<?php 			
			 echo $this->Html->link($t,$l);
		?>
	<span class="divider">/</span></li>
<?php }?>    
    <li class="active"><?php echo $breadcrumb['active'];?></li>
    </ul>
 