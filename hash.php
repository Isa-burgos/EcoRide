<?php
$newPassword = "Azerty@11"; // Remplace par le mot de passe que tu veux tester
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
echo "Nouveau hash : " . $hashedPassword;
