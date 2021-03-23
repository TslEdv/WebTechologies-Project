<?php
require_once("classes.php");
$booking = new Booking;
$booking->id = uniqid();
$booking->startDate = DateTime::createFromFormat('Y-m-dTH%3i', $_POST['end-date']);
$booking->endDate = DateTime::createFromFormat('Y-m-dTH%3i', $_POST['end-date']);
$booking->$roomId = $_POST['room-id'];
$booking->user = $_POST['user'];
$handle = fopen("data/bookings.csv", "w");
fputcsv($handle, get_object_vars($booking));
fclose($handle);
echo "Booking successful! Your booking number is " . $booking->id . "\n";
?>