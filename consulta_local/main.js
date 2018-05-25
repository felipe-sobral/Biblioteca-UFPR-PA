function atualizarUltimosLivros(){
    $.ajax({
        url: "codigos_registrados.php",
        success: function(result){
            if(result != 0){
               $("#tresCodigos").html(result);
            }
        }
    })
}

function atualizarLivrosHoje(){
    $.ajax({
        url: "historico_registros.php",
        type: "post",
        data: "fn="+1,
        success: function(result){
            $("#livrosRegistradosHoje").html(result);
        }
    })
}

$(document).ready(function(){
    atualizarUltimosLivros();
    atualizarLivrosHoje();

    $.ajax({
        url: '../templates/menu.php',
        success: function(menu){
            $('#menuID').html(menu);
        }
    });

    $.ajax({
        url: "../verificar.php",
        type: "post",
        data: "executarFuncao="+6+"&nivel="+3,
        success: function(result){
            if(result == true){
              document.getElementById("carregando").style.display = "none";
              document.getElementById("passou").style.display = "block";
            }else{
              window.location='../index.html';
            }
        }
    })

    $('#inserirCodigo').submit(function(){
    var codigoBarras = $('#codigo_consulta').val();
    $.ajax({
        url: "inserir.php",
        type: "post",
        data: "codigoBarras="+codigoBarras,
        success: function(result){
          if(result != 1){
              M.toast({html: "<i class='material-icons' style='color: #ff5151'>clear</i>"});
              $('#codigo_consulta').focus();
              document.getElementById('codigo_consulta').value = "";
          } else {
              M.toast({html: "<i class='material-icons' style='color: #85ff51'>check</i>"});
              $('#codigo_consulta').focus();
              document.getElementById('codigo_consulta').value = "";
              atualizarUltimosLivros();
              atualizarLivrosHoje();
          }
        }
    })
    return false;
    })
})
