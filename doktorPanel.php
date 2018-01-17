<?php
include 'dbconnect.php';

$pageTitle = 'Doktor Paneli';
$pageName=$_SESSION['doktor_ad'];
$menuName = 'doktor';
include 'page_top.php';

$dipTesNo = $_SESSION['dipTesNo'];
$password = $_SESSION['doktorPassword'];

$sayfa = "";
if (isset($_GET["sayfa"]))
    $sayfa = $_GET["sayfa"];

if ($sayfa === 'randevular'){
    echo '<h2>BUGÜNÜN RANDEVULARI</h2>';
    $sql = "SELECT h.ADI as hADI, h.SOYADI as hSOYADI, TIME(r.TARIH_SAAT) AS SAAT FROM randevu AS r 
            INNER JOIN randevu_saat AS rs ON rs.RAN_SAAT_ID=r.RAN_SAAT_ID 
            INNER JOIN hasta AS h ON h.HASTA_TC=r.HASTA_TC 
            WHERE DATE(r.TARIH_SAAT) = CURDATE() AND r.DOKTOR_TESCIL=$dipTesNo and rs.DOKTOR_TESCIL=$dipTesNo
            ORDER BY r.TARIH_SAAT";

    $result = $connection->query($sql);
    echo '<table class="w3-table w3-striped w3-white">
                <tr>
                <th>ADI</th>
                <th>SOYADI</th>
                <th>RANDEVU SAATI</th>
                </tr>';

    if ($result === false || $result->num_rows > 0) {


        while ($row = $result->fetch_assoc()) {
            echo '<tr>
            <td>"'.$row['hADI'].'"</td>
            <td>"'.$row['hSOYADI'].'"</td>
            <td>"'.$row['SAAT'].'"</td>
            </form>
            </tr>';
        }
    }
    echo '</table>';

} else if ($sayfa === 'randevuSaat') {
    echo '<h2>RANDEVU SAAT DÜZENLE</h2>';
    $sql = "SELECT * FROM randevu_saat where DOKTOR_TESCIL=$dipTesNo ORDER BY BAS_SAATI";
    $result = $connection->query($sql);
    echo '<table class="w3-table w3-striped w3-white">
                <tr>
                <th>BASLANGIC SAATI</th>
                <th>BITIS SAATI</th>
                <th></th>
                </tr>
                <tr>
                <form method="post" action="?sayfa=randevuSaatEkle">
                <td><input type="time" name="bas" onchange="document.getElementById(\'bit_new\').setAttribute(\'min\',this.value)"></td>
                <td><input id="bit_new" type="time" name="bit"></td>
                <td><input type="submit" value="Ekle" /> </td>
                </form>
                </tr>';

    if ($result === false || $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
            <form method="post" action="?sayfa=randevuSaatDegistir">
            <input type="hidden" name="ran_saat_id" value="'.$row['RAN_SAAT_ID'].'"/>    
            <td><input type="time" name="bas" value="'.$row['BAS_SAATI'].'" onchange="document.getElementById(\'bit_'.$row['RAN_SAAT_ID'].'\').setAttribute(\'min\',this.value)"></td>
            <td><input id="bit_'.$row['RAN_SAAT_ID'].'" type="time" name="bit" min="'.$row['BAS_SAATI'].'" value="'.$row['BIT_SAATI'].'"></td>
            <td><input type="submit" value="Kaydet" /> <button type="button" onclick="window.location.href=\'?sayfa=randevuSaatSil&id='.$row['RAN_SAAT_ID'].'\'" > Sil</button> </td>
            </form>
            </tr>';
        }
    } else
        echo "randevu saatleri girilmemis..!";
    echo "</table>";


}else if($sayfa === "randevuSaatSil"){
    $ran_saat_id=$_GET["id"];
    $sql = "DELETE FROM randevu_saat WHERE RAN_SAAT_ID=$ran_saat_id";
    $result = $connection->query($sql);
    redirect("?sayfa=randevuSaat");
} else if($sayfa === "randevuSaatEkle"){
    $bas=$_POST["bas"];
    $bit=$_POST["bit"];
    $sql = "INSERT INTO randevu_saat (DOKTOR_TESCIL, BAS_SAATI,BIT_SAATI) VALUES ($dipTesNo,'$bas','$bit')";
    $result = $connection->query($sql);
    redirect("?sayfa=randevuSaat");
} else if ($sayfa === "randevuSaatDegistir") {
    $bas=$_POST["bas"];
    $bit=$_POST["bit"];
    $ran_saat_id=$_POST["ran_saat_id"];

    $sql = "UPDATE randevu_saat SET BAS_SAATI='$bas', BIT_SAATI='$bit' WHERE RAN_SAAT_ID=$ran_saat_id";
    $result = $connection->query($sql);
    redirect("?sayfa=randevuSaat");
} else if($sayfa === "randevuGecmisi") {
    echo '<h2>GECMIS RANDEVULAR</h2>';
    $sql = "SELECT h.ADI as hADI, h.SOYADI as hSOYADI, TIME(r.TARIH_SAAT) AS SAAT, r.TARIH_SAAT AS tarih FROM randevu AS r 
            INNER JOIN randevu_saat AS rs ON rs.RAN_SAAT_ID=r.RAN_SAAT_ID 
            INNER JOIN hasta AS h ON h.HASTA_TC=r.HASTA_TC 
            WHERE DATE(r.TARIH_SAAT) < CURDATE() AND r.DOKTOR_TESCIL=$dipTesNo and rs.DOKTOR_TESCIL=$dipTesNo
            ORDER BY r.TARIH_SAAT";

    $result = $connection->query($sql);
    echo '<table class="w3-table w3-striped w3-white">
                <tr>
                <th>ADI</th>
                <th>SOYADI</th>
                <th>RANDEVU TARIHI</th>
                </tr>';

    if ($result === false || $result->num_rows > 0) {


        while ($row = $result->fetch_assoc()) {
            echo '<tr>
            <td>"' . $row['hADI'] . '"</td>
            <td>"' . $row['hSOYADI'] . '"</td>
            <td>"' . $row['tarih'] . '"</td>
            </form>
            </tr>';
        }
    }
    echo '</table>';
}

include 'page_bottom.php';
?>
