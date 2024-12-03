<?php 
session_start(); // Inicia la sessió per a emmagatzemar l'historial d'operacions

// Si la sol·licitud és de tipus GET (carregar o actualitzar la pàgina), es tanca la sessió
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_unset(); // Esborra totes les variables de sessió
    session_destroy(); // Destrueix la sessió
}

// Definir una constant per configurar el mètode del factorial (iteratiu o recursiu)
define('FACTORIAL_METHOD', 'iterative'); // Pots triar 'iterative' o 'recursive'

// Comprova si el formulari ha estat enviat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Operacions numèriques
    if (isset($_POST['inputField'])) {
        $inputField = isset($_POST['inputField']) ? $_POST['inputField'] : '';
        $resultat = '';

        // Comprovem la sintaxi de l'input
        if (preg_match('/^(\d+(\.\d+)?)([\+\-\*\/])(\d+(\.\d+)?)$/', $inputField, $matches)) {
            $num1 = (float)$matches[1];
            $operador = $matches[3];
            $num2 = (float)$matches[4];

            switch ($operador) {
                case '+':
                    $resultat = $num1 + $num2;
                    $operacio = "$num1 + $num2 = $resultat";
                    break;
                case '-':
                    $resultat = $num1 - $num2;
                    $operacio = "$num1 - $num2 = $resultat";
                    break;
                case '*':
                    $resultat = $num1 * $num2;
                    $operacio = "$num1 * $num2 = $resultat";
                    break;
                case '/':
                    if ($num2 != 0) {
                        $resultat = $num1 / $num2;
                        $operacio = "$num1 / $num2 = $resultat";
                    } else {
                        $resultat = 'Error: Divisió per zero!';
                        $operacio = $resultat;
                    }
                    break;
            }
        } elseif (preg_match('/^(\d+)(!?)$/', $inputField, $matches)) {
            $num1 = (int)$matches[1];
            $operacio = "Factorial($num1)";
            if ($matches[2] === '!') {
                if (FACTORIAL_METHOD === 'iterative') {
                    $resultat = factorial_iterative($num1);
                } else {
                    $resultat = factorial_recursive($num1);
                }
                $operacio .= " = $resultat";
            }
        } else {
            $resultat = 'Error: Operació no vàlida!';
            $operacio = $resultat;
        }

        // Guarda l'operació a l'historial de la sessió només si hi ha un resultat vàlid
        if (!empty($resultat) && $resultat !== 'Error: Operació no vàlida!' && $resultat !== 'Error: Divisió per zero!') {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacio;
        }

        // Mostra el resultat
        echo "<h2>Resultat: $resultat</h2>";
    }

    // Operacions amb strings
    if (isset($_POST['string1'])) {
        $string1 = $_POST['string1'];
        $string2 = isset($_POST['string2']) ? $_POST['string2'] : '';
        $operador = $_POST['operador'];
        $resultatString = '';

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

        // Guarda l'operació de strings a l'historial
        if (!empty($resultatString)) {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacioString;
        }

        // Mostra el resultat
        echo "<h2>Resultat: $resultatString</h2>";
    }
}

// Funció per calcular el factorial de manera recursiva
function factorial_recursive($n) {
    if ($n < 0) {
        return 'Error: El factorial no està definit per nombres negatius.';
    } elseif ($n == 0) {
        return 1;
    } else {
        return $n * factorial_recursive($n - 1);
    }
}

// Funció per calcular el factorial de manera iterativa
function factorial_iterative($n) {
    if ($n < 0) {
        return 'Error: El factorial no està definit per nombres negatius.';
    }
    $factorial = 1;
    for ($i = 1; $i <= $n; $i++) {
        $factorial *= $i;
    }
    return $factorial;
}

// Comprova si l'usuari vol tancar la sessió
if (isset($_POST['logout'])) {
    session_unset(); // Esborra totes les variables de sessió
    session_destroy(); // Destrueix la sessió
    echo "<h2>Has tancat la sessió. L'historial s'ha esborrat.</h2>";
}
?>