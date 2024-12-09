<html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rana Kozmetik</title>
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

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
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

        #urunler {
            padding: 20px;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        
    </style>
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

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
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

        #urunler {
            padding: 20px;
            text-align: center;
        }

        #urunler img {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>RANA KOZMETİK</h1>
         <div class="container">

 <nav>
            <a href="urunler.php?category=parfum">Parfüm</a>
            <a href="urunler.php?category=makyaj">Makyaj Ürünleri</a>
            <a href="urunler.php?category=sac_bakim">Saç Bakım Ürünleri</a>
            <a href="urunler.php?category=cilt_bakim">Cilt Bakım Ürünleri</a>
        </nav>
        <div class="user-menu">
            <a href="kullanicikayit.php">Kullanıcı kayıt</a>
            <a href="login.php">Kullanıcı Girişi</a>
            <a href="adminlogin.php">Admin Girişi</a>
            <a href="sepet.php">Sepet</a> <br> <br>
            <a href="index.php">anasayfaya Geri Dön</a>
       
        </div>
		

    </header>

     
        <?php
		session_start();
        if (isset($_POST['gonder'])) {
            
            $baglan = mysqli_connect("localhost", "Rana", "", "proje");

            
            if (!$baglan) {
                die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
            }

            $kategori = mysqli_real_escape_string($baglan, $_POST['kategori']);
            $isim = mysqli_real_escape_string($baglan, $_POST['isim']);
            $fiyat = (float) $_POST['fiyat'];

         
            $uploads_dir = "uploads/"; 
            foreach ($_FILES['resim']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['resim']['name'][$key];
                $file_tmp = $_FILES['resim']['tmp_name'][$key];
                $file_type = $_FILES['resim']['type'][$key];
                
               
                $new_filename = uniqid() . '_' . $file_name;
                $upload_path = $uploads_dir . $new_filename;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                   
                    $insert_query = "INSERT INTO $kategori (isim, fiyat, resimurl) VALUES ('$isim', $fiyat, '$upload_path')";
                    $insert_result = mysqli_query($baglan, $insert_query);

                    if ($insert_result) {
                        echo "<p>Ürün bilgileri ve resim başarıyla yüklendi ve veritabanına kaydedildi.</p>";
                    } else {
                        echo "<p>Veritabanına kayıt eklenirken hata oluştu: " . mysqli_error($baglan) . "</p>";
                    }
                } else {
                    echo "<p>Resim yükleme işlemi başarısız oldu.</p>";
                }
            }

            mysqli_close($baglan);
        }
    ?>
	<div class="container">
 

        <div id="urunler">
		
            <?php
           
            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                switch ($category) {
                    case 'parfum':
                        $sorgu = "SELECT id, isim, fiyat, resimurl FROM parfumler";
                        break;
                    case 'makyaj':
                        $sorgu = "SELECT id, isim, fiyat, resimurl FROM makyaj";
                        break;
                    case 'sac_bakim':
                        $sorgu = "SELECT id, isim, fiyat, resimurl FROM sac";
                        break;
                    case 'cilt_bakim':
                        $sorgu = "SELECT id, isim, fiyat, resimurl FROM cilt";
                        break;
                    default:
                        $sorgu = "SELECT id, isim, fiyat, resimurl FROM urunler";
                        break;
                }

                $baglan = mysqli_connect("localhost", "Rana", "", "proje");

                
                if (!$baglan) {
                    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
                }

                $sonuc = mysqli_query($baglan, $sorgu);

while ($urun = mysqli_fetch_assoc($sonuc)) {
    echo '<div class="urun">';
    echo '<img src="' . $urun['resimurl'] . '" alt="' . $urun['isim'] . '">';
    echo '<p>' . $urun['isim'] . '</p>';
    echo '<p>Fiyat: ' . $urun['fiyat'] . ' TL</p>';
  
    echo '<form action="sepet.php" method="post">';
    echo '<input type="hidden" name="urun_id" value="' . $urun['id'] . '">';
    echo '<input type="submit" name="sepete_ekle" value="Sepete Ekle">';
    echo '</form>';
    echo '</div>';
}

                mysqli_close($baglan);
            }
            ?>
        </div>
    </div>
</body>
</html>
 