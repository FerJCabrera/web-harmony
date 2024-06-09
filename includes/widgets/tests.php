<div class="widget">
    <h3><?php echo __('Pruebas Automáticas', 'cftp_admin'); ?></h3>
    <form id="pruebas_form" method="POST">
        <div class="mb-3">
            <label for="url" class="form-label">URL a Probar</label>
            <input type="url" class="form-control" id="url" name="url" required>
        </div>
        <div class="mb-3">
            <label for="user" class="form-label">Usuario (Opcional)</label>
            <input type="text" class="form-control" id="user" name="user">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email (Opcional)</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (Opcional)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="search_term" class="form-label">Término de Búsqueda</label>
            <input type="text" class="form-control" id="search_term" name="search_term" required>
        </div>
        <div class="mb-3">
            <label for="report_name" class="form-label">Nombre del Archivo de Reporte</label>
            <input type="text" class="form-control" id="report_name" name="report_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Ejecutar Pruebas</button>
    </form>
    <div id="progress" style="display:none;">
        <h3>Progreso de la Prueba</h3>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%;" id="progress-bar"></div>
        </div>
    </div>
    <div id="result" style="display:none;">
        <h3>Resultados de la Prueba</h3>
        <pre id="output"></pre>
    </div>
</div>

<script>
    document.getElementById('pruebas_form').addEventListener('submit', function(event) {
        document.getElementById('progress').style.display = 'block';
        var progressBar = document.getElementById('progress-bar');
        var resultDiv = document.getElementById('result');
        var outputPre = document.getElementById('output');
        resultDiv.style.display = 'none';
        outputPre.innerText = '';

        var width = 0;
        var interval = setInterval(function() {
            if (width >= 100) {
                clearInterval(interval);
            } else {
                width++;
                progressBar.style.width = width + '%';
            }
        }, 100);
    });
</script>
