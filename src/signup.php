<?php
// Signup logic here
include('../config/database.php');
//get the form data
$f_name = $_POST['fname'];
$l_name = $_POST['lname'];
$email = $_POST['email'];
$m_phone = $_POST['mphone'];
$p_ssword = $_POST['passwd'];
$s_ttstatus = "active";
$p_hoto = "default.png";
    

//query to insert data into the database
$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password, status, url_photo) VALUES ('$f_name', '$l_name', '$email', '$m_phone', '$p_ssword', '$s_ttstatus', '$p_hoto')";

//execute the query
pg_query($sql);
?>