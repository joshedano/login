<?php
// db.php
$host = "aws-0-ap-northeast-1.pooler.supabase.com";
$user = "postgres.pmiihlrtamgfzdkuwjye";
$password = "vl1F1sMOowXZmDAw";
$database = "postgres";

$conn = new mysqli($host,$user, $password,$database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>