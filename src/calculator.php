<?php
session_start();

// Función para manejar las operaciones numéricas
function calcular($input) {
    if (preg_match('/^[0-9\+\-\*\/\.\!]+$/', $input)) {
        try {
            if (strpos($input, '!') !== false) {
                $input = rtrim($input, '!');
                return factorial(intval($input));
            } else {
                return eval("return $input;");
            }
        } catch (Exception $e) {
            return "Error";
        }
    } else {
        return "Input inválido";
    }
}

// Función para calcular el factorial
function factorial($num) {
    if ($num < 0) {
        return "Error: número negativo";
    } elseif ($num == 0 || $num == 1) {
        return 1;
    } else {
        $factorial = 1;
        for ($i = $num; $i >= 2; $i--) {
            $factorial *= $i;
        }
        return $factorial;
    }
}

// Función para manejar las operaciones con strings
function operarString($string1, $string2, $operador) {
    if ($operador == 'concat') {
        return $string1 . $string2;
    } elseif ($operador == 'remove') {
        return str_replace($string2, '', $string1);
    } else {
        return "Operador no válido";
    }
}

// Manejo de solicitudes POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['inputField'])) {
        $input = $_POST['inputField'];
        $resultat = calcular($input);

        if (!isset($_SESSION['historial'])) {
            $_SESSION['historial'] = [];
        }
        $_SESSION['historial'][] = "$input = $resultat";
        $_SESSION['ultimo_resultado'] = $resultat;
    }

    if (isset($_POST['string1'])) {
        $string1 = $_POST['string1'];
        $string2 = isset($_POST['string2']) ? $_POST['string2'] : '';
        $operador = $_POST['operador'];

        $resultatString = operarString($string1, $string2, $operador);

        $_SESSION['historial'][] = "$string1 $operador $string2 = $resultatString";
        $_SESSION['ultimo_resultado'] = $resultatString;
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>