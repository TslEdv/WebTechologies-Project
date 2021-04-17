function removeBooking(bookingid){
    if (confirm('Are you sure to remove the booking?')){
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "mybooking.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send("deletion=" + bookingid);
        window.location.reload()
    }
 }