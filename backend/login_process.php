<?php 
session_start(); 
require_once 'config.php'; 

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$postedRole = trim($_POST['role'] ?? '');
$isResidentForm = $postedRole === '';
$loginPage = $isResidentForm ? '../resident_login.php' : '../admin_login.php';

if (empty($email) || empty($password)) {
    $_SESSION['toast'] = "Email and password are required";
    $_SESSION['toast_type'] = "warn";
    header("Location: $loginPage"); 
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast'] = "Invalid email format, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage"); 
    exit();
}

$user = $usersCollection->findOne(['email' => $email]);

if (!$user) {
    $_SESSION['toast'] = "User does not exist, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage"); 
    exit();
}

$stored = isset($user['password']) ? (string)$user['password'] : '';

if ($stored === '') {
    $_SESSION['toast'] = "Account not yet registered, please try again";
    $_SESSION['toast_type'] = "info";
    header("Location: $loginPage"); 
    exit();
}

if (!password_verify($password, $stored)) {
    $_SESSION['toast'] = "Incorrect password, please try again";
    $_SESSION['toast_type'] = "error";
    header("Location: $loginPage"); 
    exit();
}

// Safely get role and status
$userRole = $user['role'] ?? 'Resident';
$userStatus = $user['status'] ?? 'Active';
$_SESSION['status'] = $userStatus;


// Prevent using wrong form
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
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $userRole;
$_SESSION['user_id'] = (string)($user['_id'] ?? '');
$_SESSION['username'] = $user['email']; 
$_SESSION['status'] = $userStatus;

// Resident account status checks
if ($userRole === 'Resident') {

    if ($userStatus === 'Pending' || $userStatus === 'Rejected') {
        unset($_SESSION['email'], $_SESSION['role'], $_SESSION['user_id'], $_SESSION['username'], $_SESSION['status']);

        $_SESSION['toast'] = $userStatus === 'Pending'
            ? "Account is not approved yet, please wait for approval"
            : "Account is rejected, please contact admin";
        $_SESSION['toast_type'] = $userStatus === 'Pending' ? "warn" : "error";

        header("Location: $loginPage");
        exit();
    }
}

// Redirect to dashboards
header("Location: " . ($userRole === 'Barangay Staff' 
    ? '../pages/admin/admin_dashboard.php' 
    : '../pages/resident/resident_dashboard.php'));
exit();
