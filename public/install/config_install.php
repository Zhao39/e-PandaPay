<?php
if (isset($_GET['lic'])) {
    $lic = $_GET['lic'];
} else {
    $lic = "";
}

$response = "";
$installed = false;
if ($_POST['installation']) {
    $app_url = $_POST['app_url'];
    $license = $_POST['license'];
    $user = $_POST['user'];
    $code = $_POST['code'];
    $db_name = $_POST['db_name'];
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $admin_email = $_POST['admin_email'];
    $install_type = $_POST['install_type'];
    $admin_password = $_POST['admin_password'];
    $status = true;
    //var_dump($db_name);
    if (!$status) {
        $response = "<h2 class='text-center text-red'>Something went wrong<h2>";
    } else {
        if (importDatabase($db_host, $db_name, $db_user, $db_pass, $admin_email, $admin_password, $license, $app_url, $install_type)) {
            $response = '<div class="cntr" class="message-body">
                            <h3>Installation complete! </h3>
                            <a href="' .  $base_url . '" class="btn btn-success btn-sm">
                                Go to Website
                            </a> 
                            <br><br><b class="text-red" >We strongly recommend deleting the install folder</b><br>
                        </div>';
            $installed = true;
            ////////////////////// UPDATE CONFIG
            $key = base64_encode(random_bytes(32));
            $output =
                '
                  APP_NAME=E-PandaPay
                  APP_ENV=production
                  APP_KEY=base64:hWdTLf5xarCJCaK/8RbT/nw6VPSoruWGgzbHKkomRf4=
                  APP_DEBUG=false
                  APP_URL=' .
                $base_url .
                '
                  
                  LOG_CHANNEL=stack
                  LOG_DEPRECATIONS_CHANNEL=null
                  LOG_LEVEL=debug
                  
                  DB_CONNECTION=mysql
                  DB_HOST=' .
                $db_host .
                '
                  DB_PORT=3306
                  DB_DATABASE=' .
                $db_name .
                '
                  DB_USERNAME=' .
                $db_user .
                '
                  DB_PASSWORD="' .
                $db_pass .
                '"' .
                '
                  
                  BROADCAST_DRIVER=log
                  CACHE_DRIVER=database
                  FILESYSTEM_DISK=public
                  QUEUE_CONNECTION=database
                  SESSION_DRIVER=database
                  SESSION_LIFETIME=120
                  
                  MEMCACHED_HOST=127.0.0.1
                  
                  REDIS_HOST=127.0.0.1
                  REDIS_PASSWORD=null
                  REDIS_PORT=6379
                  
                  MAIL_MAILER=smtp
                  MAIL_HOST=mailpit
                  MAIL_PORT=1025
                  MAIL_USERNAME=null
                  MAIL_PASSWORD=null
                  MAIL_ENCRYPTION=null
                  MAIL_FROM_ADDRESS="hello@example.com"
                  MAIL_FROM_NAME="${APP_NAME}"
                  
                  AWS_ACCESS_KEY_ID=
                  AWS_SECRET_ACCESS_KEY=
                  AWS_DEFAULT_REGION=us-east-1
                  AWS_BUCKET=
                  AWS_USE_PATH_STYLE_ENDPOINT=false
                  
                  PUSHER_APP_ID=
                  PUSHER_APP_KEY=
                  PUSHER_APP_SECRET=
                  PUSHER_HOST=
                  PUSHER_PORT=443
                  PUSHER_SCHEME=https
                  PUSHER_APP_CLUSTER=mt1
                  
                  VITE_APP_NAME="${APP_NAME}"
                  VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
                  VITE_PUSHER_HOST="${PUSHER_HOST}"
                  VITE_PUSHER_PORT="${PUSHER_PORT}"
                  VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
                  VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
                  
                    ';

            $file = fopen('../../.env', 'w');
            fwrite($file, $output);
            fclose($file);
        } else {
            echo "<h3 class='text-center text-red'>Please Check Your Database Credential!<h3>";
        }
    }
}
?>
<div class="step-installer first-installer second-installer third-installer">
    <div class="installer-content">
        <div class="step-installer first-installer second-installer third-installer">
            <?php if ($installed) { ?>
            <?php echo $response; ?>
            <?php } ?>
            <?php if (!$installed) { ?>
            <center class="installer-header">
                <h3>Database Information</h3>
            </center>
            <div class="installer-content">
                <?php echo $response; ?>
                <form action="?action=config" method="post">
                    <div class="form-group">
                        <input type="hidden" name="installation" value="1">
                        <h6>APP URL</h6>
                        <input name="license" value="<?php echo $lic; ?>" type="hidden">
                        <input class="form-control" name="app_url" value="<?php echo $base_url; ?>" type="text"><br>
                    </div>
                    <div class="form-group">
                        <h6>Installation Locaion/Type</h6>
                        <select class="form-select" name="install_type">
                            <option value="Main-Domain">
                                Main Domain (eg https://site.com)
                            </option>
                            <option value="Sub-Domain">
                                Sub Domain (eg https://sub.site.com)
                            </option>
                            <option value="Sub-Folder">
                                Sub Directory/Folder (eg https://site.com/sub-directory)
                            </option>
                        </select>
                    </div>
                    <h5 class="mt-4 mb-2">Database Details</h5>
                    <input class="form-control input-lg" name="db_name" placeholder="Database Name" type="text"
                        required="">
                    <br>
                    <input class="form-control input-lg" name="db_host" placeholder="Database Host" type="text"
                        required="">
                    <br>
                    <input class="form-control input-lg" name="db_user" placeholder="Dabatabe User" type="text"
                        required=""><br>
                    <input class="form-control input-lg" name="db_pass" placeholder="Password" type="text"
                        required=""><br>
                    <hr>
                    <h6>Configure super admin Login for your E-PandaPay website</h6>
                    <input class="form-control input-lg" name="admin_email" placeholder="Enter your email" type="text"
                        required=""><br>
                    <input class="form-control input-lg" name="admin_password" placeholder="Enter password" type="text"
                        required=""><br>

                    <button class="btn btn-success" type="submit">INSTALL NOW</button>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>