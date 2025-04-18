<?php
session_start();
if (!isset($_SESSION['empresas'])) {
    header("Location: index.html");
    exit();
}
$empresas = $_SESSION['empresas'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Empresa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background">
        <div class="login-container">
            <h2>Selecione sua Empresa</h2>
            <form action="dashboard.php" method="POST">
                <label for="empresa">Escolha a empresa:</label>
                <select id="empresa" name="empresa" required>
                    <?php foreach ($empresas as $empresa): ?>
                        <option value="<?php echo $empresa['id_empresa']; ?>">
                            <?php echo htmlspecialchars($empresa['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Acessar</button>
            </form>
        </div>
    </div>
</body>
</html>
