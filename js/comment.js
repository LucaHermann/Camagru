function comment_send(form){
    var image =  form.elements[1].value;
    var donnee = form.elements[0].value;
    document.getElementById('comment_index'+image).value = "";
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){    
            comment(image);
        }
    }
    xhr.open('POST','./comment.php',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+image+'&'+"text="+donnee);
    console.log("ok");
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

// function comment_send(){
//     var image = img_id;
//     var donnee = document.getElementById('comment').value;
//     document.getElementById('comment').value = "";
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function(){
//         if(xhr.readyState == 4 && xhr.status == 200){    
//             comment(image);
//         }
//     }
//     xhr.open('POST','comment.php',true);
//     xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//     xhr.send("idimg="+image.id+"&text="+donnee);
//     console.log("ok");
// }