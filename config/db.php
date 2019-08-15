<?php

class Database {
    public static function connect(){
		
        $db = new mysqli("DBHOST", "DBUSER", "DBPASSWORD", "DBNAME");
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}