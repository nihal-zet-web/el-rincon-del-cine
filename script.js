//Aquí usamos javascript para mostrar los mensajes al usuario dependiendo de la situación en la que se 
//encuentren después de haber rellenado el formulario de registro o el de comentarios
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
                    alert("Te has registrado correctamente!");
                    $("#username").val("");
                    $("#email").val("");
                    $("#password").val("");
                } else if (response.trim() === "existe") {
                    alert("Este nombre de usuario ya está en uso");
                } else {
                    alert(response);    
                }
            }
        });
    });
});

//Enviar un comentario
$(document).ready(function() {
    $("#comment-form").on("submit", function(e) {
        e.preventDefault();
        var postId = $("input[name='post-id']").val();
        var userComment = $("#user-comment").val();
        if (userComment.trim() === "") {
            alert("Escribe un comentario.")
            return;  
        }

        $.ajax({
            url: "añadir_comentarios.php",
            method: "GET",
            data: {
                myPostId: postId,
                comment: userComment
            },
            success: function (response) {    
                if (response.trim() === "success") {
                alert("Comentario añadido!");
                $("#user-comment").val("");
                location.reload();
                } else {
                    alert(response);
                }
            }
        });
    });    
});

      