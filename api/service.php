<?php

// REST Service
if($class){
	if(file_exists('api/'.$class .'.php')){
		include_once "{$class}.php";
		// check if class exists1
		if(class_exists($class)){
			$obj = new $class;
			// check if method exists
			if(method_exists($obj, $action.ucfirst($class))){
				// check for data inputs
				if($request === "DELETE" || $request == "PUT"){
					$obj->{$action.ucfirst($class)}($id2);
					exit;
				}
				if(file_get_contents('php://input')){
					$obj->{$action.ucfirst($class)}();
				}else{
					echo "<h2>Error 400 : Bad Request</h2>";		
				}
			}else{
				echo "<h2>Error 400 : Bad Request</h2>";
			}
		}else{
			echo "<h2>Error 400 : Bad Request</h2>";
		}
	}else{
		echo "<h2>Error 400 : Bad Request</h2>";
	}
}else{
	echo "<h2>Error 400 : Bad Request</h2>";
}
exit;