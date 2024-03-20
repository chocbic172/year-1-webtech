<?php

namespace Utils\Validate;

function verifyName(string $nameToVerify) {
    $validationErrors = "";

    if ($nameToVerify == "") {
        $validationErrors .= "<span>Please enter your full name!</span><br>";
    }

    return $validationErrors;
}

function verifyEmail(string $emailToVerify, $db) {
    $validationErrors = "";

    if (!filter_var($emailToVerify, FILTER_VALIDATE_EMAIL)) {
        $validationErrors .= "<span>Please enter a valid email!</span>";
    }

    if ($db->emailIsRegistered($emailToVerify)) {
        $validationErrors .= "<span>There is already an account with this email. Please choose another.</span>";
    }

    return $validationErrors;
}

function verifyPassword(string $password) {
    $validationErrors = "";

    if (strlen($password) < 8) {
        $validationErrors .= "<span>Please choose another password with at least 8 characters</span><br/>";
    }
    
    if (!preg_match('~[0-9]+~', $password)) {
        $validationErrors .= "<span>Please choose another password with  at least 1 number</span><br/>";
    }
    
    if (!(preg_match('~[A-Z]+~', $password) && preg_match('~[a-z]+~', $password))) {
        $validationErrors .= "<span>Please choose another password with both uppercase and lowercase letters</span><br/>";
    }

    return $validationErrors;
}

function verifyRepeatPassword(string $password, string $repeatPassword) {
    $validationErrors = "";

    if ($password != $repeatPassword) {
        $validationErrors .= "<span>Passwords do not match! Please try again.</span>";
    }

    return $validationErrors;
}
