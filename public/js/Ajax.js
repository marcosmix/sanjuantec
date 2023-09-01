/**
 * @name enviarEmail
 * Envia un correo electrónico mediante una solicitud Ajax.
 *
 * Este método se encarga de manejar la lógica para enviar un correo electrónico utilizando
 * una solicitud Ajax. Recopila los datos del alumno y del curso desde los atributos de datos
 * del elemento en el que se hace clic, y luego realiza una solicitud Ajax al servidor para
 * procesar el envío del correo electrónico. En dicho proceso se realiza un registro en la base
 * de datos del email enviado.
 *
 * @param {string} csrfToken El token CSRF que se incluye en las cabeceras de la solicitud Ajax.
 * @returns {void}
 * @author Leandro Brizuela.
 */
function enviarEmail (csrfToken) {
    $('.boton-enviar').on('click', function(e) {
        e.preventDefault();
        var datos = {
            nombreAlumno: $(this).data('nombrealumno'),
            apellidoAlumno: $(this).data('apellidoalumno'),
            documentoAlumno: $(this).data('documentoalumno'),
            emailAlumno: $(this).data('emailalumno'),
            idCurso: $(this).data('idcurso'),
            nombreCurso: $(this).data('nombrecurso')
        };
        $.ajax({
            url: enviarCertificadoUrl,
            method: 'POST',
            data: datos,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                var divEstado = $('#estado-email');
                if (response.estado) {
                    divEstado.html('<p class="estado-exito mensaje-exito">El email ha sido enviado.</p>');
                    console.log(response.estado, response.mensaje);
                    console.log('Alumno:', response.alumno);
                    console.log('Curso:', response.curso);
                } else {
                    divEstado.html('<p class="alerta mensaje-error">Ha ocurrido un error: ' + response.mensaje + '</p>');
                    console.error(response.mensaje);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var divEstado = $('#estado-email');

                if (jqXHR.status === 0) {
                    divEstado.html('<p class="alerta mensaje-error">Sin conexión: Verifique red.</p>');
                    console.error('Sin conexión: Verifique red.');
                } else if (jqXHR.status == 404) {
                    divEstado.html('<p class="alerta mensaje-error">Recurso no encontrado [404].</p>');
                    console.error('Recurso no encontrado [404].');
                } else if (jqXHR.status == 500) {
                    divEstado.html('<p class="alerta mensaje-error">Error interno del servidor [500].</p>');
                    console.error('Error interno del servidor [500].');
                } else if (textStatus === 'parsererror') {
                    divEstado.html('<p class="alerta mensaje-error">Ha ocurrido un error al intentar interpretar el JSON requerido.</p>');
                    console.error('Ha ocurrido un error al intentar interpretar el JSON requerido.');
                } else if (textStatus === 'timeout') {
                    divEstado.html('<p class="alerta mensaje-error">El tiempo de espera ha excedido, generando un error.</p>');
                    console.error('El tiempo de espera ha excedido, generando un error.');
                } else if (textStatus === 'abort') {
                    divEstado.html('<p class="alerta mensaje-error">Petición Ajax abortada.</p>');
                    console.error('Petición Ajax abortada.');
                } else {
                    divEstado.html('<p class="alerta mensaje-error">Error no controlado: ' + jqXHR.responseText + '</p>');
                    console.error('Error no controlado:', jqXHR.responseText);
                }
            }
        });
    });
}

/**
 * @name enviarTodosLosEmails
 * Realiza el envío de correos electrónicos a todos los destinatarios especificados.
 *
 * Este método utiliza una solicitud Ajax para enviar correos electrónicos a todos los destinatarios
 * proporcionados en la matriz de datos. Se espera recibir un token CSRF para la seguridad de la solicitud.
 * Si la solicitud tiene éxito, se muestra el resultado en la consola. En caso de error, se manejan varios
 * códigos de estado y se actualiza un elemento en la interfaz para mostrar mensajes de error.
 *
 * @param {string} csrfToken El token CSRF para la seguridad de la solicitud.
 * @param {object} datos La matriz de datos a enviar en formato JSON, que contiene la información de los destinatarios.
 * @return {void}
 */
function enviarTodosLosEmails (csrfToken, datos) {
    $.ajax({
        url: '/certificados/enviarTodosLosCertificados',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        contentType: 'application/json',
        data: JSON.stringify(datos),
        dataType: 'json',
        success: function(resultado) {
            console.log(resultado);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            var divEstado = $('#estado-email');

            if (jqXHR.status === 0) {
                divEstado.html('<p class="alerta mensaje-error">Sin conexión: Verifique red.</p>');
                console.error('Sin conexión: Verifique red.');
            } else if (jqXHR.status == 404) {
                divEstado.html('<p class="alerta mensaje-error">Recurso no encontrado [404].</p>');
                console.error('Recurso no encontrado [404].');
            } else if (jqXHR.status == 500) {
                divEstado.html('<p class="alerta mensaje-error">Error interno del servidor [500].</p>');
                console.error('Error interno del servidor [500].');
            } else if (textStatus === 'parsererror') {
                divEstado.html('<p class="alerta mensaje-error">Ha ocurrido un error al intentar interpretar el JSON requerido.</p>');
                console.error('Ha ocurrido un error al intentar interpretar el JSON requerido.');
            } else if (textStatus === 'timeout') {
                divEstado.html('<p class="alerta mensaje-error">El tiempo de espera ha excedido, generando un error.</p>');
                console.error('El tiempo de espera ha excedido, generando un error.');
            } else if (textStatus === 'abort') {
                divEstado.html('<p class="alerta mensaje-error">Petición Ajax abortada.</p>');
                console.error('Petición Ajax abortada.');
            } else {
                divEstado.html('<p class="alerta mensaje-error">Error no controlado: ' + jqXHR.responseText + '</p>');
                console.error('Error no controlado:', jqXHR.responseText);
            }
        }
    });
}

