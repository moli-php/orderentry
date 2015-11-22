<div class="container" style="">
<?php
echo "<ol class='breadcrumb'>";
if(count($breadcrumb)){
		$pages = "";
	foreach($breadcrumb as $index => $page){
		$pages .= $page .'/';
		$index++;
		if(count($breadcrumb) == $index){
			echo "<li class='active'>".ucfirst($page)."</li>";
		}else{
			echo "<li><a href='".BASE_URL."/{$pages}'>".ucfirst($page)."</a></li>";
		}

	}
}else{
	echo "<li><a href='".BASE_URL."'>Customer</a></li>";
}
echo "</ol>";
?>
</div>
