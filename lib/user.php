<?php

function verifyUserLoginPassword(PDO $pdo, string $email, string $password): ?array {
    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return null;
    }

    if (password_verify($password, $user['password'])) {
        return $user;
    }

    return null;
}
