var startdates = document.getElementsByClassName('startdate');
var enddates = document.getElementsByClassName('enddate');

for(let x = 0; x < startdates.length; x++){
    var startdate = new Date(startdates[x].innerHTML);
    startdates[x].innerHTML = startdate.toLocaleString();
}
for (let x = 0; x < enddates.length; x++){
    var enddate = new Date(enddates[x].innerHTML);
    enddates[x].innerHTML = enddate.toLocaleString();
}