var img_id;

function on(form) {
  img_id = form.elements[0];
  var filtre = form.elements[1];
  document.getElementById("overlay").style.display = "block";
  prev = document.querySelector('#img_over');
  document.getElementById("fifioverlay").src = form.elements[1].id;
  document.getElementById("fifioverlay").style = form.elements[1].name;
  var imgElement = document.createElement('img');
      imgElement.style.width = '100%';
      imgElement.src = form.elements[0].name;
      imgElement.id = "childpic";
      prev.appendChild(imgElement);
      isliked(form.elements[0].id);
      nblike(form.elements[0].id);
      comment(form.elements[0]);
}

function off() {
  document.getElementById("overlay").style.display = "none";
  var prev = document.querySelector('#img_over');
  var imgElement = document.querySelector('#childpic');
  prev.removeChild(imgElement);
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
  document.getElementById('comment').value = "";
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
      if(xhr.readyState == 4 && xhr.status == 200){    
          comment(image);
      }
  }
  xhr.open('POST','comment.php',true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.send("idimg="+image.id+"&text="+donnee);
}

function nblike(imgid) {
  var xhrnb = new XMLHttpRequest();
  xhrnb.open('POST','./nblike.php',true);
  xhrnb.onreadystatechange = function(){
      if(xhrnb.readyState == 4 && xhrnb.status == 200){
          leselect = xhrnb.responseText;
          document.getElementById('likedisp').innerHTML = leselect;
      }
  }
  xhrnb.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhrnb.send("idimg="+imgid); 
}

function like_send(image){
  var img = img_id;
  if (image.alt  == 2){
      image.alt  = 1;
  image.src = "../ressources/logo_liked.png"
  var xhr = new XMLHttpRequest();
  xhr.open('POST','./like.php',true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.send("idimg="+img.id);
  nblike(img.id);
  }
  else{
      image.alt  = 2;
      image.src = "../ressources/logo_like.png";
      var xhr = new XMLHttpRequest();
      xhr.open('POST','./unlike.php',true);
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      xhr.send("idimg="+img.id);
      nblike(img.id);
  }
}

function isliked(imgid) {
  var xhrnb = new XMLHttpRequest();
  xhrnb.open('POST','./isliked.php',true);
  xhrnb.onreadystatechange = function(){
      if(xhrnb.readyState == 4 && xhrnb.status == 200){
          leselect = xhrnb.responseText;
          document.getElementById('like_button').innerHTML = leselect;
      }
  }
  xhrnb.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhrnb.send("idimg="+imgid); 
}