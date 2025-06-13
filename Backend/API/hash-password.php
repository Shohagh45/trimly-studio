<?php
$password = 'password123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Password Hash:\n" . $hash . "\n";
