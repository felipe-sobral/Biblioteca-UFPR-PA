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
        $("#contador").html("<h1 id='contador'>" + result.toString() + "</h1>");
      }

    }
  })
}

function atualizaUlt() {
  agora = new Date;

  var horas = agora.getHours();
  var minutos = agora.getMinutes();
  var segundos = agora.getSeconds();

  if (agora.getHours() < 10) {
    horas = "0" + agora.getHours();
  }
  if (agora.getMinutes() < 10) {
    minutos = "0" + agora.getMinutes();
  }
  if (agora.getSeconds() < 10) {
    segundos = "0" + agora.getSeconds();
  }

  $("#ultAtualizacao").html(horas + ":" + minutos + ":" + segundos);

}

function adicionar() {

  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 0 +
      "&numero=" + 1,
    success: function(result) {

      $("#contador").html("<h1 id='contador'>" + result.toString() + "</h1>");
      atualizaUlt();

    }
  })

}

function remover() {
  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 2 + "&numero=" + 1,
    success: function(result) {

      $("#contador").html("<h1 id='contador'>" + result.toString() + "</h1>");
      atualizaUlt();

    }
  })
}

$('#cadastrarDiaForm').submit(function() {
  var data = $('#data').val();
  var manha = $('#manha').val();
  var tarde = $('#tarde').val();
  var noite = $('#noite').val();
  var mes = $('#mes').val();
  var ano = $('#ano').val();

  $.ajax({
    url: "registrar_dia.php",
    type: "post",
    data: "data=" + data +
      "&manha=" + manha +
      "&tarde=" + tarde +
      "&noite=" + noite +
      "&mes=" + mes +
      "&ano=" + ano,
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

$('#historicoUsuarioForm').submit(function() {
  var anoHistorico = $('#anoHistorico').val();
  var mesHistorico = $('#mesHistorico').val();

  $.ajax({
    url: "buscar_historico.php",
    type: "post",
    data: "anoHistorico=" + anoHistorico +
      "&mesHistorico=" + mesHistorico,
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
  var data = $('#data_alterar').val();
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
  var data = $('#data_alterar').val();
  var manha = $('#manha_alterar').val();
  var tarde = $('#tarde_alterar').val();
  var noite = $('#noite_alterar').val();
  var alterarDados = $('#alterarORexcluir').val();

  $.ajax({
    url: "alterarDia.php",
    type: "post",
    data: "data=" + data +
      "&manha=" + manha +
      "&tarde=" + tarde +
      "&noite=" + noite +
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

$('#cadastrarDiaForm').submit(function(){
  var data=$('#data').val();
  var manha=$('#manha').val();
  var tarde=$('#tarde').val();
  var noite=$('#noite').val();
  var mes=$('#mes').val();
  var ano=$('#ano').val();

  $.ajax({
    url: "registrar_dia.php",
    type: "post",
    data: "data="+data+
                    "&manha="+manha+
                    "&tarde="+tarde+
                    "&noite="+noite+
                    "&mes="+mes+
                    "&ano="+ano,
    success: function(result){
      if(result==1){
        $('#erroDia').hide();
        $('#certoDia').show();
      } else {
        $('#erroDia').show();
        $('#certoDia').hide();
      }
    }

  })

  return false;
})

$(document).ready(function() {
  $.ajax({
    url: "../seguranca.php",
    type: "post",
    data: "ajaxS="+1,
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

  atualizaContador();
  atualizaUlt();

  $.ajax({
    url: "funcoes.php",
    type: "post",
    data: "funcao=" + 3 + "&numero=" + 0,
    success: function(result) {

      if (result != null) {
        $("#turno").html(result);
      }

    }
  })

  $('select').formSelect();
  $('.dropdown-trigger').dropdown();
  $('.sidenav').sidenav();
  $('.tabs').tabs();
  M.updateTextFields();
});
