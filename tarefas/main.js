/*
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
*/

function atualizar_tarefas(){
  $.ajax({
    url: "em_andamento.php",
    success: function(tarefas){
      if(tarefas != 0){
        $("#imprimir_tarefa").html(tarefas);
      }
    }
  });
}

function finalizar_tarefa(id, funcao){
  $.ajax({
    url: "finalizar_tarefa.php",
    type: "POST",
    data: "funcao="+funcao+"&id="+id,
    success: function(result){
      if(result != 0){
        M.toast({html: "<i class='material-icons' style='color: #85ff51'>check</i>"});
        atualizar_tarefas();
      }
    }
  });
}

$('#registrarTarefa').submit(function(){
  var t_usuario = $("#t_usuario").val();
  var t_titulo = $("#t_titulo").val();
  var t_descricao = $("#t_descricao").val();

  $.ajax({
    url: "criar_tarefa.php",
    type: "POST",
    data: "t_usuario="+t_usuario+"&t_titulo="+t_titulo+"&t_descricao="+t_descricao,
    success: function(result){
      if(result != 1){
        M.toast({html: "<i class='material-icons' style='color: #ff5151'>clear</i>"});
      } else {
        M.toast({html: "<i class='material-icons' style='color: #85ff51'>check</i>"});
        atualizar_tarefas();
      }
    }
  });

  return false;
});

$(document).ready(function() {
  $.ajax({
    url: "../seguranca.php",
    success: function(x){
      if(x==false){
        window.location = '../error.html';
      }
    }
  });

  atualizar_tarefas();

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
