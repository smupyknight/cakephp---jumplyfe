<?php
$paginator	=	$this->Paginator;
$default 	= 	Configure::read('defaultPaginationLimit');
if (!isset($limitValue)) {
	$limitValue = Configure::read('defaultPaginationLimit');
}
$pagingViews = Configure::read('pagingViews');
?>
<div class="pull-left">
<form method="post" class="form-horizontal">
   <div class="pull-left grytxt12 pr10 pt5"><?php echo $paginator->counter(array('format' => 'Page %page% of&nbsp;&nbsp;%pages%, Total records %count% | ')); ?>Views&nbsp;&nbsp;</div>
   <div class="pull-left"><select  onchange="this.form.submit();" name="data[recordsPerPage]" style="width:85px;"  class="lstfld60">
     <option value="<?php echo $default;  ?>">Default</option>
    <?php
    	foreach ($pagingViews as $views) { ?>
			 <option <?php if ($limitValue == $views) { echo 'selected="selected"'; } ?> value="<?php echo $views; ?>"><?php echo $views; ?></option>
	<?php } ?>
     </select>
     </div>
   <div class="clr"></div>
   </form>
   </div>