<!--
<?php
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atualizar Evento</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Atualizar Evento</h1>
    <form action="atualizar_evento.php" method="POST">
      <div class="form-group">
        <label for="nome">Informações do Evento:</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="form-group">
        <label for="endereco">Endereço do Evento:</label>
        <input type="text" id="endereco" name="endereco" required>
      </div>
      <div class="form-group">
        <label for="tipo">Tipo do Evento:</label>
        <select id="tipo" name="tipo" required>
          <option value="">Selecione</option>
          <option value="Reunião">Reunião</option>
          <option value="Cerimonial">Cerimonial</option>
          <option value="Videoconferência">Videoconferência</option>
        </select>
      </div>
      <div class="form-group">
        <label for="data">Data do Evento:</label>
        <input type="date" id="data" name="data" required>
      </div>
      <div class="form-group">
        <label for="hora">Hora do Evento:</label>
        <input type="time" id="hora" name="hora" required>
      </div>
      <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" required>
          <option value="">Selecione</option>
          <option value="Ativo">Ativo</option>
          <option value="Cancelado">Cancelado</option>          
        </select>
      </div>
      <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Atualizar</button>
      </div>
    </form>
  </div>
</body>
</html>
-->