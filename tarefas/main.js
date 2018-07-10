$(document).ready(function() {
  $.ajax({
    url: "../seguranca.php",
    success: function(x){
      if(x==false){
        window.location = '../error.html';
      }
    }
  })

  $.ajax({
    url: '../templates/menu.php',
    success: function(menu) {
      $('#menuID').html(menu);
    }
  });

  $('.dropdown-trigger').dropdown();
  $('.sidenav').sidenav();
  $('.collapsible').collapsible();

})
