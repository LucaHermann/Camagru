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
  alert("Vous devez etre connecté pour liker une photo!");
}