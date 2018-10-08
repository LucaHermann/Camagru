function on() {
    document.getElementById("overlay").style.display = "block";
    prev = document.querySelector('#img_over');
    var image = document.getElementById("affpic");
    var imgElement = document.createElement('img');
        imgElement.style.width = '100%';
        imgElement.style.height = '100%';
        imgElement.src = image.src;
        prev.appendChild(imgElement);
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
}