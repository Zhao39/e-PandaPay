<?php
recursiveChmod('../../public');
$error = 0;
$phpversion = version_compare(PHP_VERSION, '8.1', '>=');
?>
<div class="step-installer first-installer second-installer">
    <center>
        <h3>Server requirements</h3>
    </center>
    <div class="installer-content table-responsive">
        <table class="table table-striped cntr">
            <tbody>
                <?php
                if ($phpversion == true) {
                    $error = $error + 0;
                    createTable('PHP', 'Required PHP version 8.1 or higher', 1);
                } else {
                    $error = $error + 1;
                    createTable('PHP', 'Required PHP version 8.1 or higher', 0);
                }
                foreach ($extensions as $key) {
                    $extension = extension_check($key);
                    if ($extension == true) {
                        $error = $error + 0;
                        createTable($key, 'Required ' . strtoupper($key) . ' PHP Extension', 1);
                    } else {
                        $error = $error + 1;
                        createTable($key, 'Required ' . strtoupper($key) . ' PHP Extension', 0);
                    }
                }
                foreach ($folders as $key) {
                    $folder_perm = folder_permission($key);
                    if ($folder_perm == true) {
                        $error = $error + 0;
                        createTable(str_replace('../', '', $key), ' Required permission: 0755 ', 1);
                    } else {
                        $error = $error + 1;
                        createTable(str_replace('../', '', $key), ' Required permission: 0755 ', 0);
                    }
                }
                $envCheck = is_writable('../../.env');
                if ($envCheck == true) {
                    $error = $error + 0;
                    createTable('env', ' Required .env to be writable', 1);
                } else {
                    $error = $error + 1;
                    createTable('env', ' Required .env to be writable', 0);
                }
                $database = file_exists('DATABASE.sql');
                if ($database) {
                    $error = $error + 0;
                    createTable('Database', '  Required DATABASE.sql available', 1);
                } else {
                    $error = $error + 1;
                    createTable('Database', ' Required DATABASE.sql available', 0);
                }
                echo '</tbody></table><div class="button">';
                if ($error == 0) {
                    echo '<a class="button is-warning" href="?action=activate">Next Step <i class="fa fa-angle-double-right"></i></a>';
                } else {
                    echo '<a class="button is-warning" href="?action=requirements">ReCheck <i class="fa fa-sync-alt"></i></a>';
                }
                ?>
    </div>
</div>