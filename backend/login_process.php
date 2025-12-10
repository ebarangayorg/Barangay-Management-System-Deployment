<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/config.php';


// Get POST data safely
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$postedRole = trim($_POST['role'] ?? '');
$isResidentForm = $postedRole === '';
$loginPage = $isResidentForm ? '../resident_login.php' : '../admin_login.php';

// Validate required fields
if (empty($email) || empty($password)) {
    $_SESSION['toast'] = "Email and password are required";
    $_SESSION['toast_type'] = "warn";
    header("Location: $loginPage");
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast'] = "Invalid email format, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Find user in database
$user = $usersCollection->findOne(['email' => $email]);

if (!$user) {
    $_SESSION['toast'] = "User does not exist, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Get stored password safely
$stored = isset($user['password']) ? (string)$user['password'] : '';
if ($stored === '') {
    $_SESSION['toast'] = "Account not yet registered, please try again";
    $_SESSION['toast_type'] = "info";
    header("Location: $loginPage");
    exit();
}

// Verify password
if (!password_verify($password, $stored)) {
    $_SESSION['toast'] = "Incorrect password, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

// Determine user role
$userRole = $user['role'] ?? 'Resident';

// Prevent wrong form usage
if ($isResidentForm && $userRole === 'Barangay Staff') {
    $_SESSION['toast'] = "Invalid role, please use the correct login form";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage");
    exit();
}

if (!$isResidentForm && $postedRole !== $userRole) {
    $_SESSION['toast'] = "Invalid role, please use the correct login form";
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

// Resident account status checks
if ($userRole === 'Resident') {
    $status = $user['status'] ?? null;

    if ($status === 'Pending') {
        unset($_SESSION['email'], $_SESSION['role'], $_SESSION['user_id'], $_SESSION['username'], $_SESSION['status']);
        $_SESSION['toast'] = "Account is not approved yet, please wait for approval";
        $_SESSION['toast_type'] = "warn";
        header("Location: $loginPage");
        exit();
    }

    if ($status === 'Rejected') {
        unset($_SESSION['email'], $_SESSION['role'], $_SESSION['user_id'], $_SESSION['username'], $_SESSION['status']);
        $_SESSION['toast'] = "Account is rejected, please contact admin";
        $_SESSION['toast_type'] = "error";
        header("Location: $loginPage");
        exit();
    }
}

// Redirect to dashboards
if ($userRole === 'Barangay Staff') {
    header("Location: ../pages/admin/admin_dashboard.php");
} else {
    header("Location: ../pages/resident/resident_dashboard.php");
}
exit();
?>
