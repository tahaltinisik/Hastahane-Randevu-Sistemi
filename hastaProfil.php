<?php
    include 'dbconnect.php';

    $pageTitle = 'Hasta Profili';
    $pageName=$_SESSION['hasta_ad'];
    $menuName = 'hasta';
    include 'page_top.php';

    $hasta_tc = $_SESSION['hastaTc'];
    $hastaPassword = $_SESSION['hastaPassword'];


$sayfa = "";
if (isset($_GET["sayfa"]))
    $sayfa = $_GET["sayfa"];

if($sayfa === 'randevu_al'){
    echo '<h2>RANDEVU AL</h2> <div class="w3-twothird"> ';
    $sql = "SELECT HASTAHANE_ID , ADI FROM hastahane";
    $result = $connection->query($sql);
    $hastahane_id = 0;
    $hastahane_setted = isset($_GET["hastahane_id"]);
    if ($hastahane_setted)
        $hastahane_id = $_GET["hastahane_id"];

    echo'<br><select id="hastahane" onchange="window.location.href=\'?sayfa=randevu_al&hastahane_id=\'+document.getElementById(\'hastahane\').value " >
        <option disabled ';

    if(!$hastahane_setted)
        echo'selected';

    echo' value> Hastahane Seçiniz </option>';

    while($row=$result->fetch_assoc()){
            echo'<option ';
            if($hastahane_setted && $row['HASTAHANE_ID'] === $hastahane_id)
                echo'selected';
             echo' value="'.$row['HASTAHANE_ID'].'">'.$row['ADI'].'</option>';
    }
    echo '</select>';

    if($hastahane_setted){
        $sql = "SELECT BOLUM_ID , ADI FROM bolum WHERE HASTAHANE_ID=$hastahane_id";
        $result = $connection->query($sql);

        $bolum_id = 0;
        $bolum_setted = isset($_GET["bolum_id"]);
        if ($bolum_setted)
            $bolum_id = $_GET["bolum_id"];

        echo' <br><select id="bolum" onchange="window.location.href=\'?sayfa=randevu_al&hastahane_id='.$hastahane_id.'&bolum_id=\'+document.getElementById(\'bolum\').value " >
              <option disabled ';

        if(!$bolum_setted)
            echo'selected';

        echo' value> Bölüm Seçiniz </option>';

        while($row=$result->fetch_assoc()){
            echo'<option ';
            if($bolum_setted && $row['BOLUM_ID'] === $bolum_id)
                echo'selected';
            echo' value="'.$row['BOLUM_ID'].'">'.$row['ADI'].'</option>';
        }
        echo '</select>';

        if ($bolum_setted){

            $sql = "SELECT DOKTOR_TESCIL , ADI FROM doktor WHERE BOLUM_ID=$bolum_id";
            $result = $connection->query($sql);


            $doktor_id = 0;
            $doktor_setted = isset($_GET["doktor_id"]);
            if ($doktor_setted)
                $doktor_id = $_GET["doktor_id"];

            echo' <br><select id="doktor" onchange="window.location.href=\'?sayfa=randevu_al&hastahane_id='.$hastahane_id.'&bolum_id='.$bolum_id.'&doktor_id=\'+document.getElementById(\'doktor\').value " >
              <option disabled ';

            if(!$doktor_setted)
                echo'selected';

            echo' value> Doktor  Seçiniz  </option>';

            while($row=$result->fetch_assoc()){
                echo'<option ';
                if($doktor_setted && $row['DOKTOR_TESCIL'] === $doktor_id)
                    echo'selected';
                echo' value="'.$row['DOKTOR_TESCIL'].'">'.$row['ADI'].'</option>';
            }
            echo '</select>';

            if ($doktor_setted){
                $tarih="";
                $tarih_setted = isset($_GET["tarih"]);
                if ($tarih_setted)
                    $tarih= $_GET["tarih"];
                echo '<br><input id="tarih" type="date" min="'.date("Y-m-d").'" value="'.$tarih.'"  onchange="window.location.href=\'?sayfa=randevu_al&hastahane_id='.$hastahane_id.'&bolum_id='.$bolum_id.'&doktor_id='.$doktor_id.'&tarih=\'+document.getElementById(\'tarih\').value " >';
                if($tarih_setted){
                    $sql = "SELECT RAN_SAAT_ID , BAS_SAATI , BIT_SAATI, IF((SELECT COUNT(*) FROM randevu as r WHERE DATE(r.TARIH_SAAT)='$tarih' AND r.RAN_SAAT_ID=rs.RAN_SAAT_ID)>0,1,0) as DOLU FROM randevu_saat AS rs  WHERE DOKTOR_TESCIL=$doktor_id AND TIMESTAMP ('$tarih', rs.BAS_SAATI) > NOW()  ORDER BY  BAS_SAATI";
                    $result = $connection->query($sql);
                    echo '<div class="numberlist"><ol>';
                    while($row=$result->fetch_assoc()){
                        echo '<li>';
                        if($row['DOLU']==0){
                            echo '<a href="?sayfa=randevu_sec&doktor_id='.$doktor_id.'&ran_id='.$row['RAN_SAAT_ID'].'&tarih='.$tarih.' '.$row['BAS_SAATI'].'">';
                        } else echo '<span>';
                        echo $row['BAS_SAATI'].'-'.$row['BIT_SAATI'];
                        if($row['DOLU']==0) {
                            echo '</a>';
                        } else {
                            echo '(Dolu)</span>';
                        }
                        echo '</li>';
                    }
                    echo '</ol></div>';
                }
            }
        }
    }
    echo '</div>';
} else if ($sayfa === 'randevu_sec'){
    $sql = "INSERT INTO randevu (HASTA_TC,RAN_SAAT_ID,DOKTOR_TESCIL,TARIH_SAAT) VALUES (".$_SESSION['hastaTc'].",".$_GET['ran_id']." , ".$_GET['doktor_id']." , '".$_GET['tarih']."')";
    echo "<script>alert('Randevunuz alınmıştır!');</script>";
    $result = $connection->query($sql);
    redirect('?sayfa=randevuGecmisi');
} else if ($sayfa === 'randevuGecmisi'){
    $sql = "SELECT hstn.ADI as hADI,b.ADI as bADI,d.ADI as dADI,r.TARIH_SAAT as rTS 
            FROM randevu AS r INNER JOIN randevu_saat AS rs ON rs.RAN_SAAT_ID=r.RAN_SAAT_ID  
            INNER JOIN hasta AS h ON h.HASTA_TC=r.HASTA_TC
            INNER JOIN doktor AS d ON d.DOKTOR_TESCIL=r.DOKTOR_TESCIL
            INNER JOIN bolum AS b ON b.BOLUM_ID=d.BOLUM_ID
            INNER JOIN hastahane  as hstn ON hstn.HASTAHANE_ID=b.HASTAHANE_ID 
            WHERE h.HASTA_TC=$hasta_tc and r.HASTA_TC=$hasta_tc and DATE(r.TARIH_SAAT) < CURDATE() 
            ORDER BY rTS";
    $result = $connection->query($sql);
   echo '<h2>GECMIS RANDEVULAR</h2>';
    if ($result->num_rows > 0) {
        echo "<table class='w3-table w3-striped w3-white'>";
        echo "<tr>
                <th>HASTAHANE</th>
                <th>BOLUM</th>
                <th>DOKTOR</th>
                <th>TARIH SAATI</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
           echo "<td>'".$row['hADI']."'</td>";
           echo "<td>'".$row['bADI']."'</td>";
           echo "<td>'".$row['dADI']."'</td>";
           echo "<td>'".$row['rTS']."'</td>";
        }

    } echo "</table>";


    $sql = "SELECT hstn.ADI as hADI,b.ADI as bADI,d.ADI as dADI,r.TARIH_SAAT as rTS 
            FROM randevu AS r INNER JOIN randevu_saat AS rs ON rs.RAN_SAAT_ID=r.RAN_SAAT_ID  
            INNER JOIN hasta AS h ON h.HASTA_TC=r.HASTA_TC
            INNER JOIN doktor AS d ON d.DOKTOR_TESCIL=r.DOKTOR_TESCIL
            INNER JOIN bolum AS b ON b.BOLUM_ID=d.BOLUM_ID
            INNER JOIN hastahane  as hstn ON hstn.HASTAHANE_ID=b.HASTAHANE_ID 
            WHERE h.HASTA_TC=$hasta_tc and r.HASTA_TC=$hasta_tc and DATE(r.TARIH_SAAT) >= CURDATE() 
            ORDER BY rTS";
    $result = $connection->query($sql);
    echo '<h2>GELECEK RANDEVULAR</h2>';
    if ($result->num_rows > 0) {
        echo "<table class='w3-table w3-striped w3-white'>";
        echo "<tr>
                <th>HASTAHANE</th>
                <th>BOLUM</th>
                <th>DOKTOR</th>
                <th>TARIH SAATI</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>'".$row['hADI']."'</td>";
            echo "<td>'".$row['bADI']."'</td>";
            echo "<td>'".$row['dADI']."'</td>";
            echo "<td>'".$row['rTS']."'</td>";
        }

    } echo "</table>";
} else {
    redirect('?sayfa=randevuGecmisi');
}

