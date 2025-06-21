<?php
require_once "db.php"; // must be inside PHP block

$table = 'contact_messages';  // Table to store the data
$admin_email = 'isolintllc@gmail.com'; // Optional: for email notification

// --- Retrieve and sanitize POST data ---
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// --- Basic validation ---
if (!$name || !$email || !$message || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

try {
    // --- Insert into database ---
    $stmt = $pdo->prepare("INSERT INTO $table (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
    exit;
}

// --- Optional: Send confirmation email to admin ---
$subject = "New Contact Form Submission";
$headers = "From: $name <$email>\r\nReply-To: $email\r\n";
$body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

@mail($admin_email, $subject, $body, $headers);

// --- Response to browser ---
http_response_code(200);
echo "Thank you, your message has been received.";
?>
