// JS DO MENU

$.ajax({
  url: 'templates/menu.php',
  success: function(menu) {
    $('#menuID').html(menu);
  }

});