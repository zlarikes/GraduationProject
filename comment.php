<?php
require_once "include/init.php";
if($_POST['content']){
    $foodName = $_POST['foodName'];
    $content = addslashes($_POST['content']);
    $member = $_POST['member'];
    $name = $_SESSION['userName'];

    $res['state'] = $db->query("insert into f_comment(food_name,comment,member) values('$foodName','$content','$name')");
    $res['data'] = $db->queryArray("select * from f_comment");
    echo json_encode($res);
}