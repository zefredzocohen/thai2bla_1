<?php

	require_once(dirname(__FILE__).'/connector/db_sqlite3.php');
	
	// SQLite
//	$dbtype = "SQLite3";
//	$res = new SQLite3(dirname(__FILE__)."/database.sqlite");

	// Mysql
	 $dbtype = "MySQL";
	 $res=mysql_connect("localhost", "lifeone18_4bizn", "aGHoUSt7");
	 mysql_select_db("lifeone18_4bizdb");
?>