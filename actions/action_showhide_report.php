<?php

session_start(); // Inicia a sessão para manipular variáveis de sessão

$appointment_id = $_POST['appointment_id'];

// Verifica se a variável de sessão 'selected_appointments' já existe
if (!isset($_SESSION['selected_appointments'])) {
    $_SESSION['selected_appointments'] = []; // Se não existir, cria um array vazio
}

// Verifica se o ID da consulta já está no array de seleções
if (in_array($appointment_id, $_SESSION['selected_appointments'])) {
    // Se o ID já estiver na lista, remove-o
    $key = array_search($appointment_id, $_SESSION['selected_appointments']);
    unset($_SESSION['selected_appointments'][$key]);
} else {
    // Se o ID não estiver na lista, adiciona-o
    $_SESSION['selected_appointments'][] = $appointment_id;
}

header('Location: ../profile.php#appointments-table'); // Redireciona para o final da página
exit(); // Evita que mais código seja executado após o redirecionamento


?>