function nblike(imgid) {
var xhrnb = new XMLHttpRequest();
xhrnb.open('POST','./nblike.php',true);
xhrnb.onreadystatechange = function(){
    if(xhrnb.readyState == 4 && xhrnb.status == 200){
        leselect = xhrnb.responseText;
        document.getElementById('likedisp'+imgid).innerHTML = leselect;
    }
}
xhrnb.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
xhrnb.send("idimg="+imgid); 
}

function like_send(image){
if (image.alt  == 2){
    image.alt  = 1;
image.src = "../ressources/logo_liked.png"
var imgid = image.name;
var xhr = new XMLHttpRequest();
xhr.open('POST','./like.php',true);
xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
xhr.send("idimg="+imgid);
nblike(image.name);
}
else{
    image.alt  = 2;
    image.src = "../ressources/logo_like.png";
    var imgid = image.name;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','./unlike.php',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+imgid);
    nblike(image.name);        
}
}

