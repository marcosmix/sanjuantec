class Boton {
    constructor (className, opciones = {}) {
        this.botones = document.querySelectorAll('.' + className);

        this.botones.forEach(boton => {
            if (opciones.volver) {
                boton.addEventListener('click', (event) => this.volver(event));
            }

            if (opciones.verPdf) {
                boton.addEventListener('click', (event) => this.verPdf(event));
            }
        });
    }

    volver (event) {
        try {
            event.preventDefault();

            if (window.history.length > 1) {
                window.history.go(-1);
            } else {
                window.location.href = document.referrer;
            }
        } catch (error) {
            // Ignorar el error TypeError no crítico causado por un posible problema en el manejo del evento.
        }
    /**
     * Maneja el evento de volver atrás en la navegación del navegador.
     *
     * Este método se utiliza para controlar el evento de volver atrás en la navegación del navegador.
     * Intenta usar la API de historial del navegador para retroceder una página. Si no hay historial,
     * redirige a la página de referencia del documento.
     *
     * Ignora el error de TypeError que podría ocurrir si el evento no está definido, ya que no es crítico para
     * la ejecución. En tal caso, se supone que el error se debe a problemas internos en el manejo o la propagación
     * del evento.
     * @author Leandro Brizuela
     * @param {Event} event El evento de clic que desencadenó la función.
     */
    }

    verPdf (event) {
        try {
            const elementoEnlace = event.currentTarget;
            const documento = elementoEnlace.getAttribute('data-documentoalumno');
            const nombreCurso = elementoEnlace.getAttribute('data-nombrecurso');
            const url = `/mostrarPdf/${encodeURIComponent(documento)}/${encodeURIComponent(nombreCurso)}`;
            window.open(url, '_blank');
        } catch (error) {
            // Ignorar el error TypeError no crítico causado por un posible problema en el manejo del evento.
        }
    /**
     * Abre una ventana emergente para mostrar un archivo PDF.
     *
     * Este método se utiliza para abrir una ventana emergente que muestra un archivo PDF.
     * Utiliza los atributos de datos del enlace clicado para construir la URL del PDF.
     *
     * Ignora el error de TypeError que podría ocurrir si el evento no está definido, ya que no es crítico para
     * la ejecución. En tal caso, se supone que el error se debe a problemas internos en el manejo o la propagación
     * del evento.
     * @author Leandro Brizuela
     * @param {Event} event El evento de clic que desencadenó la función.
     */
    }
}
