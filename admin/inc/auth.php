<?php
// admin/inc/auth.php - Simple auth for local dev. Change before production.
session_start();

// Local dev credentials (change immediately)
const ADMIN_USER = 'admin';
const ADMIN_PASS = 'admin123'; // CHANGE THIS

function admin_is_logged(){
    return !empty($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}
function require_admin(){
    if (!admin_is_logged()) {
        header('Location: login.php');
        exit;
    }
}
