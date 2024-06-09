<?php
/**
 * Home page for logged in system users.
 */
$allowed_levels = array(9, 8, 7);
require_once 'bootstrap.php';
$page_title = __('Dashboard', 'cftp_admin');

$active_nav = 'dashboard';

$body_class = array('dashboard', 'home', 'hide_title');
$page_id = 'dashboard';

include_once ADMIN_VIEWS_DIR . DS . 'header.php';

define('CAN_INCLUDE_FILES', true);

if (current_role_in([9])) {
    include_once WIDGETS_FOLDER . 'counters.php';
}

$test_output = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo '<div class="alert alert-success">Archivo subido con éxito: ' . htmlspecialchars($_GET['file']) . '</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($_GET['message']) . '</div>';
    }
}
?>

<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <?php include_once WIDGETS_FOLDER . 'statistics.php'; ?>
            </div>
        </div>
    </div>

    <?php
    if (current_role_in([9])) {
    ?>
        <div class="col-sm-4 container_widget_actions_log">
            <?php include_once WIDGETS_FOLDER . 'actions-log.php'; ?>
        </div>
    <?php
    }
    ?>
</div>

<div class="row">
    <div class="col-12">
        <?php include_once WIDGETS_FOLDER . 'web_scraping_form.php'; ?>
        <div id="result" style="display:none;">
            <h3>Resultados de la Prueba</h3>
            <pre id="output"></pre>
        </div>
    </div>
</div>

<?php
include_once ADMIN_VIEWS_DIR . DS . 'footer.php';
?>

