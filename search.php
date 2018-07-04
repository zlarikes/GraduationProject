
	<?php
		require 'include/init.php';
	
		$foodName = $_POST['foodName'];


		$res['data'] = $db->queryArray("SELECT * FROM f_foods t where t.food_Name like '%$foodName%'");
		echo json_encode($res);
	?>