<?php
// JSON data
$data = [
    "Folio" => 309872,
    "Guest" => "Jorge Sanchez Hernandez",
    "Hotel" => "ATELIER",
    "Ticket" => 123456,
    "email" => "geosh2000@gmail.com",
    "pago" => "cortesia"
];

// Encode data to JSON
$jsonData = json_encode($data);

// Generate SHA-256 hash
$hash = hash('sha256', $jsonData);

$encodedData = base64_encode($jsonData);

// Output JSON and hash
echo "JSON data: " . $jsonData . "<br>";
echo "SHA-256 hash: " . $hash;
echo "encoded Data: " . $encodedData;
?>