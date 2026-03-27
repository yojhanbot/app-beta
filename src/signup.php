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
/*
// ==================== FEATURE 1: EMAIL ÚNICO ====================
// Validación en PostgreSQL local
$result = pg_query_params($conn, "SELECT id FROM users WHERE email = $1 LIMIT 1", [$email]);
if (pg_num_rows($result) > 0) {
    echo json_encode(['message' => 'El correo electrónico ya está registrado en el sistema.']);
    exit;
}*/

// ==================== FEATURE 2: NÚMERO DE CELULAR ÚNICO ====================
// Validación en PostgreSQL local
$result = pg_query_params($conn, "SELECT id FROM users WHERE mobilephone = $1 LIMIT 1", [$m_phone]);
if (pg_num_rows($result) > 0) {
    echo json_encode(['message' => 'El número de celular ya está registrado en el sistema.']);
    exit;
}

// Validación en Supabase
$supabase_url = 'https://xhitjiybpdjnvfevxplw.supabase.co'; 
$supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhoaXRqaXlicGRqbnZmZXZ4cGx3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzI4MDMzNjAsImV4cCI6MjA4ODM3OTM2MH0.9uoT6pjKrX_c5GYefnKj5PSf27wt4xD_Fjl9K7j49E8'; 
$ch = curl_init("$supabase_url/users?select=id&email=eq.$email&limit=1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabase_key",
    "Authorization: Bearer $supabase_key"
]);
$response = curl_exec($ch);
curl_close($ch);

if (!empty(json_decode($response, true))) {
    echo json_encode(['message' => 'El correo electrónico ya está registrado en Supabase.']);
    exit;
}

/*
$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password) 
        VALUES ($1, $2, $3, $4, $5)";
pg_query_params($conn, $sql, [$f_name, $l_name, $email, $m_phone, $p_ssword]);

echo json_encode(['message' => 'Usuario registrado correctamente (Feature 1 - Email único validado)']);*/

$sql = "INSERT INTO users (firstname, lastname, email, mobilephone, password) 
        VALUES ($1, $2, $3, $4, $5)";
pg_query_params($conn, $sql, [$f_name, $l_name, $email, $m_phone, $p_ssword]);

echo json_encode(['message' => 'Usuario registrado correctamente (Feature 2 - Número de celular único validado)']);
?>