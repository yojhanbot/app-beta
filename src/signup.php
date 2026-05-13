<?php
include('../config/database.php');

// Captura de datos
$f_name = $_POST['fname'];
$l_name = $_POST['lname'];
$email = $_POST['email'];
$m_phone = $_POST['mphone'];
$p_ssword = password_hash($_POST['passwd'], PASSWORD_BCRYPT); // Seguridad: Hash de contraseña
$s_ttstatus = "active";
$p_hoto = "default.png";

// 1. Preparamos la consulta (evita Inyección SQL)
$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password, status, url_photo) 
        VALUES ($1, $2, $3, $4, $5, $6, $7)";

// 2. Ejecutamos y guardamos el resultado en la variable
$res_local = pg_query_params($db_connection, $sql, array(
    $f_name, $l_name, $email, $m_phone, $p_ssword, $s_ttstatus, $p_hoto
));

// 3. Aquí insertas tu IF
if ($res_local) {
    echo "<script>alert('Registro exitoso')</script>";
    header('refresh:0;url=singnin.html');
    // Podrías redirigir: header("Location: login.php");
} else {
    echo "Error al registrar el usuario: " . pg_last_error($db_connection);
}
?>