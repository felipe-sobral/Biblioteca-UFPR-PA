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

/*

	FORMULÁRIOS

*/
 
$("#form_adicionar_dia_EU").submit(function() {
	if(campos_vazios(["dia", "mes", "ano", "manha", "tarde", "noite"])){
		criar_toast("<i class='material-icons'>close</i> Campos vazios!", 1000, "toast-vermelho");
		return;
	}
	
	var data = data_formatada($("#dia").val(), $("#mes").val(), $("#ano").val());

	$.post("../root/secoes/contador_usuarios/adicionar.php", {manha: zero_frente($("#manha").val()), tarde: zero_frente($("#tarde").val()), noite: zero_frente($("#noite").val()), data: data}, function(retorno){
		if(retorno == "#true"){
			criar_toast("<i class='material-icons'>check</i>", 1000, "toast-verde");
		} else {
			criar_toast("<i class='material-icons'>close</i>", 1000, "toast-vermelho");
		}
			
	});
	
	return false;
});

$("#form_historico_EU").submit(function() {
	/*if(campos_vazios(["mes", "ano"])){
		criar_toast("<i class='material-icons'>close</i> Campos vazios!", 1000, "toast-vermelho");
		return false;
	}*/
	console.log($("#mes_historico_EU").val()+"___"+$("#ano_historico_EU").val());

	$.post("../root/secoes/contador_usuarios/historico.php", {mes: zero_frente($("#mes_historico_EU").val()), ano: $("#ano_historico_EU").val()}, function(retorno){
		if(retorno != "#false"){
			criar_toast("<i class='material-icons'>check</i>", 1000, "toast-verde");

			$("#historicoLista").html(retorno);
        	document.getElementById("aposProcurar").style.display = "block";
		} else {
			criar_toast("<i class='material-icons'>close</i>", 1000, "toast-vermelho");
		}
	});

	//SELECT * FROM e_usuarios WHERE MONTH(data) = 1 AND YEAR(data) = 2019;

	return false;
});