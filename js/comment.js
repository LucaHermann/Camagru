function comment_send(form){
    var image =  form.elements[1].value;
    var donnee = form.elements[0].value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','./comment.php',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+image+'&'+"text="+donnee);
    console.log("ok");
}