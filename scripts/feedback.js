function thankSubmission(){
    document.getElementById('feedback-form').style.display = "none";
    document.getElementById('thank').style.display = "block";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "contact.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send("feedback=" + document.getElementById('feedback').value);
}