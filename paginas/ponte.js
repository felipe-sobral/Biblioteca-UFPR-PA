
// login.html
$('#loginform').submit(function() {
   var usuario = $('#usuario').val();
   var senha = $('#senha').val();
	
	$.post("../root/secoes/usuarios/logar.php", {usuario: usuario, senha: senha}, function(data){
		if(data == "#true"){
         window.location = 'painel.html';
      } else {
         M.toast({html: 'Opss... Usuário ou senha incorreto', classes: 'rounded toast-vermelho'});
      }
	});

   return false;
});

// geral
function autenticacao(){
	$.post("../root/secoes/usuarios/autentica.php", {}, function(data){
		if (data == "#false") {
			document.getElementById("carregando").style.display = "none";
			document.getElementById("passou").style.display = "block";
		} else {
         window.location = 'painel.html';
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
   $.get("../root/secoes/menu.php", function(data){
      var str = data+"<script>$('.collapsible').collapsible();</script>";
      $('#menuID').html(str);
   });
}
