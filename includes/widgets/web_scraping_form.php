<div class="widget" style="padding: 15px; border-radius: 15px;">
    <h3><?php echo __('Pruebas Automáticas', 'cftp_admin'); ?></h3>
    <form id="scrapingForm">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" required style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
        
        <label for="test_type">Tipo de Prueba:</label>
        <select id="test_type" name="test_type" onchange="toggleInputs()" required style="border-radius: 50px; padding: 10px 15px; height: 30px;">
            <option value="search">Búsqueda</option>
            <option value="create_account">Crear Cuenta</option>
        </select><br><br>
        
        <div id="search_term_input">
            <label for="search_term">Término de Búsqueda:</label>
            <input type="text" id="search_term" name="credentials_or_search_term" style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
        </div>
        
        <div id="credentials_input" style="display:none;">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
        </div>
        
        <label for="file_name">Nombre del Archivo (debe terminar en .csv):</label>
        <input type="text" id="file_name" name="file_name" required style="border-radius: 50px; padding: 10px 15px; height: 30px;"><br><br>
        
        <button type="submit" style="border-radius: 50px; padding: 10px 15px; height: 40px;">Enviar</button>
    </form>
    <div id="result" style="margin-top: 20px; display: none;">
        <h3>Resultados de la Prueba</h3>
        <pre id="output"></pre>
    </div>
</div>

<script>
function toggleInputs() {
    var testType = document.getElementById('test_type').value;
    if (testType === 'search') {
        document.getElementById('search_term_input').style.display = 'block';
        document.getElementById('credentials_input').style.display = 'none';
    } else {
        document.getElementById('search_term_input').style.display = 'none';
        document.getElementById('credentials_input').style.display = 'block';
    }
}

document.getElementById('scrapingForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Previene el envío del formulario estándar

    var formData = new FormData(this);

    fetch('/projectsend/scraping/web_scraping_endpoint.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').style.display = 'block';
        document.getElementById('output').textContent = data;
    })
    .catch(error => console.error('Error:', error));
});
</script>
