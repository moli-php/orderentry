<nav class="navbar navbar-default" role="navigation">
	<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
			<span class="sr-only">Toggle Navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a href="<?php echo BASE_URL; ?>" class="nav-brand" style="padding-right:10px;"><img src="<?php echo BASE_URL; ?>/assets/img/logo.png" height="50px;"  /></a>
	</div>
	<div>
		<ul class="nav navbar-nav" id="navbar-collapse">
			<?php 
			$menu = array('customer','product','profile');
			foreach($menu as $val){
				$this_page = $val == 'customer' ? "" : $val;
				if($page == $val){
					echo "<li class='active'><a href='".BASE_URL."/{$this_page}'>".ucfirst($val)."s</a></li>";
				}elseif($page == '' && $val == 'customer'){
					echo "<li class='active'><a href='".BASE_URL."/{$this_page}'>".ucfirst($val)."s</a></li>";
				}else{
					echo "<li><a href='".BASE_URL."/{$this_page}'>".ucfirst($val)."s</a></li>";
				}
			}
			?>
		</ul>
	</div>
	<div>
		<ul class="nav navbar-nav">
			<li class="<?php if($page == 'payment') echo 'active'; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL; ?>/payment/bydate">Order by date</a></li>
					<li><a href="<?php echo BASE_URL; ?>/payment/byname">Group by customers</a></li>
			</li>
		</ul>
	</div>
	<div>
		<ul class="nav navbar-nav">
			<li class="<?php if($page == 'purchase') echo 'active'; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchases <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL; ?>/purchase/bydate">Order by date</a></li>
					<li><a href="<?php echo BASE_URL; ?>/purchase/byname">Group by customers</a></li>
			</li>
		</ul>
	</div>
	<div>
		<ul class="nav navbar-nav">
			<li class="<?php if($page == 'add') echo 'active'; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Add <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL; ?>/add/customer">Customer</a></li>
					<li><a href="<?php echo BASE_URL; ?>/add/product">Product</a></li>
					<li><a href="<?php echo BASE_URL; ?>/add/order">Order Entry</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="form-group">
		<form class="navbar-form navbar-right" role="search"  >
			<div class="col-sm-10" style="padding:0px;">
				<input type="text" class="form-control" id="search_box" placeholder="Search..." <?php echo $is_disabled; ?> />
			</div>
		</form>
	</div>
	</div>
</nav>
