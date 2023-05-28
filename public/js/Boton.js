class Boton {
    constructor(id) {
        this.button = document.getElementById(id);
        this.button.addEventListener('click', (event) => this.volver(event));
    }

    volver(event) {
        try {
            event.preventDefault();

            if (window.history.length > 1) {
                window.history.go(-1);
            } else {
                window.location.href = document.referrer;
            }
        } catch (error) {
            // TODO Esta funcionalidad da un error que no es crítico para la ejecución. Por lo que este manejo del error
            // ignora el mismo para que no sea mostrado en la consola del navegador.

            // El error es el siguiente:
            // Uncaught TypeError: event is undefined
            // volver http://localhost:8000/js/Boton.js:8
            // <anonymous> http://localhost:8000/plantillas/generar:72
            //
            // Es posible que el error sea causado por un error interno en el manejo o el mecanismo de propagación del
            // evento.
        }
    }
}
