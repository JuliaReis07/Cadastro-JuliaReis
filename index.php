<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
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
      box-shadow: 0 4px 15px rgba(0,0,0,0.25);
      width: 100%;
      max-width: 400px;
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
      transition: background-color 0.2s;
    }
    button:hover {
      background-color: #6a3093;
    }
    .resultado {
      margin-top: 20px;
      padding: 12px;
      background: #f3e6fb;
      border-left: 4px solid #8e44ad;
      border-radius: 5px;
      color: #4b0082;
      font-size: 14px;
    }
  </style>

</head>
<body>

  <div class="container">
    <h1>Cadastro de Usuário - Julia Reis</h1>

    <form method="POST">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>

      <label for="telefone">Telefone:</label>
      <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>

      <button type="submit">Cadastrar</button>
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Recebe os dados enviados pelo formulário
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];

        // Mostra os dados recebidos
        echo "<div class='resultado'>";
        echo "Nome: " . $nome . "<br>";
        echo "E-mail: " . $email . "<br>";
        echo "Telefone: " . $telefone;
        echo "</div>";
    }
    ?>

  </div>

</body>
</html>
