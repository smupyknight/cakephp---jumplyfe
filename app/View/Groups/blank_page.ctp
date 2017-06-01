<input type="text" class="autoCompletetext">
<script>
$(function(){
	$(document).on("mouseenter",".autoCompletetext",function(){
		$(this).autocomplete({
			source: '<?php echo Router::url(array('plugin'=>false,'controller'=>'groups','action'=>'getMembersAuto')); ?>',
			minLength: 2,
			select: function(event, ui) {
				 $(".autoCompletetext").val(ui.item.label);
				 //window.search_city_id = ui.item.id;
			   //getCityPricesByCityID();
			   return false
			  
			},
	 
			html: true, // optional (jquery.ui.autocomplete.html.js required)
	 
		  // optional (if other layers overlap autocomplete list)
			open: function(event, ui) {
				 $(this).autocomplete('widget').css('z-index', 9999999);
				 return false;
			
			}
		});
	 });
	 //getCityPricesByCityID();
});
</script>