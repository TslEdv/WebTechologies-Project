<?php
require_once("classes.php");
$booking = new Booking(uniqid(), $_POST['user'],  DateTime::createFromFormat('Y-m-dTH%3i', $_POST['start-date']),  DateTime::createFromFormat('Y-m-dTH%3i', $_POST['end-date']), $_POST['roomid']);
$handle = fopen("data/bookings.csv", "w");
fputcsv($handle, get_object_vars($booking));
fclose($handle);
echo "Booking successful! Your booking number is " . $booking->getId() . "\n";
?>