<?php
$host="localhost"; $dbname="supermarket_db"; $dbuser="root"; $dbpass="";
define("EMPLOYEE_REGISTRATION_CODE","STAFF-2026");
try {$pdo=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$dbuser,$dbpass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);}
catch(PDOException $e){die("Database connection failed. Check config.php and import database.sql.");}
if(session_status()===PHP_SESSION_NONE) session_start();
