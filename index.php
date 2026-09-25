<?php
$mensagem = "";
$sucesso = false;

$nome = "";
$email = "";
$telefone = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

    if ($nome === "" || $telefone === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Preencha todos os campos com dados válidos.";
    } else {
        try {
            $databaseUrl = getenv("DATABASE_URL");

            if (!$databaseUrl) {
                throw new RuntimeException("DATABASE_URL não configurada.");
            }

            $partes = parse_url($databaseUrl);

            if (
                $partes === false ||
                !isset($partes["host"], $partes["path"], $partes["user"], $partes["pass"])
            ) {
                throw new RuntimeException("DATABASE_URL inválida.");
            }

            $host = $partes["host"];
            $porta = $partes["port"] ?? 5432;
            $banco = ltrim($partes["path"], "/");
            $usuario = rawurldecode($partes["user"]);
            $senha = rawurldecode($partes["pass"]);

            $dsn = "pgsql:host=$host;port=$porta;dbname=$banco;sslmode=require";

            $pdo = new PDO($dsn, $usuario, $senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $sql = "INSERT INTO usuarios (nome, email, telefone)
                    VALUES (:nome, :email, :telefone)";

            $comando = $pdo->prepare($sql);

            $comando->execute([
                ":nome" => $nome,
                ":email" => $email,
                ":telefone" => $telefone
            ]);

            $mensagem = "Usuário cadastrado com sucesso!";
            $sucesso = true;

            $nome = "";
            $email = "";
            $telefone = "";
        } catch (Throwable $erro) {
            error_log($erro->getMessage());
            $mensagem = "Não foi possível cadastrar o usuário. Verifique a conexão e a tabela.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Julia Reis</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a3093, #a044ff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #4b0082;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #6a3093;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #c9a3e8;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #8e44ad;
            box-shadow: 0 0 4px rgba(142, 68, 173, 0.5);
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background-color: #8e44ad;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6a3093;
        }

        .resultado {
            margin-top: 20px;
            padding: 12px;
            border-radius: 5px;
            font-size: 14px;
        }

        .sucesso {
            background: #e6f6e9;
            color: #17652b;
            border-left: 4px solid #249443;
        }

        .erro {
            background: #fdeaea;
            color: #9b2222;
            border-left: 4px solid #cf3333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cadastro de Usuário - Julia Reis</h1>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input
                type="text"
                id="nome"
                name="nome"
                value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="email">E-mail:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="telefone">Telefone:</label>
            <input
                type="tel"
                id="telefone"
                name="telefone"
                placeholder="(00) 00000-0000"
                value="<?= htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <button type="submit">Cadastrar</button>
        </form>

        <?php if ($mensagem !== ""): ?>
            <div class="resultado <?= $sucesso ? 'sucesso' : 'erro' ?>">
                <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>