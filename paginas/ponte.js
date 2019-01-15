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
   });
}

function campos_vazios(campos){
	for(campo in campos){
		if($("#"+campos[campo]).val().length == 0){
			return true;
		}
	}

	return false;
}

function zero_frente(n){
	var x = parseInt(n);
	if(x<10 && x>0){
		return "0"+x;
	}
	return x;
}

function data_formatada(dia, mes, ano){
	return ano+"-"+zero_frente(mes)+"-"+zero_frente(dia);
}

function criar_toast(mensagem, tempo, tipo){
	Materialize.toast(mensagem, tempo, tipo);
}

/*
	DATA: 14/01/2019
	INFO: TRATAR RETORNOS DO PHP
	ERROR: --
*/
function tratarRetorno(data){
	var retorno = JSON.parse(data);

	if('status' in retorno){
		if(retorno.status){
			criar_toast('<i class="material-icons">check</i>', 1000, "toast-verde");
		} else {
			criar_toast('<i class="material-icons">close</i>', 1000, "toast-vermelho");
		}
	} else {
		Console.log(data);
	}

}


function atualizarCodigos(){
	$.post("../root/funcoes/atualizar.php", {}, function(data){
		tratar_retorno(data);
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
			$("#contador").html(data.toString());
		}
	});
}

function imprimirTabela(conteudo) {
  var imprimir = document.getElementById(conteudo).innerHTML;
  tela_impressao = window.open('about:blank');
  tela_impressao.document.write(imprimir);
  tela_impressao.window.print();
  tela_impressao.window.close();
}

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