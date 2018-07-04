<?php
require 'include/init.php';
if(isset($_GET['savecount']) && isset($_GET['date']) && isset($_GET['savename'])) {
	$res = $db->query("insert into f_table_save (member,table_name,book_time,book_num,name)  values('{$_SESSION['userName']}','{$_GET['tableName']}','{$_GET['date']}','{$_GET['savecount']}','{$_GET['savename']}')");
	/*if ($res) {*/
		// if($num>$tableCount['num']){
		// 	echo "<script>alert('预定失败，超过数量，请重新预定~');window.location.reload(true);</script>";
		// }else{
		// 	$sql = $db->query("update f_table_save2 set num=(num-{$num})");
		// 	$db->query("insert into f_table_save(member,table_name,book_time,book_num,name) values('{$_SESSION['userName']}','$tableName','{$time}',{$num},'{$name}')");
		// 	echo "<script>alert('预定成功~');top.location.href='index.php'</script>";
		// }
	// } 
}

?>