<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

// Hide PHP warnings in production (optional)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Get POST data safely
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$postedRole = trim($_POST['role'] ?? '');
$isResidentForm = $postedRole === '';
$loginPage = $isResidentForm ? '../resident_login.php' : '../admin_login.php';

// Validate input
if (empty($email) || empty($password)) {
    $_SESSION['toast'] = "Email and password are required";
    $_SESSION['toast_type'] = "warn";
    header("Location: $loginPage");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast'] = "Invalid email format";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Find user
$user = $usersCollection->findOne(['email' => $email]);
if (!$user) {
    $_SESSION['toast'] = "User does not exist";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

$stored = (string)($user['password'] ?? '');
if ($stored === '' || !password_verify($password, $stored)) {
    $_SESSION['toast'] = "Incorrect password";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Role check
$userRole = $user['role'] ?? 'Resident';
if ($isResidentForm && $userRole === 'Barangay Staff') {
    $_SESSION['toast'] = "Invalid role";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

if (!$isResidentForm && $postedRole !== $userRole) {
    $_SESSION['toast'] = "Invalid role";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Set session
session_regenerate_id(true);
$_SESSION['email'] = $user['email'] ?? '';
$_SESSION['role'] = $userRole;
$_SESSION['user_id'] = isset($user['_id']) ? (string)$user['_id'] : '';
$_SESSION['username'] = $user['email'] ?? '';
$_SESSION['status'] = $user['status'] ?? null;

// Resident status
if ($userRole === 'Resident') {
    $status = $user['status'] ?? null;
    if ($status === 'Pending' || $status === 'Rejected') {
        unset($_SESSION['email'], $_SESSION['role'], $_SESSION['user_id'], $_SESSION['username'], $_SESSION['status']);
        $_SESSION['toast'] = $status === 'Pending'
            ? "Account not approved yet"
            : "Account rejected, contact admin";
        $_SESSION['toast_type'] = $status === 'Pending' ? "warn" : "error";
        header("Location: $loginPage");
        exit();
    }
}

// Redirect
header("Location: " . ($userRole === 'Barangay Staff'
    ? '../pages/admin/admin_dashboard.php'
    : '../pages/resident/resident_dashboard.php'));
exit();
