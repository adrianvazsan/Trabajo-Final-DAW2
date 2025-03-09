// Función para cerrar sesión y redirigir al inicio
function cerrarSesion() {
    localStorage.removeItem('users'); // Elimina los usuarios guardados en el localStorage
    window.location.href = 'index.html'; // Redirige a la página de inicio
}

$(document).ready(function () {
    // Evento para cambiar al formulario de registro
    $('#cambiarARegistro').on('click', function (e) {
        e.preventDefault(); // Previene el comportamiento predeterminado del enlace
        $('#loginForm').addClass('d-none'); // Oculta el formulario de login
        $('#registerForm').removeClass('d-none'); // Muestra el formulario de registro
    });

    // Evento para cambiar al formulario de login
    $('#cambiarALogin').on('click', function (e) {
        e.preventDefault(); // Previene el comportamiento predeterminado del enlace
        $('#registerForm').addClass('d-none'); // Oculta el formulario de registro
        $('#loginForm').removeClass('d-none'); // Muestra el formulario de login
    });

   // Evento para manejar el registro de nuevos usuarios
$('#registroForm').on('submit', function (e) {
    e.preventDefault();  // Previene el envío del formulario por defecto

    // Obtiene los valores ingresados en los campos de registro
    const name = $("#registerName").val(); 
    const email = $('#registerEmail').val();
    const password = $('#registerPassword').val(); 
    const repeatPassword = $('#repeatPassword').val(); 

    // Validación del formato del correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor, ingresa un correo electrónico válido.');
        return;
    }

    // Verifica si las contraseñas coinciden
    if (password !== repeatPassword) {
        $('#errorContraseña').removeClass('d-none'); // Muestra un mensaje de error si las contraseñas no coinciden
        return;
    } else {
        $('#errorContraseña').addClass('d-none'); // Oculta el mensaje de error si coinciden
    }

    // Recupera los usuarios almacenados en localStorage o inicializa un array vacío
    const users = JSON.parse(localStorage.getItem('users')) || [];

    // Verifica si el correo ya está registrado
    if (users.some(user => user.email === email)) {
        alert('El correo ya está registrado.');
        return;
    }

    // Agrega el nuevo usuario al array de usuarios y lo guarda en localStorage
    users.push({ name, email, password }); // Se guarda cualquier contraseña sin validación
    localStorage.setItem('users', JSON.stringify(users));

    // Muestra un mensaje de éxito y redirige al usuario al formulario de login
    alert('Registro exitoso. Ahora puedes iniciar sesión.');
    $('#cambiarALogin').click();
});


   // Evento para manejar el inicio de sesión
$('#loginForm').on('submit', function (e) {
    e.preventDefault(); // Previene el envío del formulario por defecto
    
    // Obtiene los valores ingresados en los campos de login
    const name = $("#loginName").val();
    const email = $('#loginEmail').val();

    // Recupera los usuarios almacenados en localStorage o inicializa un array vacío
    const users = JSON.parse(localStorage.getItem('users')) || [];

    // Busca un usuario que coincida con el nombre y correo ingresados (sin validar contraseña)
    const user = users.find(user => user.name === name && user.email === email);

    if (user) {
        alert('Inicio de sesión exitoso.'); // Si se encuentra el usuario, muestra un mensaje y redirige
        window.location.href = 'admin.html'; // Redirige al panel de administración
    } else {
        alert('Credenciales incorrectas.'); // Si no se encuentra el usuario, muestra un mensaje de error
    }
});

});

// Función para obtener los usuarios almacenados en localStorage
function obtenerUsers() {
    return JSON.parse(localStorage.getItem("users")) || [];
}

$(document).ready(function(){
    let usuarios = obtenerUsers(); // Recupera la lista de usuarios almacenados en localStorage

    // Verifica si el elemento de la tabla existe antes de inicializar DataTables
    if ($('#tabla').length) {
        let tabla = $('#tabla').DataTable({
            retrieve: true,  // Recupera la tabla existente (si hay)
            paging: true, // Habilita la paginación
            pageLength: 4, // Número de registros por página
            lengthMenu: [3, 6, 12, 24], // Opciones de registros por página
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                },
                aria: {
                    sortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        tabla.clear(); // Limpia la tabla antes de llenarla

        // Agrega cada usuario a la tabla
        usuarios.forEach(usuario => {
            tabla.row.add([usuario.name, usuario.email, usuario.password]).draw(); // Agrega una fila por usuario
        });
    }
});
