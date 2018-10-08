function comment(){

    var canvas = document.getElementById("comment");
    var datas = canvas;

    var ajax = new XMLHttpRequest();

    ajax.open('POST', './take_pic.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send('photo=' + datas);
    console.log("ok");
   }