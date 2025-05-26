<?php
session_start();

$senha_correta = '0123569';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['senha']) && $_POST['senha'] === $senha_correta) {
        $_SESSION['autenticado'] = true;
    } else {
        $erro = "Senha incorreta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Projetos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
          font-family: "Segoe UI", sans-serif;
        }

        body {
          background-color: #f5f6fa;
          padding: 40px 20px;
          color: #2f3640;
        }

        h1 {
          text-align: center;
          margin-bottom: 40px;
          font-size: 2rem;
        }

        .grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 20px;
          max-width: 1000px;
          margin: 0 auto;
        }

        .card {
          background: #fff;
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
          text-align: center;
          padding: 20px;
          transition: transform 0.2s, box-shadow 0.2s;
          text-decoration: none;
          color: inherit;
        }

        .card:hover {
          transform: translateY(-5px);
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card svg {
          width: 80px;
          height: 80px;
          fill: #4cd137;
          margin-bottom: 15px;
        }

        .card span {
          display: block;
          font-size: 1.1rem;
          font-weight: 600;
        }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center bg-light">

<?php if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true): ?>
    <div class="card shadow p-4" style="min-width: 300px;">
        <h4 class="text-center mb-3">Acesso Restrito</h4>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="password" name="senha" class="form-control" placeholder="Digite a senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
<?php else: ?>
    <?php include 'projetos.php'; ?>
<?php endif; ?>

</body>
</html>
