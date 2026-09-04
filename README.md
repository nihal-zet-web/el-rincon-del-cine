El Rincón del Cine - Plataforma de Blog de Cine.
Es una plataforma web completa para amantes del cine, desarrollada como un blog dinámico que permite a los usuarios
registrarse, explorar publicaciones sobre películas, interactuar a través de comentarios y gestionar su actividad. 

CARACTERÍSTICAS PRINCIPALES: 

- Sistema de Autenticación Seguro: 
  Registro de usuarios. El sistema verifica durante el proceso si el nombre de usuario ya existe en la base de datos para evitar duplicados.
  
- Página de Inicio Dinámica (Home):
  Muestra la lista completa de todas las publicaciones de cine disponibles.
  
- Vista de Detalle de Publicaciones:
  Al hacer clic en cualquier post, se accede a una página independiente con los detalles específicos de la publicación.
  
- Sistema de Comentarios por Post:
  Cada publicación cuenta con su propia sección de comentarios, permitiendo el debate entre los usuarios.
  
- Historial de Comentarios:
  Los usuarios registrados pueden acceder a un apartado privado para ver el historial de todos los comentarios que han realizado en la plataforma.
  
- Barra de Navegación Global:
  Menú accesible desde cualquier sección para navegar fácilmente entre Inicio, Registro y Contacto.
  
- Formulario de Contacto:
  Página dedicada para que los usuarios puedan enviar mensajes o sugerencias.

TECNOLOGÍAS UTILIZADAS: 

Frontend: HTML5, CSS3, JavaScript.
Interacciones Dinámicas: jQuery y AJAX para enviar y recibir datos del servidor (como la validación de usuarios o 
el envío de comentarios) en segundo plano, evitando recargar la página.
Backend: PHP para la lógica del servidor, gestión de sesiones y procesamiento de peticiones.
Base de Datos: MySQL para el almacenamiento relacional de usuarios, publicaciones y comentarios.

📊 Estructura de la Base de Datos (MySQL)
El sistema cuenta con tres entidades principales interconectadas:
Usuarios: Almacena el identificador único, nombre de usuario, correo electrónico y contraseña encriptada.
Publicaciones: Contiene el título, contenido, fecha de creación y detalles de los artículos de cine.
Comentarios: Registra el texto del comentario, la fecha, y se vincula mediante foreign keys tanto al usuario 
que lo creó como al post donde se publicó. 
