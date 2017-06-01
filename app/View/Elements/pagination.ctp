<?php 
	$paginator	=	$this->Paginator;
	if ( !isset($queryString) )
		$queryString = '';
	
	$options = array('class'=>'p_numbers','separator'=> '');
	
	//echo $paginator->numbers(array('modulus' => '3', 'class'=>'paging', 'separator'=>'&nbsp;', 'queryString' => $queryString));
?>

<script type="text/javascript">
// <![CDATA[
/*$(function() {
	
	$( ".first_disabled, #p_first" ).button({
			text: false,
			icons: {
				primary: "ui-icon-seek-start"
			}
		}).click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});
		
		$( "#p_prev, .prev_disabled" ).button({
			text: false,
			icons: {
				primary: "ui-icon-seek-prev"
			}
		}).click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});
		
			$( "#p_next, .next_disabled" ).button({
			text: false,
			icons: {
				primary: "ui-icon-seek-next"
			}
		}).click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});
		
		$( "#p_last" ).button({
			text: false,
			icons: {
				primary: "ui-icon-seek-end"
			}
			}).click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});
		
		$(".p_numbers").button().click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});

	
		$("span.current").button().click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		});
		$("span.current").addClass("ui-state-active").click(function(){
			if(typeof(this.href) !='undefined'){
				return loadContent(this.href);
			}
		}); 
		
		
		});
	*/	
	
//]]>	
</script>

<?php
$pages	=	$paginator->counter(array('format' => '%pages%')); 
if($pages>1){
 ?>
 
	<nav>
	  <ul class="pagination">
	<?php 
		//echo $paginator->first(__('First', true), array('id'=> 'p_first','tag'=>'li'), null, array('class'=>''));
		echo $paginator->prev(__("<i class='fa fa-caret-left'></i>", true), array('id'=> 'p_prev','tag'=>'li','escape'=>false), null, array('class'=>'previous p_numbers','escape'=>false));
		echo $paginator->numbers($options,array('tag'=>'li'));
		echo $paginator->next(__("<i class='fa fa-caret-right'></i> ", true), array('id'=> 'p_next','tag'=>'li','escape'=>false), null, array('class'=>'current','escape'=>false));
		//echo $paginator->last(__('Last', true), array('id'=> 'p_last','tag'=>'li'), null, array('class'=>''));
	?></ul>
	</nav>
<?php 
}
?>
