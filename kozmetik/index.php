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
        }

        #urunler img {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>RANA KOZMETİK</h1>
        <nav>
            <a href="urunler.php?category=parfum">Parfüm</a>
            <a href="urunler.php?category=makyaj">Makyaj Ürünleri</a>
            <a href="urunler.php?category=sacBakim">Saç Bakım Ürünleri</a>
            <a href="urunler.php?category=ciltBbakim">Cilt Bakım Ürünleri</a>
        </nav>
        <div class="user-menu">
            <a href="kullanicikayit.php">Kullanıcı kayıt</a>
            <a href="login.php">Kullanıcı Girişi</a>
            <a href="adminlogin.php">Admin Girişi</a>
            <a href="sepet.php">Sepet</a>
        </div>
		
    </header>

    <section id="urunler">
   
        <div>
        <?php
        $baglan = mysqli_connect("localhost", "Rana", "", "proje");

      
        $sorgu = mysqli_query($baglan, "SELECT resimurl FROM resimal");
        while($satir = mysqli_fetch_assoc($sorgu)) {
            $resim_url = $satir['resimurl'];
          
            echo "<img src='$resim_url'>";
        }
        mysqli_close($baglan);
        ?>
        </div>

        </form>
    </section>

    <?php
   
    if(isset($_POST["gonder"])){
        $baglan = mysqli_connect("localhost", "Rana", "", "proje");
        foreach($_FILES["resim"]["tmp_name"] as $key => $tmp_name){
            
            if($_FILES["resim"]["size"][$key] < 800*800){
               
                if($_FILES["resim"]["type"][$key] == "image/jpeg"){
                   
                    $dosya_adi = $_FILES["resim"]["name"][$key];
                    $isim = array("yt", "ut", "yy", "op", "hf");
                    $sayi = rand(0, 1000);
                    $uzanti = substr($dosya_adi, -4, 4);
                    $yeni_ad = "resimler/".$isim[rand(0, 4)].$sayi.$uzanti;

                   
              if(move_uploaded_file($_FILES["resim"]["tmp_name"][$key], $yeni_ad)){
                   echo "Kaydetme başarılı<br>";
                        $ekle = mysqli_query($baglan, "INSERT INTO resimal (resimurl) VALUES ('$yeni_ad')");
                        if($ekle)
                            echo "Veritabanına eklendi";
                        else
                            echo "Veritabanına ekleme yapılamadı.";
                    }
                    else
                        echo "Dosya sunucuya taşınamadı.";
                }
                else{   
                    echo "Sadece .jpeg uzantılı dosyalarda işlem yapılabilir.";
                }
            }
            else {  
                echo "Dosya en fazla 1 MB olabilir. Kontrollerinizi yapın.";
            }
        }
        mysqli_close($baglan);
    }
    ?>
</body>
</html>






