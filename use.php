<?php

$key = "ad20185b89a55d60";
$iv  = "e2e03f9289cdbc0e";

$encryptedData = "PASTE_YOUR_FULL_BODY_STRING";

$decrypted = openssl_decrypt(
    base64_decode($encryptedData),
    "AES-128-CBC",
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

echo $decrypted;

?>