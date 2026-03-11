<?php
// Local.database configuration
$LOCAL_HOST     = "localhost";//127.0.0.1
$LOCAL_DBNAME   = "app_beta";
$LOCAL_USERNAME = "postgres";
$LOCAL_PASSWORD = "1234";
$LOCAL_PORT     = 5432;

// supabase configuration
$SUPABASE_HOST     = "localhost";
$SUPABASE_DBNAME   = "app-beta";
$SUPABASE_USERNAME = "supabase_user";
$SUPABASE_PASSWORD = "supabase_password";
$SUPABASE_PORT     = 5432;

$data_connection = "
host= $LOCAL_HOST
port= $LOCAL_PORT
dbname= $LOCAL_DBNAME
user= $LOCAL_USERNAME
password= $LOCAL_PASSWORD
  
";
$conn = pg_connect($data_connection);
if(!$conn) {
    echo "ERROR: Unable to connect to the database!";
    exit();
}else {
    echo "SUCCESS: Connected to the database!";
}

?>