include 'page_bottom.php';
?>

<style>

    /* css list with numeber circle background -------------- */
    .numberlist{
        width:450px;
        padding-left: 20px;
    }
    .numberlist ol{
        counter-reset: li;
        list-style: none;
        *list-style: decimal;
        font: 15px 'trebuchet MS', 'lucida sans';
        padding: 0;
        margin-bottom: 4em;

    }
    .numberlist ol ol{
        margin: 0 0 0 2em;
    }

    .numberlist a{
        position: relative;
        display: block;
        padding: .4em .4em .4em 2em;
        *padding: .4em;
        margin: .5em 0;
        background: #FFF;
        color: #444;
        text-decoration: none;
        -moz-border-radius: .3em;
        -webkit-border-radius: .3em;
        border-radius: .3em;
    }

    .numberlist a:hover{
        background: #cbe7f8;
        text-decoration:underline;
    }
    .numberlist a:before{
        content: counter(li);
        counter-increment: li;
        position: absolute;
        left: -1.3em;
        top: 50%;
        margin-top: -1.3em;
        background: #87ceeb;
        height: 2em;
        width: 2em;
        line-height: 2em;
        border: .3em solid #fff;
        text-align: center;
        font-weight: bold;
        -moz-border-radius: 2em;
        -webkit-border-radius: 2em;
        border-radius: 2em;
        color:#FFF;
    }

    .numberlist span{
        position: relative;
        display: block;
        padding: .4em .4em .4em 2em;
        *padding: .4em;
        margin: .5em 0;
        background: #FFF;
        color: #444;
        text-decoration: none;
        -moz-border-radius: .3em;
        -webkit-border-radius: .3em;
        border-radius: .3em;
    }

    .numberlist span:hover{
        background: #cbe7f8;
        text-decoration:underline;
    }
    .numberlist span:before{
        content: counter(li);
        counter-increment: li;
        position: absolute;
        left: -1.3em;
        top: 50%;
        margin-top: -1.3em;
        background: #87ceeb;
        height: 2em;
        width: 2em;
        line-height: 2em;
        border: .3em solid #fff;
        text-align: center;
        font-weight: bold;
        -moz-border-radius: 2em;
        -webkit-border-radius: 2em;
        border-radius: 2em;
        color:#FFF;
    }

    /* End css list with numeber circle background -------------- */

</style>
