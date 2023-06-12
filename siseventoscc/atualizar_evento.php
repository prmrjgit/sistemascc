<?php
include 'conexao.php';
?>


<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verifica se todos os campos foram preenchidos
  if (isset($_POST["nome"]) && isset($_POST["endereco"]) && isset($_POST["tipo"]) && isset($_POST["data"]) && isset($_POST["hora"]) && isset($_POST["horaf"]) && isset($_POST["status"])) {
    // Conecta ao banco de dados (substitua as credenciais de acordo com o seu ambiente)
    $conexao = new mysqli("localhost", "root", "", "siseventosccuser");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conexao->connect_error) {
      die("Erro de conexão: " . $conexao->connect_error);
    }

    // Obtém os valores do formulário
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $tipo = $_POST["tipo"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $horaf = $_POST["horaf"];
    $status = $_POST["status"];

// Verifica se o evento já existe no banco de dados
    $sql = "SELECT id FROM evento WHERE nome='$nome' AND endereco='$endereco' AND tipo='$tipo' AND data='$data' AND hora='$hora' AND hora='$horaf'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
      echo "Este evento já está cadastrado.";
    } else {
      // Insere o evento no banco de dados
      $sql = "INSERT INTO evento (nome, endereco, tipo, data, hora, horaf, status) VALUES ('$nome', '$endereco', '$tipo', '$data', '$hora', '$horaf', '$status')";

      if ($conexao->query($sql) === TRUE) {
        // Redireciona o usuário para a página principal após o cadastro
        header("Location: atualizar_evento.php");
        exit;
      } else {
        echo "Erro ao cadastrar o evento: " . $conexao->error;
      }
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
  } else {
    echo "Todos os campos devem ser preenchidos.";
  }
}
?>



<!DOCTYPE html>
<html>
<head>
  <title>Atualizar Evento</title>
  <style>
    /* Estilos de exemplo, substitua-os pelo seu CSS personalizado */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
    }

    .container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="time"],
    .form-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 15px;
    }

    .btn-cancelar {
      background-color: #f44336;
      display: inline-block;
      padding: 10px 20px;      
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      cursor: pointer;
        }

  </style>
</head>
<body>
  <div class="container">
    <h2>Atualizar Evento</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="form-group">
        <label for="nome">Informações do Evento:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $nome; ?>">
      </div>
      <div class="form-group">
        <label for="endereco">Local do Evento:</label>
        <input type="text" name="endereco" id="endereco" value="<?php echo $endereco; ?>">
      </div>
      <div class="form-group">
        <label for="tipo">Tipo do Evento:</label>
        <select name="tipo" id="tipo">
          <option value="Reunião" <?php if ($tipo == "Reunião") echo "selected"; ?>>Reunião</option>
          <option value="Cerimonial" <?php if ($tipo == "Cerimonial") echo "selected"; ?>>Cerimonial</option>
          <option value="Videoconferência" <?php if ($tipo == "Videoconferencia") echo "selected"; ?>>Videoconferência</option>
          <option value="Nomeações"<?php if ($tipo == "Nomeacoes") echo "selected"; ?>>Nomeações</option>
          <option value="Gabinete Militar" <?php if ($tipo == "Gabinetemilitar") echo "selected"; ?>>Gabinete Militar</option>
        </select>
      </div>
      <div class="form-group">
        <label for="data">Data do Evento:</label>
        <input type="date" name="data" id="data" value="<?php echo $data; ?>">
      </div>
      <div class="form-group">
        <label for="hora">Inicio do Evento:</label>
        <input type="time" name="hora" id="hora" value="<?php echo $hora; ?>">
      </div>
      <div class="form-group">
        <label for="horaf">Final do Evento:</label>
        <input type="time" name="horaf" id="horaf" value="<?php echo $horaf; ?>">
      </div>
      <label for="status">Status:</label>
        <select name="status" id="status">
          <option value="" <?php if ($tipo == "Selecione") echo "selected"; ?>>Selecione</option>
          <option value="Ativo" <?php if ($tipo == "Ativo") echo "selected"; ?>>Ativo</option>
          <option value="Cancelado" <?php if ($tipo == "Cancelado") echo "selected"; ?>>Cancelado</option>
        </select>
      <button type="submit" class="btn">Atualizar</button> 
      
      <?php  
    echo "<a href='todos_eventos.php' class='btn-cancelar'>Cancelar</a>";
    echo "</form>";
      ?>
    </form>
  </div>
  
</body>
</html>

