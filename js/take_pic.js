var btn = 0;

function ouvrir_camera() {
  document.getElementById("lazone").style.display = "flex";
  var imgElementss = document.getElementById('uploadpic');
          if (imgElementss){
          prev.removeChild(imgElementss);
          }
  navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 600 } }).then(function(mediaStream) {

    var video = document.getElementById('sourcevid');
    document.getElementById('cvs').style.display = "none";
    video.style.display = "block";
    video.srcObject = mediaStream;

    var tracks = mediaStream.getTracks();

    //document.getElementById("message").innerHTML="message: "+tracks[0].label+" connecté"
    video.onloadedmetadata = function(e) {
    video.play();
    };
    
  }).catch(function(err) { console.log(err.name + ": " + err.message);

  document.getElementById("message").innerHTML="message: connection refusé"});
  }

  function photo(){
  document.getElementById("dispbut").style.display = "none";
  document.getElementById("jaxa").style.display = "block";
  var vivi = document.getElementById('sourcevid');
  vivi.style.display = "none";
  //var canvas1 = document.createElement('canvas');
  var canvas1 = document.getElementById('cvs')
  canvas1.style.display = "block";
  var ctx =canvas1.getContext('2d');
  canvas1.height=vivi.videoHeight
  canvas1.width=vivi.videoWidth
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
  var filter = document.getElementById("fifi");
  if (filter.src == "")
    alert("Something goes wrong..");
  else
    alert("Picture saved");
  var canvas = document.getElementById("cvs");
  var datas = canvas.toDataURL('image/jpeg');
  var ajax = new XMLHttpRequest();
  ajax.open('POST', './take_pic.php', true);
  ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  ajax.send('photo=' + datas + '&filter_path=' + filter.src + '&position=' + filter.name);
  }
  

  function env(){
  var filter = document.getElementById("fifi");
  if (filter.src == "")
    alert("Something goes wrong..");
  else
    alert("Picture saved");
  var image = document.getElementById("uploadpic");
  var datas = image.src
  var ajax = new XMLHttpRequest();
  ajax.open('POST', './take_pic.php', true);
  ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  ajax.send('photo=' + datas + '&filter_path=' + filter.src + '&position=' + filter.name + '&upload='+ image.name);
  console.log("ok");
  }

  (function() {

function createThumbnail(file) {

    var reader = new FileReader();

    reader.addEventListener('load', function() {
        
        var imgElementss = document.getElementById('uploadpic');
        if (imgElementss){
        prev.removeChild(imgElementss);
        }
        var imgElement = document.createElement('img');
        imgElement.style.width = '600px';
        imgElement.style.height = '450px';
        imgElement.style.marginTop = "15px";
        imgElement.style.marginBottom = "15px";
        imgElement.src = this.result;
        imgElement.id = 'uploadpic';
        imgElement.name = 'up';
        prev.appendChild(imgElement);
        document.getElementById("lazone").style.display = "flex";
        document.getElementById('sourcevid').style.display = "none";
        document.getElementById('cvs').style.display = "none"
        document.getElementById("jaxa").style.display = "none";
        document.getElementById("dispbut").style.display = "block";
    });
    reader.readAsDataURL(file);

}
var allowedTypes = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'],
    fileInput = document.getElementById('file'),
    prev = document.getElementById('prev');

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
  
  function filtre(image){
      btn = 1;
      document.getElementById("btn").disabled = false;
      document.getElementById("fifi").src = image.src;
      document.getElementById("fifi").className = image.name;
      document.getElementById("fifi").name = image.alt;
  }

  function fermer(){
  document.getElementById("lazone").style.display = "none";
  var video = document.getElementById('sourcevid');
  video.style.display = "none";
  var mediaStream=video.srcObject;
  var tracks = mediaStream.getTracks();
  tracks.forEach(function(track) {
    track.stop();
    //document.getElementById("message").innerHTML="message: "+tracks[0].label+" déconnecté"
  });


video.srcObject = null;
}

function verif(){
  if (btn === 0){
    alert("You have to choose a filter");
  } else {
    photo();  
  }
}