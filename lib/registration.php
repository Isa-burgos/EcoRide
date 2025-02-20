<?php

function registration(PDO $pdo, string $gender, string $name, string $firstname, string $birthDate, string $email, string $password, int $possess):bool {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = $pdo->prepare('INSERT INTO user
                            (gender, name, firstname, birth_date, email, password, possess)
                            VALUES
                            (:gender, :name, :firstname, :birth_date, :email, :password, :possess)');
    $query->bindValue(':gender', $gender, PDO::PARAM_STR);
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindValue(':birth_date', $birthDate, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    $query->bindValue(':possess', $possess, PDO::PARAM_INT);

    return $query->execute();
}