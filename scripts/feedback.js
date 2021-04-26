function thankSubmission(){
    document.getElementById('feedback-form').style.display = "none";
    var thanks =  document.getElementById('thank');
    thanks.style.display = "block";
    var xhr = new XMLHttpRequest(); //send data as form
    xhr.open("POST", "contact.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send("feedback=" + document.getElementById('feedback').value);
    var tag = document.createElement("h2"); //create an h2 element to thank the user
    var text = document.createTextNode("Thank you for your feedback!");
    tag.appendChild(text);
    thanks.appendChild(tag);
}