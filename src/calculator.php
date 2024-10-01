<?php
session_start(); // Inicia la sesión para almacenar el historial de operaciones

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_unset(); // Borra todas las variables de sesión
    session_destroy(); // Destruye la sesión
}

$resultat = '';
$resultatString = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['inputField'])) {
        $inputField = $_POST['inputField'];

        if (preg_match('/^(\d+)(!)$/', $inputField, $matches)) {
            // Cálculo de factorial
            $num = intval($matches[1]);
            $resultat = factorial($num);
            $operacio = "Factorial($num) = $resultat";
        } else {
            // Evaluar operaciones aritméticas
            $resultat = evaluateExpression($inputField);
            if ($resultat !== null) {
                $operacio = "$inputField = $resultat";
            } else {
                $resultat = 'Error: Operació no vàlida!';
                $operacio = $resultat;
            }
        }

        // Guardar el resultado incluso si es 0
        if ($resultat !== 'Error: Operació no vàlida!' && $resultat !== 'Error: Divisió per zero!') {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacio;
        }

        echo "<h2 id='resultDisplay' class='text-success'>Resultat: $resultat</h2>";
    }

    if (isset($_POST['string1'])) {
        $string1 = $_POST['string1'];
        $string2 = isset($_POST['string2']) ? $_POST['string2'] : '';
        $operador = $_POST['operador'];

        switch ($operador) {
            case 'concat':
                $resultatString = $string1 . $string2;
                $operacioString = "$string1 . $string2 = $resultatString";
                break;
            case 'remove':
                $resultatString = str_replace($string2, '', $string1);
                $operacioString = "Eliminar '$string2' de '$string1' = $resultatString";
                break;
        }

        if (!empty($resultatString)) {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacioString;
        }

        echo "<h2 id='resultStringDisplay' class='text-success'>Resultat: $resultatString</h2>";
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo "<h2 class='text-success'>Has tancat la sessió. L'historial s'ha esborrat.</h2>";
}

// Funciones auxiliares
function factorial($n) {
    if ($n < 0) return 'Error: El factorial no està definit per nombres negatius.';
    $result = 1;
    for ($i = 1; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

function evaluateExpression($inputField) {
    if (preg_match('/^(\d+(\.\d+)?)([\+\-\*\/])(\d+(\.\d+)?)$/', $inputField, $matches)) {
        $num1 = (float)$matches[1];
        $operador = $matches[3];
        $num2 = (float)$matches[4];

        switch ($operador) {
            case '+':
                return $num1 + $num2;
            case '-':
                return $num1 - $num2;
            case '*':
                return $num1 * $num2;
            case '/':
                if ($num2 != 0) {
                    return $num1 / $num2;
                } else {
                    return 'Error: Divisió per zero!';
                }
        }
    }
    return null; // Si la expresión no es válida
}
?>
