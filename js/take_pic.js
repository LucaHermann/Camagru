function ouvrir_camera() {

    navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 400 } }).then(function(mediaStream) {

     var video = document.getElementById('sourcevid');
     video.srcObject = mediaStream;

     var tracks = mediaStream.getTracks();

     document.getElementById("message").innerHTML="message: "+tracks[0].label+" connecté"

     console.log(tracks[0].label)
     console.log(mediaStream)

     video.onloadedmetadata = function(e) {
      video.play();
     };
      
    }).catch(function(err) { console.log(err.name + ": " + err.message);

    document.getElementById("message").innerHTML="message: connection refusé"});
   }

   function photo(){

    var vivi = document.getElementById('sourcevid');
    //var canvas1 = document.createElement('canvas');
    var canvas1 = document.getElementById('cvs')
    var ctx =canvas1.getContext('2d');
    canvas1.height=vivi.videoHeight
    canvas1.width=vivi.videoWidth
    console.log(vivi.videoWidth)
    ctx.drawImage(vivi, 0,0, vivi.videoWidth, vivi.videoHeight);

    //var base64=canvas1.toDataURL("image/png"); //l'image au format base 64
    //document.getElementById('tar').value='';
    //document.getElementById('tar').value=base64;
   }

   function sauver(){

    if(navigator.msSaveOrOpenBlob){

     var blobObject=document.getElementById("cvs").msToBlob()

     window.navigator.msSaveOrOpenBlob(blobObject, "image.png");
    }

    else{

     var canvas = document.getElementById("cvs");
     var elem = document.createElement('a');
     elem.href = canvas.toDataURL("image/jpeg");
     elem.download = "nom.jpeg";
     var evt = new MouseEvent("click", { bubbles: true,cancelable: true,view: window,});
     elem.dispatchEvent(evt);
    }
   }

   function prepare_envoi(){

    var canvas = document.getElementById("cvs");
    var datas = canvas.toDataURL('image/jpeg');

    var ajax = new XMLHttpRequest();

    ajax.open('POST', './take_pic.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('photo=' + datas);
    console.log("ok");
   }
   
   function fermer(){

    var video = document.getElementById('sourcevid');
    var mediaStream=video.srcObject;
    console.log(mediaStream)
    var tracks = mediaStream.getTracks();
    console.log(tracks[0])
    tracks.forEach(function(track) {
     track.stop();
     document.getElementById("message").innerHTML="message: "+tracks[0].label+" déconnecté"
    });

    video.srcObject = null;
   }