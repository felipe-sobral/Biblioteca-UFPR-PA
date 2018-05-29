function atualizarUltimosLivros() {
  $.ajax({
    url: "codigos_registrados.php",
    success: function(result) {
      if (result != 0) {
        $("#tresCodigos").html(result);
      }
    }
  })
}

function imprimirTabela(conteudo) {
  var imprimir = document.getElementById(conteudo).innerHTML;
  tela_impressao = window.open('about:blank');
  tela_impressao.document.write(imprimir);
  tela_impressao.window.print();
  tela_impressao.window.close();
}

function atualizarLivrosHoje() {
  $.ajax({
    url: "historico_registros.php",
    type: "post",
    data: "fn=" + 1,
    success: function(result) {
      $("#livrosRegistradosHoje").html(result);
    }
  })
}

$(document).ready(function() {
  atualizarUltimosLivros();
  atualizarLivrosHoje();

  $.ajax({
    url: '../templates/menu.php',
    success: function(menu) {
      $('#menuID').html(menu);
    }
  });

  $.ajax({
    url: "../verificar.php",
    type: "post",
    data: "executarFuncao=" + 6 + "&nivel=" + 3,
    success: function(result) {
      if (result == true) {
        document.getElementById("carregando").style.display = "none";
        document.getElementById("passou").style.display = "block";
      } else {
        window.location = '../index.html';
      }
    }
  })

  $('#inserirCodigo').submit(function() {
    var codigoBarras = $('#codigo_consulta').val();
    $.ajax({
      url: "inserir.php",
      type: "post",
      data: "codigoBarras=" + codigoBarras,
      success: function(result) {
        if (result != 1) {
          M.toast({
            html: "<i class='material-icons' style='color: #ff5151'>clear</i>"
          });
          $('#codigo_consulta').focus();
          document.getElementById('codigo_consulta').value = "";
        } else {
          M.toast({
            html: "<i class='material-icons' style='color: #85ff51'>check</i>"
          });
          $('#codigo_consulta').focus();
          document.getElementById('codigo_consulta').value = "";
          atualizarUltimosLivros();
          atualizarLivrosHoje();
        }
      }
    })
    return false;
  })

  $('#adicionarConsultaForm').submit(function() {
    var ano = $('#i_ano').val();
    var mes = $('#i_mes').val();
    var dia = $('#i_dia').val();
    var codigos = $('#i_codigos').val();

    $.ajax({
      url: "inserirConsulta.php",
      type: "post",
      data: "ano=" + ano + "&mes=" + mes + "&dia=" + dia + "&codigos=" + codigos,
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

  $('#HistoricoCL_form').submit(function() {
    $.ajax({
      url: 'historico_registros.php',
      type: 'post',
      data: 'fn=' + 2 + '&ano=' + $('#HistoricoCL_ano').val() + '&mes=' + $('#HistoricoCL_mes').val(),
      success: function(result) {
        $('#HistoricoCL_tabela').html(result);
        document.getElementById("aposProcurar").style.display = "block";
      }
    })

    return false;
  })

  $('#alterarForm').submit(function() {
    var anoAlterar = $('#anoAlterar').val();
    var mesAlterar = $('#mesAlterar').val();
    var diaAlterar = $('#diaAlterar').val();

    $.ajax({
      url: "alterar.php",
      type: "post",
      data: "ano=" + anoAlterar + "&mes=" + mesAlterar + "&dia=" + diaAlterar + "&pegarCodigos=" + 1,
      success: function(result) {
        if (result == 0) {
          M.toast({
            html: "<i class='material-icons' style='color: #ff5151'>clear</i>"
          });
        } else {
          M.toast({
            html: "<i class='material-icons' style='color: #85ff51'>check</i>"
          });
          $('#alterarAQUI').html(result);
          $('#aposProcurarDataAlterar').show();
        }
      }
    })

    return false;
  })

  $('#modificarForm').submit(function() {
    var alterarCodigos = $('#codigosAlterar').val();

    $.ajax({
      url: "alterar.php",
      type: "post",
      data: "alterarCodigos=" + alterarCodigos + "&iden=" + iden,
      success: function(result) {
        if (result == 1) {
          M.toast({
            html: "<i class='material-icons' style='color: #85ff51'>check</i>"
          });
        }
      }
    })

    return false;
  })

  $('select').formSelect();
  $('.dropdown-trigger').dropdown();
  $('.sidenav').sidenav();
  $('.tabs').tabs();
  //$('#i_codigos').val('New Text');
  //M.textareaAutoResize($('#i_codigos'));
})