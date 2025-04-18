<?php
session_start();
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_empresa'])) {
    header("Location: index.html");
    exit();
}

include __DIR__ . '/db_connection.php';

// Buscar dados principais
$id_empresa = $_SESSION['id_empresa'];
$sql = "SELECT nome FROM empresas WHERE id_empresa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();
$empresa = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($empresa['nome']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1><?php echo htmlspecialchars($empresa['nome']); ?> - Dashboard</h1>
            <a href="logout.php" class="logout">Sair</a>
        </header>
        <main>
            <section class="cards">
                <div class="card">
                    <h3>Produtos em Estoque</h3>
                    <p>120</p>
                </div>
                <div class="card">
                    <h3>Movimentações Recentes</h3>
                    <p>35</p>
                </div>
                <div class="card">
                    <h3>Alertas Ativos</h3>
                    <p>5</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
