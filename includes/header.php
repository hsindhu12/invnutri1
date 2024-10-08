<?php
session_start();
require '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to check permissions
function has_permission($user_role, $page_url) {
    global $conn;

    $stmt = $conn->prepare("SELECT p.id FROM permissions p
                             JOIN role_permissions rp ON p.id = rp.permission_id
                             JOIN roles r ON r.id = rp.role_id
                             WHERE r.role_name = ? AND p.page_url = ?");
    $stmt->execute([$user_role, $page_url]);
    return $stmt->fetchColumn() !== false;
}

// Determine the current page URL
$current_page = basename($_SERVER['PHP_SELF']);

// Debugging output
if (isset($_SESSION['role'])) {
    echo "Current Role: " . $_SESSION['role'] . "<br>";
    echo "Current Page: " . $current_page . "<br>";
}

// Check if user has permission to access the current page
if (!has_permission($_SESSION['role'], $current_page)) {
    header("Location: forbidden.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Inventory</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_product.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="forecast.php">Product Forecast</a> <!-- New Forecast Page -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Inventory Management</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="add_inward.php">Inward Stock</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_outward.php">Outward Stock</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inventory_log.php">Inventory Log</a>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
