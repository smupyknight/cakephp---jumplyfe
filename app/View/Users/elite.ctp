
<?php echo $this->element('menu');?>

<div class="right_profile bgcolor">
  <div class="container">
     <div class="row">
	 <?php if(isset($left_part_user_id) && !empty($left_part_user_id)){ ?>
        <?php echo $this->element('user_profile_left_bar');?>
		<?php } ?>
        <div class="col-md-9 col-sm-9">
			<?php echo $this->Session->flash(); ?>
			<h4>Your elite membership plan will be expire on <?php echo date('d M Y',strtotime($elite_membership_expire_date)); ?>
			<?php echo $this->Html->link('Manage Membership',array('plugin'=>false,'controller'=>'elites','action'=>'manage_membership'),array('class'=>'btn btn-primary pull-right'));?></h4>
			<div class="btn-style">
				<div class="btn-group btn-group-justified my_active_group">
					<div class="btn-group " role="group">
						<button type="button" onclick="seteliteType(this)" data-start_date="<?php echo $date['current_date']; ?>" data-end_date="<?php echo $date['current_date_to_six_month']; ?>" class="btn active btn-advance my_active">Book within the next SIX months</button>
					</div>
					
					<div class="btn-group" role="group">
						<button type="button" onclick="seteliteType(this)" class="btn btn-advance" data-start_date="<?php echo $date['date_after_six_month']; ?>" data-end_date="<?php echo $date['date_after_six_to_twelve_month']; ?>">Book 6 - 12 months in ADVANCE</button>
					</div>
				</div>
			</div>
			<div class="load_content">
				<!-- Load content By Ajax -->
			</div> 
        </div>
     </div>
  </div>
</div>
<script>
$(function(){
	getRecord();
});

function seteliteType($this){
$($this).closest('.my_active_group').find('button').removeClass('my_active').removeClass('active');
$($this).addClass('my_active').addClass('active');
$(".load_content").html('');
	getRecord();
}
function getRecord(){
var $this = $('.my_active_group .my_active');
	$.ajax({
	
		type: "post",
		url: "<?php echo Router::url(array("plugin"=>false,"controller"=>"users",'action' => 'elite_content')); ?>",
		data:{'start_date':$($this).attr("data-start_date"),'end_date':$($this).attr("data-end_date")},
		dataType:"json",
		success:function(data){
			$.each(data.eliteoffer_record,function(key,value){
				if(value.image_url != '')
				{
					var image = '<img src="'+value.image_url+'" class="img-responsive"/>';
				} 
				else 
				{ 
					var image =	'<?php echo $this->Html->image('main_profile.png',array('class'=>'img-responsive'));?>';
				}
				
				var i;
				var rating_star_text = '';
				var disable_rating_star_text = '';
				
				var ratings = value.rating;
				var disableRating = parseInt(5) - value.rating;
				
				if(ratings != 0){
					for(i=1; i<=ratings; i++){
						rating_star_text = rating_star_text + '<i class="fa fa-star"></i>';
					}
				}
				if(disableRating != 0){
					for(i=1; i<=disableRating; i++){
						disable_rating_star_text = disable_rating_star_text + '<i class="fa fa-star disable"></i>';
					}
				}
				
				var html = '<div class="grand"><a href="'+value.search_url+'">'+image+'</a><div class="price_tag">'+value.off_percent+'% Off</div>' + '<h3 class="grand_title"><a href="'+value.search_url+'">'+value.title+'</a></h3><div class="grand_right"><p>'+value.description+'</p><div class="star-patten">'+rating_star_text + disable_rating_star_text+'</div><div class="destination">Destination :<span>'+value.city+'</span><h4>price :  </h4></div><div class="duration">Duration :<span>'+value.valid_days+' days</span><h4><span class="rate">$'+value.total_pri+'</span>$'+value.total_price+'</h4> </div><div class="clearfix"></div><a class="btn btn-primary btn-block" href="'+value.search_url+'">Book</a></div></div>';
				$(".load_content").append(html);
			});
			if(data.eliteoffer_record.length < 1)
			{
				var html = '<div class="no-record"><span>No Elite Offers found</span></div>';
				$(".load_content").html(html);
			}
		} 
	});
}
</script>
