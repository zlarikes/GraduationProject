<?php
/**
* Mysql 操作类
*/
class mysql{
	private $conn = NULL;
    private $_sql;

    public function getSql() {
        return $this->_sql;
    }

    function __construct($dbHost,$dbUser,$dbPwd,$dbName){ 
        $this->conn = mysql_connect($dbHost,$dbUser,$dbPwd,$dbName) or die ('连接MYSQL服务器出错');
        mysql_select_db($dbName,$this->conn) or die ('连接MYSQL数据库出错');
        mysql_query('set names utf8');
    }

    function query($str){ //执行 SQL 语句
            $sql = mysql_query($str,$this->conn) or die ('SQLERROR<br/>'.mysql_error().'<br/>'.$str);
            return $sql;
    }


    function numRows($sql){ //获得记录总数
            $res = mysql_query($sql);
            $num = mysql_num_rows($res);
            return $num;
    }

    function fetchObject($sql){ //返回一条记录
            return mysql_fetch_object($sql);
    }

    function fetchArray($sql, $type = MYSQL_ASSOC){ //查询多条记录
            return mysql_fetch_array($sql,$type);
    }

    function fetchAssoc($sql){ //查询多条记录
            return mysql_fetch_assoc($sql);
    }

    function fetchRow($sql){ //查询多条记录
            return mysql_fetch_row($sql);
    }

    function insertId(){ //取得上一步 INSERT 操作产生的 ID
            return mysql_insert_id();
    }

    function freeResult($sql){ //释放资源
            return mysql_free_result($sql);
    }

    function close(){ //关闭MYSQL连接
            return mysql_close($this->conn);
    }

    /******************************  以上是基本操作 以下是此mysql操作类的精华部分 *************************/

    function queryNum($sql){ //查询总数
            $sql = $this->query($sql,$this->conn);
            $num = mysql_num_rows($sql);
            $num = $num?$num:0;
            return $num;
    }

    function queryArray($sql){ //查询多条记录保存到数组
            $this->_sql=$sql;
            $sql = $this->query($sql,$this->conn);
            $num = mysql_num_rows($sql);
            if($num){
                    $array = array();
                    for($a=0; $row = mysql_fetch_array($sql,MYSQL_ASSOC); $a++){
                            $array[$a] = $row;
                    }
                    return $array;
            }else{
                    return false;
            }
    }

    function queryOne($sql){
            $sql = $this->query($sql,$this->conn);
            return mysql_fetch_array($sql,MYSQL_ASSOC);
    }

    function queryObject($sql){ //查询一条记录保存到数组
            $sql = $this->query($sql,$this->conn);
            $num = mysql_num_rows($sql);
            if($num){
                    $array = array();
                    $array = mysql_fetch_object($sql);
                    return $array;
            }else{
                    return false;
            }
    }

    function queryField($str){ //返回一条记录中一个字段
            $sql = $this->query($str,$this->conn);
   
            $row = mysql_fetch_row($sql);
            return $row[0];
    }
}