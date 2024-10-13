<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Verificar si esta "logueado", si no redirigir al login

if (!function_exists('requireAuth')) {
    function requireAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            header('Location: /');
            exit;
        }
    }
}

//Verificar si el usuario tiene un rol específico
function requireRole($role = 'lector'):void{
    if($_SESSION['role'] !== $role){
        header('Location: /noticias');
    }
}
