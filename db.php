<?php
$host = "aws-0-ap-northeast-1.pooler.supabase.com";
$user = "postgres.pmiihlrtamgfzdkuwjye";
$password = "vl1F1sMOowXZmDAw";
$database = "postgres";
$port = 5432; // Standard pooler port for Supabase

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>