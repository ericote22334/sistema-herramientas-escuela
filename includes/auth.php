<?php
session_start();
require_once __DIR__ . '/db.php';

function usuario_actual(): ?array {
    return $_SESSION['usuario'] ?? null;
}

// Redirige al login si no hay sesión o si el rol no está permitido
function requerir_login(array $roles = ['director', 'encargado']): void {
    $u = usuario_actual();
    if (!$u) { header('Location: login.php'); exit; }
    if (!in_array($u['rol'], $roles, true)) { http_response_code(403); exit('No tenés permiso para ver esta pantalla.'); }
}

function es_director(): bool {
    return (usuario_actual()['rol'] ?? '') === 'director';
}

function token_csrf(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function validar_csrf(?string $token): bool {
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

function e($texto): string {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}
