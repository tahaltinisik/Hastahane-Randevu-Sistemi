<?php
include 'dbconnect.php';

$pageTitle = 'Hasta Giriş';
$pageName='';
$menuName = '';
include 'page_top.php';

?>
<h2>HASTA GİRİŞİ</h2>
<div class="w3-third">
<form method="post" action="hastaGiris.php">
    <label for="hasta_tc">TC Kimlik No</label>
    <input type="text" name="hasta_tc" id="hasta_tc">

    <label for="password">Şifre</label>
    <input type="password" name="password"  id="password">

    <input type="submit" name="submit" value="Giris Yap">
    <button type="button" onclick="window.location.href='hastaKayit.php' ">Kayıt Ol</button>
    <p align="right"><a href="doktorGiris.php">Doktor Girişi</a></p>
</form>
</div>
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hasta_tc = $_POST["hasta_tc"];
        $password = $_POST["password"];


        $sql = "SELECT * FROM hasta WHERE HASTA_TC = '$hasta_tc' and SIFRE = '$password'";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            $connection->close();
            $_SESSION['hastaTc'] = $hasta_tc;
            $_SESSION['hastaPassword'] = $password;

            $_SESSION['hasta_ad'] = $result->fetch_assoc()['ADI'];
            redirect("hastaProfil.php");
        } else
            echo "<script> alert('kayit bulunamadi..!');</script>";
        $connection->close();
    }
include 'page_bottom.php';
?>

