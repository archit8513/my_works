<?php

function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "metadata";
    $con= new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connection to Db failed: %s\n". $con -> error);
    return $con;
     
}
?>