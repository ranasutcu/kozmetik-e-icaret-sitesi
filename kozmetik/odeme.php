<html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme</title>
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

        .payment-form {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .payment-form label {
            display: block;
            margin-bottom: 10px;
        }

        .payment-form input[type="text"],
        .payment-form input[type="number"],
        .payment-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .payment-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .payment-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header>
	    <h1>Rana kozmetik</h1>
        <h2>Ödeme</h2>
        <div class="user-menu">
            <a href="index.php">Anasayfa</a>
        </div>
    </header>

    <div class="payment-form">
        <form id="paymentForm" action="" method="post">
            <label for="odeme_turu">Ödeme Türü Seçin:</label>
            <select name="odeme_turu" id="odeme_turu">
                <option value="secim_yapilmadi">Ödeme Türü Seçin</option>
                <option value="kartla">Kartla Ödeme</option>
                <option value="nakit">Nakit Ödeme</option>
            </select>

            <div id="kartla_odeme" style="display: none;">
                <label for="kart_numarasi">Kart Numarası:</label>
                <input type="text" id="kart_numarasi" name="kart_numarasi">

                <label for="kart_skt">Son Kullanma Tarihi:</label>
                <input type="text" id="kart_skt" name="kart_skt" placeholder="AA/YY">

                <label for="kart_cvv">CVV:</label>
                <input type="text" id="kart_cvv" name="kart_cvv">

                <div id="errorKartNumarasi" class="error-message" style="display: none;">
                    Lütfen geçerli bir kart numarası giriniz (16 haneli).
                </div>
            </div>

            <div id="nakit_odeme" style="display: none;">
                <p>Nakit ödeme seçtiniz. Ödemenizi teslim almak üzere bekliyor olacağız.</p>
            </div>

            <input type="submit" name="odeme_yap" value="Ödemeyi Tamamla">
        </form>

        <div id="successMessage" style="display: none; text-align: center; margin-top: 20px;">
            <p style="color: green; font-weight: bold;">Ödeme başarıyla tamamlandı!</p>
        </div>
    </div>

    <script>
        var odemeTuruSelect = document.getElementById('odeme_turu');
        var kartlaOdemeDiv = document.getElementById('kartla_odeme');
        var nakitOdemeDiv = document.getElementById('nakit_odeme');

        odemeTuruSelect.addEventListener('change', function() {
            if (this.value === 'kartla') {
                kartlaOdemeDiv.style.display = 'block';
                nakitOdemeDiv.style.display = 'none';
            } else if (this.value === 'nakit') {
                kartlaOdemeDiv.style.display = 'none';
                nakitOdemeDiv.style.display = 'block';
            }
        });

        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();

            if (odemeTuruSelect.value === 'kartla') {
                var kartNumarasiInput = document.getElementById('kart_numarasi');
                var kartNumarasiValue = kartNumarasiInput.value;

                if (kartNumarasiValue.length !== 16) {
                    document.getElementById('errorKartNumarasi').style.display = 'block';
                    return;
                } else {
                    document.getElementById('errorKartNumarasi').style.display = 'none';
                }
            }

            
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('paymentForm').reset();
            }, 1000);
        });
    </script>

</body>
</html>