$(document).ready(function () {
  $('#summernote').summernote({
    height: 200
  });

  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);

  $('#load-screen').delay(0).fadeOut(0, function () {
    $(this).remove();
  });
});

function loadUsersOnline(){
  $.get("functions.php?onlineusers=result", function(data){
    $(".usersonline").text(data);
  });
}
setInterval(function(){
  loadUsersOnline();
},500);

