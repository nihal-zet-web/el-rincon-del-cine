
//Registro
$(document).ready(function() {
    $("#register-form").on("submit", function (e) {
        e.preventDefault();
        var userUsername = $("#username").val();
        var userEmail = $("#email").val();
        var userPassword = $("#password").val();
        if (userUsername !== "" || userEmail !== "" || userPassword !== "") {
            if (userUsername.length < 4) {
                alert("El nombre de usuario de debe tener al menos 4 carácteres.");
            }
            if(!userEmail.includes("@")) {
                alert("Escribe un correo correcto.");
            }
            if(userPassword.length < 6){
                alert("La contraseña debe contener al menos 6 carácteres.");
            }
        } else {
            alert("Rellene este campo.");
        }
        
        $.ajax({
            url: "register.php",
            method: "POST",
            data: {
                username: userUsername, 
                email: userEmail,
                password: userPassword
            },
            success: function(response) {  
                if (response.trim() === "success") {
                    //mensaje de que todo ha salido correctamente
                    alert("Te has registrado correctamente!");
                    //vaciamos los contenedores
                    $("#username").val("");
                    $("#email").val("");
                    $("#password").val("");
                } else if (response.trim() === "existe") {
                    alert("Este nombre de usuario ya está en uso");
                } else {
                    alert("Ha ocurrido un problema. No se puede registrar en este momento.");    
                }
            }
        });
    });
});
//Enviar un comentario
$(document).ready(function() {
    $("#comment-form").on("submit", function(e) {
            e.preventDefault();
            //finds the values submited in the form using their
            //ids and reads the value using val()
            var postId = $("input[name='post-id']").val();
            var userComment = $("#user-comment").val();
            //print in the console the values we get 
            if (userComment.trim() === "") {
                alert("Escribe un comentario.")
                return; //PORQUE RETURN? 
            }
            $.ajax({
                url: "añadir_comentarios.php",
                method: "GET",
                data: {
                    myPostId: postId,
                    comment: userComment
                },
                success: function (response) {    
                    //usamos trim() para quitar posible espacios añadidos (he estado como 20min intentando entender que estaba mal cuando habia escrito todo bien, eran los espacios de su padre)
                    if (response.trim() === "success") {
                    alert("Comentario añadido!");
                    $("#user-comment").val("");
                    location.reload(); // Reload page to show new comment
                    } else {
                        alert("Ha ocurrido un problema. No se puede añadir su comentario en este momento");
                    }
                }
            });
        /*} else {
            alert("Se tiene que registrar para poder comentar.");
            e.preventDefault();
        }*/
    });
    
});

      