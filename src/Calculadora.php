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

<div class="container mt-4">
    <h1 class="text-center">Calculadora</h1>

    <!-- Formulari operacions numèriques -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <form id="calculator" action="" method="post">
                <h3 class="text-center">Operacions numèriques</h3>
                <div class="input-group mb-3">
                    <input type="text" id="display" class="form-control text-end" readonly placeholder="0">
                </div>

                <div class="d-grid gap-2">
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('1')">1</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('2')">2</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('3')">3</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('+')">+</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('4')">4</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('5')">5</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('6')">6</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('-')">-</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('7')">7</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('8')">8</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('9')">9</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('*')">*</button></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><button type="button" class="btn btn-outline-primary" onclick="addToInput('0')">0</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('/')">/</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('!')">!</button></div>
                        <div class="col-3"><button type="button" class="btn btn-outline-warning" onclick="addToInput('.')">.</button></div>
                        <div class="col-12"><button type="submit" class="btn btn-success w-100">=</button></div>
                    </div>
                </div>
                <input type="hidden" id="inputField" name="inputField" value="">
            </form>
        </div>
    </div>

    <!-- Formulari operacions amb strings -->
    <div class="row mt-4 justify-content-center">
        <div class="col-12 col-md-6">
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

    <!-- Botó tancar sessió -->
    <div class="row mt-4 justify-content-center">
        <div class="col-12 col-md-6">
            <form method="post">
                <button type="submit" name="logout" class="btn btn-danger w-100">Tancar sessió</button>
            </form>
        </div>
    </div>

    <!-- Historial d'operacions -->
    <div class="row mt-4 justify-content-center">
        <div class="col-12 col-md-6">
            <h3 class="text-center">Historial de Operacions</h3>
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

<script>
    function addToInput(value) {
        var display = document.getElementById('display');
        var inputField = document.getElementById('inputField');

        display.value += value;
        inputField.value = display.value;
    }

    function clearInput() {
        var display = document.getElementById('display');
        var inputField = document.getElementById('inputField');

        display.value = '';
        inputField.value = '';
    }

    document.getElementById('calculator').onsubmit = function() {
        var display = document.getElementById('display');
        var inputField = document.getElementById('inputField');
        
        inputField.value = display.value;
    }
</script>

</body>
</html>
