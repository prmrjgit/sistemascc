

<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verifica se todos os campos foram preenchidos
  if (isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["endereco"]) && isset($_POST["tipo"]) && isset($_POST["data"]) && isset($_POST["hora"]) && isset($_POST["status"])) {
    // Conecta ao banco de dados (substitua as credenciais de acordo com o seu ambiente)
    $conexao = new mysqli("localhost", "root", "", "siseventosccuser");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conexao->connect_error) {
      die("Erro de conexão: " . $conexao->connect_error);
    }

    // Obtém os valores do formulário
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $tipo = $_POST["tipo"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $status = $_POST["status"];

    // Atualiza o evento no banco de dados
    $sql = "UPDATE evento SET nome='$nome', endereco='$endereco', tipo='$tipo', data='$data', hora='$hora', status='$status' WHERE id=$id";

    if ($conexao->query($sql) === TRUE) {
      // Redireciona o usuário para a página principal após a atualização
      header("Location: index.php");
      exit;
    } else {
      echo "Erro ao atualizar o evento: " . $conexao->error;
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
  } 
} else {
  // Verifica se foi passado o parâmetro "id" na URL
  if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Conecta ao banco de dados (substitua as credenciais de acordo com o seu ambiente)
    $conexao = new mysqli("localhost", "root", "", "siseventosccuser");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conexao->connect_error) {
      die("Erro de conexão: " . $conexao->connect_error);
    }

    // Obtém os detalhes do evento a ser atualizado
    $sql = "SELECT * FROM evento WHERE id=$id";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
      $evento = $resultado->fetch_assoc();
      $nome = $evento["nome"];
      $endereco = $evento["endereco"];
      $tipo = $evento["tipo"];
      $data = $evento["data"];
      $hora = $evento["hora"];
      $status = $evento["status"];
    } else {
      echo "Evento não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
  }
}
/*
$sql = "SELECT * FROM eventos LIMIT 10 OFFSET $offset";

// Exemplo de código para a páginação
$totalEventos = $result->num_rows; // Total de eventos retornados pela consulta
$totalPaginas = ceil($totalEventos / 10); // Calcula o número total de páginas (considerando 10 eventos por página)

for ($i = 1; $i <= $totalPaginas; $i++) {
echo "<a href='index.php?page=$i'>$i</a> "; // Link para cada página
}
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * 10;*/
?>

