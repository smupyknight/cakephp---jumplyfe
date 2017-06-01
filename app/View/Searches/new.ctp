<?php echo $this->element('menu');?>

<div class="search_forms">
	<div class="container">
		<div class="search_forms_inner">
		  <ul class="nav nav-tabs nan-pills" role="tablist">
		    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Flights</a></li>
		    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Hotels</a></li>
		    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Car Rentals</a></li>
		    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Holiday Activities</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">
		    	<h3>Flights</h3>
		    	<form class="flight">
		    		<div class="btn-group form-group" data-toggle="buttons">
					  <label class="btn btn-primary active">
					    <input type="radio" name="options" id="option1" autocomplete="off" checked> Return
					  </label>
					  <label class="btn btn-primary">
					    <input type="radio" name="options" id="option2" autocomplete="off"> One way
					  </label>
					</div>
		    		<div class="row">
					  <div class="form-group col-sm-6">
					    <label class>Flying From</label>
					    <input type="text" class="form-control" placeholder="City or Airport">
					  </div>
					  <div class="form-group col-sm-6">
					    <label class>Flying to</label>
					    <input type="text" class="form-control" placeholder="City or Airport">
					  </div>
		    		</div>

		    		<div class="row">
					  <div class="form-group col-sm-3 col-xs-6 devicefull">
					    <label class>Departing</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-sm-3 col-xs-6 devicefull">
					    <label class>Returning</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
		    		</div>
		    		<div class="single_room">
		    		<h4>Room 1</h4>
		    		<div class="row">
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Adults(18+)</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Children(0-17)</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
		    		<div class="row">
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 1</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 2</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 3</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 4</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 5</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 6</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
		    		</div>
		    		<a href="#">Airline age rules opens in a new window <i class="fa fa-external-link"></i></a>
		    		<div class="clearfix"></div>
				  <button type="submit" class="btn btn-default">Search</button>
				</form>

		    </div>
		    <div role="tabpanel" class="tab-pane" id="profile">
		    	<h3>Hotels</h3>
		    	<form class="flight">
					  <div class="form-group">
					    <label class>Going to</label>
					    <input type="text" class="form-control" placeholder="Destination, airport, train station, landmark or address">
					  </div>

		    		<div class="row">
					  <div class="form-group col-sm-3 col-xs-6 devicefull">
					    <label class>Check in</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-sm-3 col-xs-6 devicefull">
					    <label class>Check out</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-sm-2 col-xs-6 half_devece">
					    <label class>Rooms</label>
					     <select class="form-control">
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
		    		<div class="single_room">
		    		<h4>Room 1</h4>
		    		<div class="row">
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Adults(18+)</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Children(0-17)</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
		    		<div class="row">
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 1</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 2</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 3</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 4</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 5</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>Child 6</label>
					    <select class="form-control">
					    	<option>Age</option>
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
		    		</div>
		    		<a href="#">Airline age rules opens in a new window <i class="fa fa-external-link"></i></a>
		    		<div class="clearfix"></div>
				  <button type="submit" class="btn btn-default">Search</button>
				</form>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="messages">
		    	<h3>Car Rental</h3>
		    	<form class="flight">
		    		<div class="row">
					  <div class="form-group col-sm-6">
					    <label class>Picking up</label>
					    <input type="text" class="form-control" placeholder="City, Airport or Address">
					  </div>
					  <div class="form-group col-sm-6">
					    <label class>Dropping off</label>
					    <input type="text" class="form-control" placeholder="Same as Pick-Up">
					  </div>
					</div>

		    		<div class="row">
					  <div class="form-group col-sm-3 col-xs-4 devicefull">
					    <label class>Pick up date</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>&nbsp;</label>
					    <select class="form-control">
					    	<option>10.00</option>
					    	<option>20.00</option>
					    	<option>30.00</option>
					    	<option>40.00</option>
					    </select>
					  </div>
					  <div class="form-group col-sm-3 col-xs-4 devicefull">
					    <label class>Drop off date</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-xs-2 half_devece">
					    <label class>&nbsp;</label>
					    <select class="form-control">
					    	<option>10.00</option>
					    	<option>20.00</option>
					    	<option>30.00</option>
					    	<option>40.00</option>
					    </select>
					  </div>
					  <div class="form-group col-sm-2 col-xs-6 half_devece">
					    <label class>Age</label>
					     <select class="form-control">
					    	<option>1</option>
					    	<option>2</option>
					    	<option>3</option>
					    	<option>4</option>
					    </select>
					  </div>
		    		</div>
				  <button type="submit" class="btn btn-default">Search</button>
				</form>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="settings">
		    	<h3>Holiday Activities</h3>
		    	<form class="flight">
					  <div class="form-group">
					    <label class>Destination</label>
					    <input type="text" class="form-control" placeholder="City">
					  </div>

		    		<div class="row">
					  <div class="form-group col-sm-3 col-xs-4 devicefull">
					    <label class>From</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
					  <div class="form-group col-sm-3 col-xs-4 devicefull">
					    <label class>To</label>
					    <input type="text" class="form-control" placeholder="dd/mm/yyyy">
					  </div>
		    		</div>
				  <button type="submit" class="btn btn-default">Search</button>
				</form>
		    </div>

		  </div>
	    </div>
	</div>
</div>