<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Google Sheets API URL
    $googleSheetsURL = 'https://script.google.com/a/macros/innofied.com/s/AKfycbzXSFhgvr5Rf-iyzB4IztxYOEuhQ-zPMXIsSVHXAu-9Dd39DqGgajkwRAz9x_c2fyE/exec';

    // Prepare data
    $postData = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
    ];

    // Send data to Google Sheets
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($postData),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($googleSheetsURL, false, $context);

    if ($response === FALSE) {
        echo json_encode(['success' => false, 'message' => 'Error connecting to Google Sheets.']);
    } else {
        $responseData = json_decode($response, true);
        echo json_encode($responseData);
    }
    exit;
}