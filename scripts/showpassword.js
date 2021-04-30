function mouseoverPass(obj) {
    var obj = document.getElementById('pwd'); // finds the element by id 
    obj.type = "text"; // makes type text so on mouseover it can be seen
}
function mouseoutPass(obj) {
    var obj = document.getElementById('pwd'); 
    obj.type = "password"; //when there is no mouseover text is password type again
}