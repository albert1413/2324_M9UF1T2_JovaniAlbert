<?php
session_start(); // Inicia la sesión para almacenar el historial de operaciones

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_unset(); // Borra todas las variables de sesión
    session_destroy(); // Destruye la sesión
}

define('FACTORIAL_METHOD', 'iterative');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['inputField'])) {
        $inputField = isset($_POST['inputField']) ? $_POST['inputField'] : '';
        $resultat = '';

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

        // Guardar el resultado incluso si es 0
        if ($resultat !== 'Error: Operació no vàlida!' && $resultat !== 'Error: Divisió per zero!') {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacio;
        }

        echo "<h2 class='text-success'>Resultat: $resultat</h2>";
    }

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

        if (!empty($resultatString)) {
            if (!isset($_SESSION['historial'])) {
                $_SESSION['historial'] = [];
            }
            $_SESSION['historial'][] = $operacioString;
        }

        echo "<h2 class='text-success'>Resultat: $resultatString</h2>";
    }
}

function factorial_recursive($n) {
    if ($n < 0) {
        return 'Error: El factorial no està definit per nombres negatius.';
    } elseif ($n == 0) {
        return 1;
    } else {
        return $n * factorial_recursive($n - 1);
    }
}

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

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo "<h2 class='text-success'>Has tancat la sessió. L'historial s'ha esborrat.</h2>";
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora Mòbil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">Calculadora</h1>

    <!-- Formulario para operaciones numéricas -->
    <div class="row">
        <div class="col-12">
            <form id="calculator" action="" method="post">
                <h3 class="text-center">Operacions numèriques</h3>
                <div class="input-group mb-3">
                    <input type="text" id="display" class="form-control" readonly placeholder="0">
                </div>

                <div class="d-grid gap-2">
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('1')">1</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('2')">2</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('3')">3</button></div>
                        <div class="col-3"><button type="button" class="btn btn-warning" onclick="addToInput('+')">+</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('4')">4</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('5')">5</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('6')">6</button></div>
                        <div class="col-3"><button type="button" class="btn btn-warning" onclick="addToInput('-')">-</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('7')">7</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('8')">8</button></div>
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('9')">9</button></div>
                        <div class="col-3"><button type="button" class="btn btn-warning" onclick="addToInput('*')">*</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-primary" onclick="addToInput('0')">0</button></div>
                        <div class="col-3"><button type="button" class="btn btn-warning" onclick="addToInput('/')">/</button></div>
                        <div class="col-3"><button type="button" class="btn btn-warning" onclick="addToInput('!')">!</button></div>
                        <div class="col-3"><button type="button" class="btn btn-danger" onclick="calculateResult()">=</button></div>
                    </div>
                </div>
                <input type="hidden" id="inputField" name="inputField" value="">
            </form>
        </div>
    </div>

    <!-- Formulario para operaciones con strings -->
    <div class="row mt-4">
        <div class="col-12">
            <form action="" method="post">
                <h3 class="text-center">Operacions amb strings</h3>
                <div class="mb-3">
                    <input type="text" id="string1" name="string1" class="form-control" placeholder="String 1" required>
                </div>
                <div class="mb-3">
                    <input type="text" id="string2" name="string2" class="form-control" placeholder="String 2 (opcional)">
                </div>
                <div class="mb-3">
                    <select id="operador" name="operador" class="form-select">
                        <option value="concat">Concatenar</option>
                        <option value="remove">Eliminar Substring</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Executar</button>
            </form>
        </div>
    </div>
    <!-- Botón para cerrar sesión -->
    <div class="row mt-4">
        <div class="col-12">
            <form method="post">
                <button type="submit" name="logout" class="btn btn-danger w-100">Tancar sessió</button>
            </form>
        </div>
    </div>

    <!-- Historial de operaciones -->
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="text-center">Historial de Operacions</h3>
                <ul>
                <?php
                if (isset($_SESSION['historial']) && count($_SESSION['historial']) > 0) {
                    // Invertir el orden del historial para mostrar las operaciones más recientes primero
                    $historial_invertido = array_reverse($_SESSION['historial']);
                    foreach ($historial_invertido as $operacio) {
                        echo "<li>$operacio</li>";
                    }
                } else {
                    echo "<li>No hi ha operacions enregistrades.</li>";
                }
                ?>
</ul>
        </div>
    </div>

    
</div>

<script>
    function addToInput(value) {
        const inputField = document.getElementById('inputField');
        const display = document.getElementById('display');
        inputField.value += value;
        display.value = inputField.value;
    }

    function calculateResult() {
        document.getElementById('calculator').submit();
    }
</script>

</body>
</html>
