<html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background: #ffb6c1;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .user-menu {
            position: absolute;
            right: 10px;
            top: 10px;
        }

        .user-menu a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }

        #sepet {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .urun {
            background: #fff;
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            width: 200px;
            text-align: center;
        }

        .kontrol-btn {
            text-align: center;
            margin-top: 20px;
        }

        .kontrol-btn input[type="submit"] {
            font-size: 18px; /* Butonun yazı boyutunu büyüt */
            padding: 10px 20px; /* Butonun iç boşluğunu artır */
        }
    </style>
</head>
<body>
    <header>
	    <h1>Rana kozmetik</h1>
        <h2>Sepetiniz</h2>
        <div class="user-menu">
            <a href="index.php">anasayfaya Geri Dön</a>
        </div>
    </header>

    <div id="sepet">
        <?php
        session_start(); 

        if (isset($_SESSION['sepet']) && !empty($_SESSION['sepet'])) {
        
            $baglan = mysqli_connect("localhost", "Rana", "", "proje");

            if (!$baglan) {
                die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
            }

           
            $sepet_urunler = implode(',', $_SESSION['sepet']);
            $sorgu = "SELECT id, isim, fiyat FROM urunler WHERE id IN ($sepet_urunler)";
            $sonuc = mysqli_query($baglan, $sorgu);

         
            while ($urun = mysqli_fetch_assoc($sonuc)) {
                echo '<div class="urun">';
                echo '<p>' . $urun['isim'] . '</p>';
                echo '<p>Fiyat: ' . $urun['fiyat'] . ' TL</p>';
                echo '</div>';
            }

          
            mysqli_close($baglan);
        } else {
           
        }
		  
        ?>
    </div>

    <div class="kontrol-btn">
        <form action="odeme.php" method="post">
            <input type="submit" name="kontrol" value="Sepeti onayla">
        </form>
    </div>

</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['urun_id'])) {
        $urun_id = $_POST['urun_id'];

       
        if (!isset($_SESSION['sepet'])) {
            $_SESSION['sepet'] = array();
        }

        if (!in_array($urun_id, $_SESSION['sepet'])) {
            $_SESSION['sepet'][] = $urun_id;
        }
    }

   
    if (isset($_POST['sil_urun_id'])) {
        $sil_urun_id = $_POST['sil_urun_id'];

        if (($key = array_search($sil_urun_id, $_SESSION['sepet'])) !== false) {
            unset($_SESSION['sepet'][$key]);

            $_SESSION['sepet'] = array_values($_SESSION['sepet']);
        }
    }
}


if (isset($_SESSION['sepet']) && count($_SESSION['sepet']) > 0) {
    echo "Sepetiniz:<br>";
    foreach ($_SESSION['sepet'] as $urun) {
        echo "Ürün ID: " . $urun;
        echo "<form action='sepet.php' method='POST' style='display:inline;'>
                <input type='hidden' name='sil_urun_id' value='" . $urun . "'>
                <button type='submit'>Sil</button>
              </form><br>";
    }
} else {
    echo "Sepetiniz boş.";
}
?>