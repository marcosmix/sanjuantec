<style>
    .form-curso{
        width: 60%;
        margin: 30px 20% 0 20%;
    }
    .cont-check-box{
        padding: 20px 14px;
        border: solid salmon 1px;
        border-radius: 14px;
        
    }
</style>
        <div class="mb-3">
            <label class="form-label" for="fecha">Fecha de emisión (4)</label>
            <input type="text" class='form-control' name="fecha" id="fecha">
        </div>

        <div class="mb-3">
            <label class="form-label" for="bloque_organizacion">Bloque y organizacion (3)</label>
            <input type="text" class='form-control' name="bloque_organizacion" id="bloque_organizacion">
        </div>
        <div class="mb-3">
            <p>Listado de alumnos</p>
            <input type="file" name="listado" id="listado">
        </div>
       <div class="cont-check-box">
           <div class="mb-3">
               <label class="form-label" for="fecha">Firmas de autoridades</label>
               <input type="checkbox" class='' name="firmas" id="firmas">
            </div>
            <div class="mb-3">
                <label class="form-label" for="enviar">
                    Enviar por m@ail despues de crear <input type="checkbox" class='' name="enviar" id="enviar">
                </label>
            </div>
        </div>


      
