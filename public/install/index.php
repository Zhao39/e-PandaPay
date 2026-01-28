<?php require 'functions.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>E-PandaPay - Setup wizard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bulma.min.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="front/assets/css/bootstrap.min.css">
    <script defer src="fa/fa.js"></script>
</head>

<body>
    <header>
        <div class="section-header">
            <p>E-PandaPay setup wizard</p>
            <a href="mailto:support@brynamics.com" target="_blank">Get help</a>
        </div>
    </header>
    <div class="container">
        <div class="section">
            <div class="column is-10 is-offset-1">
                <div class="box">
                    <article class="message is-success">
                        <div class="col-xl-12">
                            <?php
              if ($action == 'activate') {
                require_once('activate.php');
              } elseif ($action == 'config') {
                require_once('config_install.php');
              } elseif ($action == 'requirements') {
                require_once('requirements.php');
              } else {
                require_once('welcome.php');
              }
              ?>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div class="content has-text-centered">
        <p>Copyright <?php echo date('Y'); ?> Brynamics, All rights reserved.</p><br>
    </div>

    <script src="front/assets/js/jquery-3.6.0.min.js"></script>
    <script src="front/assets/js/popper.js"></script>
    <script src="front/assets/js/bootstrap.min.js"></script>
</body>

</html>