<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encriptar y Desencriptar Datos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1> Encriptar y Desencriptar Datos</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
            <label for="dato">Ingrese un dato:</label>
            <input type="text" name="dato" id="dato">
            <div class="buttons">
                <button type="submit" name="incripta">Encriptar</button>
                <button type="submit" name="desencripta">Desencriptar</button>
            </div>
        </form>
        <div class="result">
            <?php
            function encrypt($data, $key)
            {
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
                return base64_encode($iv . $encrypted);
            }

            function decrypt($data, $key)
            {
                $data = base64_decode($data);
                $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
                $data = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
                return openssl_decrypt($data, 'aes-256-cbc', $key, 0, $iv);
            }

            // PHP para procesar el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $clave = "ClaveMaestra"; // Clave secreta para el cifrado simétrico

                if (isset($_POST["incripta"])) {
                    $dato = $_POST["dato"];
                    // Verifica si el campo de entrada no está vacío
                    if (!empty($dato)) {
                        $resultado = encrypt($dato, $clave);
                        echo "Resultado de la encriptación: " . $resultado;
                    } else {
                        echo "Error: El campo de entrada está vacío.";
                    }
                } elseif (isset($_POST["desencripta"])) {
                    $dato = $_POST["dato"];
                    // Verifica si el campo de entrada no está vacío
                    if (!empty($dato)) {
                        $resultado = decrypt($dato, $clave);
                        echo "Resultado de la desencriptación: " . $resultado;
                    } else {
                        echo "Error: El campo de entrada está vacío.";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>