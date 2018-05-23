function atualizaContador(){
  $.ajax({
        url: "funcoes.php",
        type: "post",
        data: "funcao="+1+
        "&numero="+0,
        success: function(result){
            if(result != null){
                $("#contador").html("<h1 id='contador'>"+result.toString()+"</h1>");
            }

        }
    })
}

function atualizaUlt(){
    $.ajax({
        url: "funcoes.php",
        type: "post",
        data: "funcao="+4+
        "&numero="+0,
        success: function(result){

            if(result != null){
                $("#ultAtualizacao").html(result);
            }
        }
    })
}

function adicionar(){

    $.ajax({
        url: "funcoes.php",
        type: "post",
        data: "funcao="+0+
        "&numero="+1,
        success: function(result){

            atualizaContador();
            atualizaUlt();

        }
    })

}

function remover(){
    $.ajax({
        url: "funcoes.php",
        type: "post",
        data: "funcao="+2+"&numero="+1,
        success: function(result){

            atualizaContador();
            atualizaUlt();

        }
    })
}

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
        M.toast({html: "<i class='material-icons' style='color: #85ff51'>add</i>"});
      } else {
        M.toast({html: "<i class='material-icons' style='color: #ff5151'>clear</i>"});
      }
    }

  })

  return false;
})

$(document).ready(function(){
      $.ajax({
        url: "../verificar.php",
        type: "post",
        data: "executarFuncao="+4,
        success: function(result){
          jQuery("#nomeID").html("<a id='nomeID'><span class='white-text name'>"+result.toString()+"</h5>");
        }

      })

      $.ajax({
        url: '../templates/menu.php',
        success: function(menu){
        $('#menuID').html(menu);
        }

      });

      atualizaContador();
      atualizaUlt();

      $.ajax({
          url: "funcoes.php",
          type: "post",
          data: "funcao="+3+"&numero="+0,
          success: function(result){

              if(result != null){
                  $("#turno").html(result);
              }

          }
      })

      $.ajax({
          url: "funcoes.php",
          type: "post",
          data: "funcao="+5+"&numero="+0,
          success: function(result){
              if(result == 1){
                  document.getElementById("carregando").style.display = "none";
                  document.getElementById("passou").style.display = "block";
              }else{
                  window.location='../index.html';
              }
          }
     })

     $('select').formSelect();
     $('.dropdown-trigger').dropdown();
     $('.sidenav').sidenav();
     $('.tabs').tabs();
});
