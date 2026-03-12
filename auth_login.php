<?php
// MOPADAUG SA CONNECTION GIKAN SA FLUTTER WEB (CORS FIX)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Tubagon ang browser kung mangutana pa lang kini (Preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json");
include 'connection.php'; 

// Dawaton ang data bisan unsaon pagpadala sa Flutter (POST o JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$email = isset($_POST['email']) ? $_POST['email'] : ($data['email'] ?? '');
$password = isset($_POST['password']) ? $_POST['password'] : ($data['password'] ?? '');

if (!empty($email) && !empty($password)) {
    // Siguruha nga ang table name "users" ug naay columns: email, password, role
    $stmt = $conn->prepare("SELECT id, email, role FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = array();
    while ($row = $result->fetch_assoc()) {
        $row['usr_fullname'] = explode('@', $row['email'])[0]; 
        $users[] = $row;
    }

    echo json_encode($users);
} else {
    // Kung ma-access ang link pero walay email/pass gipasa
    echo json_encode(["message" => "Please provide credentials"]);
}
?>