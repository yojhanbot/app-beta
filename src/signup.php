<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include('../config/database.php');

$f_name   = $_POST['fname']   ?? '';
$l_name   = $_POST['lname']   ?? '';
$email    = $_POST['email']   ?? '';
$m_phone  = $_POST['mphone']  ?? '';
$p_ssword = $_POST['passwd']  ?? '';

if (empty($email) || empty($p_ssword) || empty($m_phone)) {
    echo json_encode(['message' => 'Faltan datos obligatorios']);
    exit;
}

// ==================== FEATURE 4: HASH DE CONTRASEÑA ====================
$hashed_password = password_hash($p_ssword, PASSWORD_BCRYPT);

// Insertar con la contraseña hasheada (nunca guardamos la contraseña en texto plano)
$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password) 
        VALUES ($1, $2, $3, $4, $5)";
pg_query_params($conn, $sql, [$f_name, $l_name, $email, $m_phone, $hashed_password]);

echo json_encode([
    'message' => 'Usuario registrado correctamente (Feature 4 - Contraseña hasheada con éxito)',
    'note'    => 'La contraseña ya no se guarda en texto plano'
]);
?>