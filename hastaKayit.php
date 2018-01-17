<?php
include 'dbconnect.php';

$pageTitle = 'Hasta Kayıt';
$pageName='';
$menuName = '';
include 'page_top.php';

?>


<script>
    function kontrol() {
        var sifre = document.forms["name"]["password"].value;
        var sifre2 = document.forms["name"]["password2"].value;
        if(document.forms["name"]["hasta_tc"].value.length != 11 ){
            alert("TC Kimlik Numaranız 11 Haneli Olmalı!");
            return false;
        }
        else if(sifre != sifre2){
            alert("Şifreler Aynı Olmalı!");
            return false;
        }
        return true;
    }
</script>
<h2>HASTA KAYIT</h2>
<div class="w3-third">
<form name="name" method="post" action="hastaKayit.php" onsubmit="return kontrol()">
    <label for="hasta_tc">TC Kimlik No</label>
    <input type="text" name="hasta_tc" id="hasta_tc" required>

    <label for="hasta_tc">Ad</label>
    <input type="text" name="ad" id="ad" required>

    <label for="hasta_tc">Soyad</label>
    <input type="text" name="soyad" id="soyad" required>

    <label for="hasta_tc">E-Mail</label>
    <input type="text" name="e_mail" id="e_mail" required>

    <label for="hasta_tc">Şifre</label>
    <input type="password" name="password" id="password" placeholder="En az 6 karakter!" required>

    <label for="hasta_tc">Şifre Tekrar</label>
    <input type="password" name="password2" id="password2" placeholder="En az 6 karakter!" required>

    <input type="submit" name="submit" value="Kaydet">

</form>
</div>

<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $hasta_tc = $_POST["hasta_tc"];
        $ad = $_POST["ad"];
        $soyad = $_POST["soyad"];
        $e_mail = $_POST["e_mail"];
        $sifre = $_POST["password"];
        $sifre2 = $_POST["password2"];

        $sql = "INSERT INTO hasta (HASTA_TC, ADI, SOYADI, E_MAIL, SIFRE)
                VALUES ($hasta_tc, '$ad', '$soyad', '$e_mail', '$sifre')";

        if ($connection->query($sql) === TRUE) {
            $_SESSION['hastaTc'] = $hasta_tc;
            $_SESSION['hasta_ad'] = $ad;
            $_SESSION['hasta_soyad'] = $soyad;
            $_SESSION['mail'] = $e_mail;
            $_SESSION['hastaPassword'] = $sifre;
            echo "Kaydiniz tamamlandi";
            $connection->close();
            redirect("hastaProfil.php");
        }

        $connection->close();
    }

include 'page_bottom.php';
?>

