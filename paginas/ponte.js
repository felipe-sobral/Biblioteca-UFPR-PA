// login.html
$('#loginform').submit(function() {
   var usuario = $('#usuario').val();
   var senha = $('#senha').val();
	
	$.post("../root/secoes/usuarios/logar.php", {usuario: usuario, senha: senha}, function(data){
		if(data == "#true"){
         window.location = 'painel.php';
      } else {
			mensagem_error("Opss...", "Nome de usuário ou senha está incorreto");
      }
	});

   return false;
});

// geral
function mensagem_error(cabecalho, mensagem){
	$("#mensagemID").html("<div class='ui floating red message'><div class='content'><div class='header'>"+cabecalho+"</div><p>"+mensagem+"</p></div></div>");
}

function autenticacao(){
	$.post("../root/secoes/usuarios/autentica.php", {}, function(data){
		if (data == "#false") {
			document.getElementById("carregando").style.display = "none";
			document.getElementById("passou").style.display = "block";
		} else {
         window.location = 'painel.php';
		}
	});
}

function autenticacao_restrita(){
   $.post("../root/secoes/usuarios/autentica.php", {}, function(data){
		if (data == "#true") {
			document.getElementById("carregando").style.display = "none";
			document.getElementById("passou").style.display = "block";
		} else {
         window.location = 'login.html';
		}
	});
}

function menu(){
   $.get("../root/templates/menu.php", function(data){
      var str = data+"<script>$('.collapsible').collapsible();</script>";
		$('#menuID').html(str);
		console.log(str);
   });
}

/*
 	x = 0 -> ATUALIZAR CONTADOR
	x = 1 -> ADICIONAR
	x = -1 -> DECREMENTAR
*/
function atualizar_contador(x){
	$.post("../root/secoes/contador_usuarios/contar.php", {stat: x}, function(data){
		if(data != null){
			$("#contador").html("<h1 id='contador' style='color: #161616'>" + data.toString() + "</h1>");
		}
	});
}
