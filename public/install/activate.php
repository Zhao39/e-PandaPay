<?php
$response = "";
if ($_POST['license']) {
    $username = $_POST['username'];
    $license = $_POST['license'];
    $website = $_SERVER['HTTP_HOST'];

    $post = [
        'license' => $license,
        'website' => $website,
        'username' => $username,
    ];

    $url = 'https://app.getonlinetrader.pro/api/v1/save-license';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $vrfy_lic = curl_exec($curl);
    curl_close($curl);
    $vrfy_lic = json_decode($vrfy_lic);

    if ($vrfy_lic->error) {
        $response = "<h4 class='text-center text-danger'>" . $vrfy_lic->message . '</h4>';
    } elseif (is_null($vrfy_lic)) {
        $response = "<h4 class='text-center text-danger'>License not found</h4>";
    } else {
        $response =  "<h4 class='text-center text-success'>" . $vrfy_lic->message . "</h4>
                          <a class='button is-warning' href='?action=config&lic=$license'>Next Step 
                            <i class='fa fa-angle-double-right'></i>
                          </a>
                          ";
    }
}
?>
<div class="step-installer first-installer second-installer third-installer">
    <center class="installer-header">
        <h3>Software activation</h3>
    </center>
    <div class="installer-content">
        <form action="?action=activate" method="post">
            <h5>Envato username</h5>
            <input class="form-control" name="username" value="<?php echo $username; ?>" type="text" required><br>
            <input class="form-control input-lg" name="license" placeholder="Enter your purchase code" type="text"
                required="">
            <br>
            <button class="btn btn-success" type="submit">Activate and proceed</button>
        </form>
        <?php echo $response; ?>
    </div>
</div>