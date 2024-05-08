<!DOCTYPE html>
<html lang="en">

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
            // Función para encriptar datos
            function encrypt($string, $key)
            {
                $result = '';
                for ($i = 0; $i < strlen($string); $i++) {
                    $char = substr($string, $i, 1);
                    $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                    $char = chr(ord($char) + ord($keychar));
                    $result .= $char;
                }
                return base64_encode($result);
            }

            // Función para desencriptar datos
            function decrypt($string, $key)
            {
                $result = '';
                $string = base64_decode($string);
                for ($i = 0; $i < strlen($string); $i++) {
                    $char = substr($string, $i, 1);
                    $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                    $char = chr(ord($char) - ord($keychar));
                    $result .= $char;
                }
                return $result;
            }

            // PHP para procesar el formulario
            // PHP para procesar el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $clave = "ClaveMaestra";

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