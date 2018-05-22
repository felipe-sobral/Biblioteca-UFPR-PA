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

$(document).ready(function(){

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

     $('.dropdown-trigger').dropdown();
     $('.sidenav').sidenav();
     $('.collapsible').collapsible();
     $('.tabs').tabs();
});
