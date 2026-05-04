<?php
$conn = new mysqli("localhost", "root", "", "freelancehub");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
