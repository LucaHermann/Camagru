function comment_send(form){
  alert("Vous devez etre connecté pour commenter une photo!");
}

function comment(image){
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(){
  if(xhr.readyState == 4 && xhr.status == 200){
    leselect = xhr.responseText;
    document.getElementById('comment'+image).innerHTML = leselect;
  }
}
xhr.open("POST","aff_index_comment.php",true);
xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
xhr.send("idimg="+image);
}