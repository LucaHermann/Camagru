function prepare_envoi_comment(){

    var canvas = document.getElementById("cvs");
    var datas = canvas.toDataURL('image/jpeg');

    var ajax = new XMLHttpRequest();

    ajax.open('POST', './take_pic.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('photo=' + datas);
    console.log("ok");
   }