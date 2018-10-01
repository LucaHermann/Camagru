(function () {

    var streaming = false,
        video = document.querySelector('#video'),
        cover = document.querySelector('#cover'),
        canvas = document.querySelector('#canvas'),
        startbutton = document.querySelector('#startbutton'),
        width = 614,
        height = 614;

    navigator.getMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);
    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function (stream) {
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function (err) {
            console.log("An error occured! " + err);
        }
    );
    video.addEventListener('canplay', function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            console.log(video.videoHeight + " / (" + video.videoWidth + " / " + width + ")");
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        photo = document.querySelector('#photo');
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/jpeg');
        data = data.replace("data:image/png base64;", "");

        // création d'un formulaire pour l'envois en POST
        var formul = document.createElement('form');
        formul.setAttribute('method', 'POST');
        formul.setAttribute('action', "take_pic.php");

        // création du input pour l’envoie de la string
        var champCache = document.createElement('input');
        champCache.setAttribute('type', 'hidden');
        champCache.setAttribute('name', 'image');
        champCache.setAttribute('value', data);
        formul.appendChild(champCache);

        // envois du formulaire
        document.body.appendChild(formul);
        formul.submit();
        console.log(photo);
        photo.setAttribute('value', data);
    }
    startbutton.addEventListener('click', function (ev) {
        takepicture();
        ev.preventDefault();
    }, false);
})();

// function prepare_envoi(){

//     var canvas = document.getElementById('canvas');
   
//     canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
// }

// function envoi(blob){
 
//     console.log(blob.type)s
   
//     var formImage = new FormData();
//     formImage.append('image_a', blob, 'image_a.jpg');
   
//     var ajax = new XMLHttpRequest();
     
//     ajax.open("POST","take_pic.php",true);
   
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//     ajax.onreadystatechange=function(){
   
//      if (ajax.readyState == 4 && ajax.status==200){
   
//       document.getElementById("jaxa").innerHTML+=(ajax.responseText);
//      }
//     }
   
//     ajax.onerror=function(){
   
//      alert("la requette a échoué")
//     }
   
//     ajax.send(formImage);
//     console.log("ok")
// }

function readURL(input, tochange) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            tochange.attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}