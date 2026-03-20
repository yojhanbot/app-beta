<?php
// Signup logic here
include('../config/database.php');
//get the form data
$f_name = $_POST['fname'];
$l_name = $_POST['lname'];
$email = $_POST['email'];
$m_phone = $_POST['mphone'];
$p_ssword = $_POST['passwd'];

//query to insert data into the database
$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password) VALUES ('$f_name', '$l_name', '$email', '$m_phone', '$p_ssword')";

//execute the query
pg_query($sql);
?>