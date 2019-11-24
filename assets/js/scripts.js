$(document).ready(function() {

	if(getCookie('CDUSUARIO') != -1) {
		exibeMenuAdmin()	
	}

	if(getCookie('MASTER') == 'Y') {
		exibeMenuMaster();
	}


	$('#sistema').select2({

	  placeholder: 'Selecione',
	  tags: true,
	  createTag: function (params) {
	    return {
	      id: params.term,
	      text: params.term,
	      newOption: true
	    }
	  },
	  templateResult: function (data) {
	    var $result = $("<span></span>");

	    $result.text(data.text);

	    if (data.newOption) {
	      $result.append(" <em>(Pressione Enter para salvar)</em>");
	    }

	    return $result;
	  }

	});

	$('#categoria').select2({

	  placeholder: 'Selecione',
	  tags: true,
	  createTag: function (params) {
	    return {
	      id: params.term,
	      text: params.term,
	      newOption: true
	    }
	  },
	  templateResult: function (data) {
	    var $result = $("<span></span>");

	    $result.text(data.text);

	    if (data.newOption) {
	      $result.append(" <em>(Pressione Enter para salvar)</em>");
	    }

	    return $result;
	  }

	});


	// Verifica página
    var url_atual = window.location.href;
    if(url_atual.indexOf('editRegra.php') != -1) {
    	if(getCookie('CDUSUARIO') == -1) {
    		alert('Você precisa estar logado para cadastrar uma regra de negócio!');
    		location.href = 'home.php';
    	} else {

    		var idregra = $("#idRegra").val();
    		$.ajax({
    			type: 'GET',
    			data: {idregra: idregra},
    			url: '../controller/ajax/carregaRegra.php',
    		}).then(function (data) {
    			data = JSON.parse(data);

    			var cdsistema   = data[0].cdsistema;
    			var cdcategoria = data[0].cdcategoria;

				var sistema = $("#sistema");
				$.ajax({
					type: 'GET',
					url: '../controller/ajax/carregaSistema.php',
				}).then(function (data) {
					data = JSON.parse(data);

					$(data).each(function(index, value) {

						if(value.index == cdsistema) 
							isSelected = true;
						else
							isSelected = false;

						var option = new Option(value.value, value.index, false, isSelected);
						sistema.append(option).trigger('change');

						sistema.trigger({
							type: 'select2:select',
							params: {
								data: data
							}
						})
					});
				})

				var categoria = $("#categoria");
				$.ajax({
					type: 'GET',
					url: '../controller/ajax/carregaCategoria.php',
				}).then(function (data) {
					data = JSON.parse(data);				
					
					$(data).each(function(index, value) {

						if(value.index == cdcategoria) 
							isSelected = true;
						else
							isSelected = false;	

						var option = new Option(value.value, value.index, true, isSelected);
						categoria.append(option).trigger('change');

						categoria.trigger({
							type: 'select2:select',
							params: {
								data: data
							}
						})
					});
				})

    		})

    	}
    }	


	$("#form-search").submit(function() {
    	
    	return false;
	});

	$("#procura-master").keypress('click', function(e) {
		if(e.which == 13) {
			var busca = $("#procura-master").val();
			if( busca != "" ) {
				buscaRegras(busca);
			}
		}
	});

	$("#btn-procura-master").click(function() {
		var busca = $("#procura-master").val();
		if( busca != "" ) {
			buscaRegras(busca);
		}
	})

	$("#enviaFormRegra").click(function() {
		var idregra      = $("#idRegra").val();
		var auxSistema   = $("#sistema option:selected").attr('data-select2-tag');
		var auxCategoria = $("#categoria option:selected").attr('data-select2-tag');

		if(auxSistema)
			var sistema = $("#sistema option:selected").val()
		else 
			var sistema = $("#sistema option:selected").text();
		
		if(auxCategoria)
			var categoria = $("#categoria option:selected").val()
		else
			var categoria = $("#categoria option:selected").text()

		
		var regra     = $("#regra").val();
		// editaRegra( $("#formRegra").serialize() );

		if(regra == "") 
			alert('É obrigatório o preenchimento da Regra')
		
		else if(sistema == "") 
			alert('É obrigatório o preenchimento do Sistema')
		
		else if(categoria == "") 
			alert('É obrigatório o preenchimento da Categoria')
		else
			editaRegra(regra, sistema, categoria, idregra);
	})

	$("#cadastrarUsuarios").click(function() {
		carregaCadastroUsuario();
	})
	
	$("#carregaFormUsuario").click(function() {
		carregaFormUsuario();
	})

	$("#listarRegras").click(function() {
		location.href = 'home.php';
	})

	$("#senhaUsuario").on("focusin", function() {
		if($("#senhaUsuario").val() == "********") {
			if(confirm("Deseja alterar a senha deste usuário?") == true) {
				$("#senhaUsuario").val("");
				$("#senhaUsuario").focus();
			} else {
				$("#nmUsuario").focus();
			}			
		}
	})

	$("#enviaFormUsuario").click(function() {
		
		if($("#nmUsuario").val() == "") 
			alert('É obrigatório o preenchimento do Nome')
		
		else if($("#loginUsuario").val() == "") 
			alert('É obrigatório o preenchimento do Login')
		
		else if($("#senhaUsuario").val() == "") 
			alert('É obrigatório o preenchimento da Senha')
		else
			editaUsuario( $("#formUsuario").serialize() );
		
	})

	$("#sair").click(function() {
		desconectar();
	})

	$("#enviaLogin").click(function() {
		console.log('true');
		autenticaUsuario( $("#formLogin").serialize() );
	})
	
    $(".alert").addClass("in").fadeOut(4500);
    
    /* swap open/close side menu icons */
    $('[data-toggle=collapse]').click(function(){
          // toggle icon
      	$(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    });	

})


function autenticaUsuario(form) {

    $.ajax({
        
        type: "POST",
        url: "../controller/ajax/autenticaUsuario.php",
        data: form,
        dataType: 'json',
        success: function(data) {        	
			if(data == 1) {
				alert('Usuário ' + getCookie("LOGIN") + ' conectado');
				exibeMenuAdmin();
				if(getCookie('MASTER') == 'Y') {
					exibeMenuMaster();
				}
			} else{
				alert('Usuário não encontrado e/ou senha não confere');
			}				
    	},
    	error: function(xhr, status, error) {
    		alert('Usuário não encontrado  e/ou senha não confere');
    	},
    	complete: function() {
    		console.log('complete')
    	}
    
    });

}

function carregaCadastroUsuario() {
	location.href = 'admin.php';
}

function carregaFormUsuario(idUsuario) {
	$("#listagemUsuarios").hide();
	$("#cadastroUsuario").show();
	if(idUsuario) {
		$("#idUsuario").val(idUsuario);
		$.ajax({
	        type: "GET",
	        url: "../controller/ajax/getUsuario.php",
	        data: {
	        	cdUsuario: idUsuario
	        },
	        dataType: 'json',
	        success: function(data) {
	        	$("#nmUsuario").val(data[0].nmUsuario);
	        	$("#loginUsuario").val(data[0].login);
	        	
	        	if(data[0].master == 'Y') {
	        		$("#userMasterY").prop('checked', true)
	        	} else {
	        		$("#userMasterN").prop('checked', true)
	        	}

	        	$("#senhaUsuario").val("********");
	        }
		})
	}
}

function carregraRegra(cdregra) {
	location.href="editRegra.php?cdregra="+cdregra;
}

function exibeMenuAdmin() {
	$("#admin-dropdown").css('display', 'block');
	$("#formLogin").css('display', 'none');
}

function exibeMenuMaster() {
	$("#cadastrarUsuarios").css('display', 'block');
}

function desconectar() {	
	$("#admin-dropdown").css('display', 'none');
	$("#formLogin").css('display', 'block');
	
	// ZERA OS COOKIES
	zeraCookies();
	location.href = 'home.php';
}

function editaRegra(regra, sistema, categoria, idregra) {

	if(getCookie('CDUSUARIO') == -1) {
		alert('Você precisa estar logado para cadastrar/alterar uma regra de negócio!');
		location.href = 'home.php';
	} else {

	    $.ajax({
	        
	        type: "POST",
	        url: "../controller/ajax/executeRegra.php",
	        data: {
	        	regra: regra,
	        	sistema: sistema,
	        	categoria: categoria,
	        	idregra: idregra
	        },
	        dataType: 'json',
	        success: function(data) {
	        	
	        	location.href = 'home.php';
	        	
	    	},
	    	error: function(xhr, status, error) {
	    		console.log('error');
	    	},
	    	complete: function() {
	    		console.log('complete')
	    	}
	    
	    });
	}

}

function removeRegra(cdregra) {

	if(getCookie('CDUSUARIO') == -1) {
		alert('Você precisa estar logado para excluir uma regra de negócio!');
		location.href = 'home.php';
	} else {
	    $.ajax({
	        
	        type: "POST",
	        url: "../controller/ajax/removeRegra.php",
	        data: {'cdregra': cdregra},
	        dataType: 'json',
	        success: function(data) {
	        	location.reload();
	    	},
	    	error: function(xhr, status, error) {
	    		console.log('error');
	    	},
	    	complete: function() {
	    		console.log('complete')
	    	}
	    
	    });
	}

}


function editaUsuario(form) {

    $.ajax({
        
        type: "POST",
        url: "../controller/ajax/executeUsuario.php",
        data: form,
        dataType: 'json',
        success: function(data) {
        	
        	location.href = 'admin.php';
        	
    	},
    	error: function(xhr, status, error) {
    		console.log('error');
    	},
    	complete: function() {
    		console.log('complete')
    	}
    
    });

}

function removeUsuario(cdusuario) {

    $.ajax({
        
        type: "POST",
        url: "../controller/ajax/removeUsuario.php",
        data: {'cdusuario': cdusuario},
        dataType: 'json',
        success: function(data) {
        	location.reload();
    	},
    	error: function(xhr, status, error) {
    		console.log('error');
    	},
    	complete: function() {
    		console.log('complete')
    	}
    
    });

}

function buscaRegras(busca) {	
	location.href = "home.php?busca="+busca;
	
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
	  var c = ca[i];
	  while (c.charAt(0) == ' ') {
		c = c.substring(1);
	  }
	  if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
	  }
	}
	return "";
  }
  
  function checkCookie() {
	var user = getCookie("username");
	if (user != "") {
	  alert("Welcome again " + user);
	} else {
	  user = prompt("Please enter your name:", "");
	  if (user != "" && user != null) {
		setCookie("username", user, 365);
	  }
	}
  }

  function listCookies() {
    var theCookies = document.cookie.split(';');
    var aString = '';
    for (var i = 1 ; i <= theCookies.length; i++) {
        aString += i + ' ' + theCookies[i-1] + "\n";
    }
    return aString;
}


function zeraCookies() {
	eraseCookie('CDUSUARIO');
	eraseCookie('NMUSUARIO');
	eraseCookie('LOGIN');
	eraseCookie('MASTER');
}

function eraseCookie(name) {
	setCookie(name,-1);
}