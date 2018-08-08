function imprimirTabela(conteudo) {
  var imprimir = document.getElementById(conteudo).innerHTML;
  tela_impressao = window.open('about:blank');
  tela_impressao.document.write(imprimir);
  tela_impressao.window.print();
  tela_impressao.window.close();
}

function atualizaContador() {
  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 1 +
      "&numero=" + 0,
    success: function(result) {
      if (result != null) {
        $("#contadorIMP").html("<h1 id='contadorIMP'>" + result.toString() + "</h1>");
      }

    }
  })
}

function adicionar() {

  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 0 +
      "&numero=" + $('#valorIMP').val(),
    success: function(result) {

      $("#contadorIMP").html("<h1 id='contadorIMP'>" + result.toString() + "</h1>");

    }
  })

}

function remover() {
  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 2 + "&numero=" + $('#valorIMP').val(),
    success: function(result) {

      $("#contadorIMP").html("<h1 id='contadorIMP'>" + result.toString() + "</h1>");

    }
  })
}

$('#cadastrarDiaForm').submit(function() {
  var data = $('#dataIMP').val();
  var ano = $('#anoIMP').val();
  var mes = $('#mesIMP').val();
  var total = $('#valorIMP').val();

  $.ajax({
    url: "registrar_dia.php",
    type: "post",
    data: "data=" + data +
      "&total=" + total+
      "&ano=" + ano+
      "&mes=" + mes,
    success: function(result) {
      if (result == 1) {
        M.toast({
          html: "<i class='material-icons' style='color: #85ff51'>add</i>"
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

$('#historicoImpForm').submit(function() {
  var ano = $('#anoIMP').val();
  var mes = $('#mesIMP').val();

  $.ajax({
    url: "buscar_historico.php",
    type: "post",
    data: "ano=" + ano +
      "&mes=" + mes,
    success: function(result) {
      if (result == 0) {
        M.toast({
          html: "<i class='material-icons' style='color: #ff5151'>clear</i>"
        });
      } else {
        $("#historicoLista").html(result);
        document.getElementById("aposProcurar").style.display = "block";
        M.toast({
          html: "<i class='material-icons' style='color: #85ff51'>check</i>"
        });
      }
    }
  })

  return false;

})

$('#alterarDiaForm').submit(function() {
  var data = $('#data_alterarIMP').val();
  $.ajax({
    url: "alterarDia.php",
    type: "post",
    data: "data=" + data +
      "&verificar=" + 0,
    success: function(result) {
      if (result == 0) {
        M.toast({
          html: "<i class='material-icons' style='color: #ff5151'>clear</i>"
        });
        document.getElementById("aposProcurarData").style.display = "none";
      } else {
        document.getElementById("aposProcurarData").style.display = "block";
        $('#alterarDiaX').html(result);
      }
    }
  })

  return false;
})

$('#alterarDiaFormX').submit(function() {
  var data = $('#a_dataIMP').val();
  var total = $('#a_valorIMP').val();
  var alterarDados = $('#a_confirmIMP').val();

  $.ajax({
    url: "alterarDia.php",
    type: "post",
    data: "data=" + data +
      "&total=" + total +
      "&alterarDados=" + alterarDados +
      "&verificar=" + 1,
    success: function(result) {
      if (result != 0) {
        M.toast({
          html: "<i class='material-icons' style='color: #85ff51'>check</i>"
        });
      } else {
        M.toast({
          html: "<i class='material-icons' style='color: #85ff51'>check</i>"
        });
      }
    }
  })

  return false;

})

$(document).ready(function() {
  $.ajax({
    url: '../templates/menu.php',
    success: function(menu) {
      $('#menuID').html(menu);
    }

  });

  atualizaContador();

  $('select').formSelect();
  $('.dropdown-trigger').dropdown();
  $('.sidenav').sidenav();
  $('.tabs').tabs();
  M.updateTextFields();
});
