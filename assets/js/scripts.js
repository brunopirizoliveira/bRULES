$(document).ready(function() {

	desconectar();

	$('.select2').select2({

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
	      $result.append(" <em>(new)</em>");
	    }

	    return $result;
	  }

	});

	$("#enviaFormRegra").click(function() {
		editaRegra( $("#formRegra").serialize() );
	})

	$("#cadastrarUsuarios").click(function() {
		carregaCadastroUsuario();
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
			} else{
				alert('Usuário não encontrado');
			}				
    	},
    	error: function(xhr, status, error) {
    		console.log('error');
    	},
    	complete: function() {
    		console.log('complete')
    	}
    
    });

}

function carregaCadastroUsuario() {
	location.href = 'admin.php';
}

function exibeMenuAdmin() {
	$("#admin-dropdown").css('display', 'block');
	$("#formLogin").css('display', 'none');
}

function desconectar() {
	$("#admin-dropdown").css('display', 'none');
	$("#formLogin").css('display', 'block');
}

function editaRegra(form) {

    $.ajax({
        
        type: "POST",
        url: "../controller/ajax/executeRegra.php",
        data: form,
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