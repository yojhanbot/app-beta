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

// ==================== CONFIG SUPABASE ====================
$supabase_url = 'https://xhitjiybpdjnvfevxplw.supabase.co';
$supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhoaXRqaXlicGRqbnZmZXZ4cGx3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzI4MDMzNjAsImV4cCI6MjA4ODM3OTM2MH0.9uoT6pjKrX_c5GYefnKj5PSf27wt4xD_Fjl9K7j49E8';

// ==================== FEATURE 4 + FEATURE 3: HASH + REGISTRO ATÓMICO ====================
$hashed_password = password_hash($p_ssword, PASSWORD_BCRYPT);

$local_id = null;
$supa_id  = null;

try {
    // 1. Insertar en PostgreSQL local (con RETURNING para obtener el ID)
    $result = pg_query_params($conn, 
        "INSERT INTO users (firstname, lastname, email, mobilephone, password) 
         VALUES ($1, $2, $3, $4, $5) RETURNING id", 
        [$f_name, $l_name, $email, $m_phone, $hashed_password]);

    if (!$result) {
        throw new Exception('Error al insertar en PostgreSQL local');
    }
    $row = pg_fetch_assoc($result);
    $local_id = $row['id'];

    // 2. Insertar en Supabase
    $data = [
        'firstname'   => $f_name,
        'lastname'    => $l_name,
        'email'       => $email,
        'mobilephone' => $m_phone,
        'password'    => $hashed_password
    ];

    $ch = curl_init("$supabase_url/users");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 201) {
        throw new Exception('Error al insertar en Supabase');
    }

    $supa_body = json_decode($response, true);
    $supa_id = $supa_body[0]['id'] ?? null;

    // ÉXITO TOTAL
    echo json_encode([
        'message' => 'Usuario registrado correctamente en ambas bases de datos (Feature 3 - Registro atómico)',
        'user'    => ['id' => $local_id, 'email' => $email]
    ]);

} catch (Exception $e) {
    // ==================== ROLLBACK (ATOMICIDAD) ====================
    if ($local_id !== null) {
        pg_query_params($conn, "DELETE FROM users WHERE id = $1", [$local_id]);
    }
    if ($supa_id !== null) {
        $ch = curl_init("$supabase_url/users?id=eq.$supa_id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $supabase_key",
            "Authorization: Bearer $supabase_key"
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    echo json_encode([
        'message' => 'Error al registrar usuario. Se revirtió la operación en ambas bases de datos.'
    ]);
}
?>