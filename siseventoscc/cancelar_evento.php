<?php
include 'conexao.php';
?>

<?php
// Verifica se o ID do evento foi fornecido na URL
if (isset($_GET["id"])) {
  $id = $_GET["id"];

  // Conecta ao banco de dados (substitua as credenciais de acordo com o seu ambiente)
  $conexao = new mysqli("localhost", "root", "", "siseventosccuser");

  // Verifica se a conexão foi estabelecida com sucesso
  if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
  }

  // Atualiza o status do evento para "cancelado"
  $sql = "UPDATE evento SET status='Cancelado' WHERE id=$id";

  if ($conexao->query($sql) === TRUE) {
    // Redireciona o usuário para a página principal após a atualização
    header("Location: todos_eventos.php");
    exit;
  } else {
    echo "Erro ao cancelar o evento: " . $conexao->error;
  }

  // Fecha a conexão com o banco de dados
  $conexao->close();
}
?>
