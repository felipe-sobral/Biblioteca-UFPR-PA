$('#alterarSenha_form').submit(function() {
  var alterarSenha_nova = $('#alterarSenha_nova').val();
  var alterarSenha_antiga = $('#alterarSenha_antiga').val();
  var alterarSenha_conferir = $('#alterarSenha_conferir').val();

  $.ajax({
    url: "alterarsenha.php",
    type: "post",
    data: "alterarSenha_nova=" + alterarSenha_nova + "&alterarSenha_antiga=" + alterarSenha_antiga + "&alterarSenha_conferir=" + alterarSenha_conferir,
    success: function(result) {
      if (result == 1) {
        M.toast({
          html: "<i class='material-icons' style='color: #85ff51'>check</i>"
        });
      } else {
        M.toast({
          html: "<i class='material-icons' style='color: #ff5151'>clear</i>"
        });
      }
    }
  })

  return false;
})

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

  $('select').formSelect();
  $('.dropdown-trigger').dropdown();
  $('.sidenav').sidenav();
  $('.collapsible').collapsible();
})
