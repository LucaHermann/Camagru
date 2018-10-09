function comment_send(){
    var image =  document.getElementById('idimg').value;
    var donnee = document.getElementById('comment').value;
    alert(image);
    alert(donnee);
    var xhr = new XMLHttpRequest();
    xhr.open('POST','comment.php',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+image+"&text="+donnee);
    console.log("ok");
    //comment();
}