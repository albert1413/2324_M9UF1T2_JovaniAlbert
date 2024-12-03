<?php
include "calculator.php";
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

<div class="container mt-5">
    <h1 class="text-center">Calculadora</h1>

    <!-- Usamos una fila con dos columnas -->
    <div class="row">
        <!-- Columna para la calculadora -->
        <div class="col-md-6 order-md-1 order-1">
            <div class="calculator border rounded p-4 bg-light">
                <form id="calculator" action="" method="post">
                    <h3>Operacions numèriques</h3>
                    <input type="text" id="display" class="form-control mb-3" readonly>
                    <div id="buttons" class="d-grid gap-2">
                        <!-- Fila 1 -->
                        <div class="row">
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('1')">1</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('2')">2</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('3')">3</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('+')">+</button>
                            </div>
                        </div>
                        <!-- Fila 2 -->
                        <div class="row">
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('4')">4</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('5')">5</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('6')">6</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('-')">-</button>
                            </div>
                        </div>
                        <!-- Fila 3 -->
                        <div class="row">
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('7')">7</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('8')">8</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('9')">9</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('*')">*</button>
                            </div>
                        </div>
                        <!-- Fila 4 -->
                        <div class="row">
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="addToInput('0')">0</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('!')">!</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('.')">.</button>
                            </div>
                            <div class="col-3 col-md-3 mb-2">
                                <button type="button" class="btn btn-secondary btn-lg w-100" onclick="addToInput('/')">/</button>
                            </div>
                        </div>
                        <!-- Fila 5 -->
                        <div class="row">
                            <div class="col-12 mb-2">
                                <button type="button" class="btn btn-success btn-lg w-100" onclick="calculateResult()">=</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="inputField" name="inputField" value="">
                    <input type="submit" value="Calcular" style="display: none;">
                </form>
                <script>
                    function addToInput(value) {
                        const inputField = document.getElementById('inputField');
                        const display = document.getElementById('display');
                        inputField.value += value; // Añadir el valor al campo oculto
                        display.value += value; // Actualiza el campo de visualización
                    }

                    function calculateResult() {
                        document.getElementById('calculator').submit(); // Enviar el formulario para calcular
                    }
                </script>

                <form action="" method="post" class="mt-4">
                    <h3>Operacions amb strings</h3>
                    <div class="mb-3">
                        <label for="string1" class="form-label">String 1:</label>
                        <input type="text" id="string1" name="string1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="string2" class="form-label">String 2:</label>
                        <input type="text" id="string2" name="string2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="operador" class="form-label">Selecciona l'operació:</label>
                        <select id="operador" name="operador" class="form-select">
                            <option value="concat">Concatenar</option>
                            <option value="remove">Eliminar Substring</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Executar</button>
                </form>
            </div>
        </div>

        <!-- Columna para el historial de operaciones -->
        <div class="col-md-6 order-md-2 order-2">
            <div class="history border rounded p-4 bg-light">
                <form method="post" class="mb-3">
                    <input type="submit" name="logout" class="btn btn-danger w-100" value="Tancar sessió">
                </form>

                <h3>Historial de Operacions</h3>
                <ul class="list-group">
                    <?php
                    if (isset($_SESSION['historial']) && count($_SESSION['historial']) > 0) {
                        $historial_invertido = array_reverse($_SESSION['historial']);
                        foreach ($historial_invertido as $operacio) {
                            echo "<li class='list-group-item'>$operacio</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No hi ha operacions enregistrades.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function addToInput(value) {
        const inputField = document.getElementById('inputField');
        const display = document.getElementById('display');
        inputField.value += value;
        display.value += value;
    }

    function calculateResult() {
        document.getElementById('calculator').submit();
    }
</script>

</body>
</html>
