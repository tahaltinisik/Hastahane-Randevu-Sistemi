<?php
include 'dbconnect.php';

$pageTitle = 'Doktor Giriş';
$pageName='';
$menuName = '';
include 'page_top.php';

?>
    <h2>DOKTOR GİRİŞİ</h2>
<div class="w3-third">
<form method="post" action="">
    <label for="dip_tes_no">Diploma Tescil No</label>
    <input type="text" name="dip_tes_no" id="dip_tes_no">

    <label for="password">Şifre</label>
    <input type="password" name="password" id="password">
    <input type="submit" name="submit" value="Giris Yap">
</form>
</div>
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dip_tes_no = $_POST["dip_tes_no"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM doktor WHERE DOKTOR_TESCIL = $dip_tes_no and SIFRE = '$password'";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            $connection->close();
            $_SESSION["dipTesNo"] = $dip_tes_no;
            $_SESSION["doktorPassword"] = $password;
            $_SESSION['doktor_ad'] = $result->fetch_assoc()['ADI'];
            redirect("doktorPanel.php?sayfa=randevular");
        } else
            echo "kayit bulunamadi..!";
        $connection->close();
    }
include 'page_bottom.php';
    ?>