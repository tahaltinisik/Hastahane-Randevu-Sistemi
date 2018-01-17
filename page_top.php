<!DOCTYPE html>
<!-- saved from url=(0065)https://www.w3schools.com/w3css/tryw3css_templates_analytics.htm# -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title><?php echo $pageTitle?> | E-Randevu</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./static/w3.css">
    <link rel="stylesheet" href="./static/css">
    <link rel="stylesheet" href="./static/font-awesome.min.css">
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
         input[type=text], input[type=date], input[type=time], input[type=password], select {
             width: 100%;
             padding: 12px 20px;
             margin: 8px 0;
             display: inline-block;
             border: 1px solid #ccc;
             border-radius: 4px;
             box-sizing: border-box;
         }

        input[type=submit], button {
            width: 40%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover, button:hover {
            background-color: #45a049;
        }
    </style>
</head><body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
    <span class="w3-bar-item w3-right"><a href=".">E-Randevu</a></span>
</div>

<?php if ($menuName!='') { ?>
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            <img src="./static/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
        </div>
        <div class="w3-col s8 w3-bar">
            <span>Hoşgeldin, <strong><?php echo $pageName?></strong></span><br>
            <a href="." class="w3-bar-item w3-button">Çıkış Yap</a>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Menü</h5>
    </div>
    <div class="w3-bar-block">
        <a href="https://www.w3schools.com/w3css/tryw3css_templates_analytics.htm#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
        <?php if ($menuName==='hasta') { ?>
        <a href="?sayfa=randevu_al" class="w3-bar-item w3-button w3-padding <?php if ($_GET['sayfa']==='randevu_al') echo 'w3-blue'?>">&nbsp; Randevu Al</a>
        <a href="?sayfa=randevuGecmisi" class="w3-bar-item w3-button w3-padding <?php if ($_GET['sayfa']==='randevuGecmisi') echo 'w3-blue'?>">&nbsp; Randevu Gecmisi</a>
        <?php } else if ($menuName==='doktor') {  ?>
            <a href="?sayfa=randevular" class="w3-bar-item w3-button w3-padding <?php if ($_GET['sayfa']==='randevular') echo 'w3-blue'?>">&nbsp; Bugünün Randevuları</a>
            <a href="?sayfa=randevuSaat" class="w3-bar-item w3-button w3-padding <?php if ($_GET['sayfa']==='randevuSaat') echo 'w3-blue'?>">&nbsp; Randevu Saat Düzenle</a>
            <a href="?sayfa=randevuGecmisi" class="w3-bar-item w3-button w3-padding <?php if ($_GET['sayfa']==='randevuGecmisi') echo 'w3-blue'?>">&nbsp; Randevu Geçmişi</a>
        <?php }?>
    </div>
</nav>
<?php }?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">