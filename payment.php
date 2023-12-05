<?php
$sender = 'address';
$privateKey = '-----BEGIN EC PRIVATE KEY-----
MHQCAQEEIPQUkZgiAQmTFZadXXDqFgwWPKhbzt8NQqg3Zg27QH0coAcGBSuBBAAK
oUQDQgAEDDsUwv89FMzsP0C64kfWeF6iQis4rLP+OzuoQBfmOc5Xh/zl0jmb+dSF
Eiwh0cwGQtTeIkiRHho2pUqppheAvw==
-----END EC PRIVATE KEY-----';
$recipient = 'recipient_address';
$amount = 10;

// Create a JSON payload with transaction data, including private key
$transactionData = json_encode([
    'sender' => $sender,
    'recipient' => $recipient,
    'amount' => $amount,
    'privateKey' => $privateKey  // Include private key in the payload
]);

// Initialize a cURL session for adding a transaction
$ch = curl_init('http://localhost:3000/addTransaction');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $transactionData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

?>