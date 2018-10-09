var img_id;

function on(image) {
    img_id = image;
    document.getElementById("overlay").style.display = "block";
    prev = document.querySelector('#img_over');
    var imgElement = document.createElement('img');
        imgElement.style.width = '100%';
        imgElement.style.height = '100%';
        imgElement.src = image.src;
        imgElement.id = "childpic";
        prev.appendChild(imgElement);
        comment(image);

}

// document.onclick = function (event)
// {
//   event = event || window.event;
//   var target = event.target || event.srcElement;
  
//   var type;
//   if(target.nodeType == 1)
//     type = 'Tag: ' + target.src;
//   else
//     type = target.src;
//    alert('Vous avez cliqué sur ' + type);
// };

function off() {
    document.getElementById("overlay").style.display = "none";
    var prev = document.querySelector('#img_over');
    var imgElement = document.querySelector('#childpic');
    prev.removeChild(imgElement);
    //window.location.reload();
}

function on_sd() {
    document.getElementById("overlay_sd").style.display = "flex";
}

function off_sd() {
    document.getElementById("overlay_sd").style.display = "none";
}

function env(){
    var image = document.getElementById("uppic");
    var datas = image.src
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './upload_profile_picture.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('photo=' + datas);
    alert("Picture uploaded !");
    console.log("ok");
   }


(function() {

    function createThumbnail(file) {

        var reader = new FileReader();

        reader.addEventListener('load', function() {
            var imgElement = document.createElement('img');
            imgElement.style.maxWidth = '620px';
            imgElement.style.maxHeight = '462px';
            imgElement.src = this.result;
            imgElement.id = 'uppic';
            prev.appendChild(imgElement);
            env();
            window.location.reload();
        });
        reader.readAsDataURL(file);

    }

    var allowedTypes = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'],
        fileInput = document.querySelector('#file'),
        prev = document.querySelector('#prev');

    fileInput.addEventListener('change', function() {

        var files = this.files,
            filesLen = files.length,
            imgType;

        for (var i = 0; i < filesLen; i++) {

            imgType = files[i].name.split('.');
            imgType = imgType[imgType.length - 1];

            if (allowedTypes.indexOf(imgType) != -1) {
                createThumbnail(files[i]);
            }

        }

    });

})();

function comment(image){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            leselect = xhr.responseText;
            document.getElementById('comment_profile').innerHTML = leselect;
        }
    }
    xhr.open("POST","aff_profile_comment.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+image.id);
}

function comment_send(){
    var image = img_id;
    var donnee = document.getElementById('comment').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','comment.php',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("idimg="+image.id+"&text="+donnee);
    console.log("ok");
    on();
}