<?php
// Local.database configuration
$LOCAL_HOST     = "localhost";//127.0.0.1
$LOCAL_DBNAME   = "app_beta";
$LOCAL_USERNAME = "postgres";
$LOCAL_PASSWORD = "1234";
$LOCAL_PORT     = 5432;

// supabase configuration
$SUPABASE_HOST     = "aws-1-us-east-2.pooler.supabase.com";
$SUPABASE_DBNAME   = "postgres";
$SUPABASE_USERNAME = "postgres.xhitjiybpdjnvfevxplw";
$SUPABASE_PASSWORD = "1089458374Ca";
$SUPABASE_PORT     = 6543;
// local connection
$local_data_connection = "
host= $LOCAL_HOST
port= $LOCAL_PORT
dbname= $LOCAL_DBNAME
user= $LOCAL_USERNAME
password= $LOCAL_PASSWORD
  
";
$local_conn = pg_connect($local_data_connection);
if(!$local_conn) {
    echo "ERROR: Unable to connect to the local database!";
    exit();
}else {
    echo "SUCCESS: Connected to the local database!";
}
// supabase connection
$supabase_data_connection = "
host= $SUPABASE_HOST
port= $SUPABASE_PORT
dbname= $SUPABASE_DBNAME
user= $SUPABASE_USERNAME
password= $SUPABASE_PASSWORD
  
";
$supabase_conn = pg_connect($supabase_data_connection);
if(!$supabase_conn) {
    echo "<br>ERROR: Unable to connect to the supabase database!";
    exit();
}else {
    echo "<br>SUCCESS: Connected to the supabase database!";
}
?>