<?php
include 'conexao.php';
?>

<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siseventosccuser";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificando se o formulário foi enviado para cadastrar um evento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $tipo = $_POST["tipo"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $status = $_POST["status"];

    // Preparando a consulta SQL para inserir o evento na tabela de eventos
    $sql = "INSERT INTO evento (nome, endereco, tipo, data, hora, status)
            VALUES ('$nome', '$endereco', '$tipo', '$data', '$hora', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Evento agendado com sucesso!";
    } else {
        echo "Erro ao agendar evento: " . $conn->error;
    }
}


$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * 10;
$sql = "SELECT * FROM evento ORDER BY data DESC LIMIT 10 OFFSET $offset";
    $result = $conn->query($sql);;


?>



<!DOCTYPE html>
<html>
<meta>
<title>Eventos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">   
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
</meta>


<body>
<div class="container">
        <div class="img-logo"><img src="imagens/logosuinf.jpg" alt="logosuinf"></div>
        
        <div id='calendar'></div>

                <h1 class="titulo-agendamento">Agendamento de Eventos Casa Civil</h1>
        

        <form class="form-group" method="post" action="index.php">
            <div>
                <label for="nome">Informações do Evento:</label><br>
                <input placeholder="Digite as informações do evento" type="text" name="nome" id="nome" required>
            </div>
            <div>
                <label for="endereco">Local do Evento:</label><br>
                <input type="text" placeholder="Digite o local do evento" name="endereco" id="endereco" required>
            </div>
            <div>
                <label for="tipo">Tipo do Evento:</label><br>
                <select name="tipo" id="tipo">
                    <option value="reuniao">Reunião</option>
                    <option value="cerimonial">Cerimonial</option>
                    <option value="videoconferencia">Videoconferência</option>
                </select>
            </div>
            <div>
                <label for="data">Data do Evento:</label><br>
                <input type="date" name="data" id="data" required>
            </div>
            <div>
                <label for="hora">Hora do Evento:</label><br>
                <input type="time" name="hora" id="hora" required>
            </div>
            <div>
                <label for="status">Status do Evento:</label><br>
                <select name="status" id="status">
                    <option value="ativo">Ativo</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            <input class="btn-enviar" type="submit" value="Agendar Evento">
        </form>

        <section>
            <h2 class="eventos-agendados">Eventos Agendados</h2>
            <button onclick="redirectToTodosEventos()" class="green-button">Todos os Eventos</button>

            <table>
                <tr>
                    <th>Informaçãoes do Evento</th>
                    <th>Local</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
      <?php    

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

      echo "<tr>";
      echo "<td>" . $row["nome"] . "</td>";
      echo "<td>" . $row["endereco"] . "</td>";
      echo "<td>" . $row["tipo"] . "</td>";
      $data = date('d/m/Y', strtotime($row['data']));
      echo "<td>" . $data . "</td>";
      echo "<td>" . substr($row["hora"], 0, 5) . "</td>";
      echo "<td>" . $row["status"] . "</td>";
      echo "<td>";
      echo "<button class='alterar' onclick='alterarEvento(" . $row["id"] . ")'>Alterar</button>";
      echo "<button class='cancelar' onclick='cancelarEvento(" . $row["id"] . ")'>Cancelar</button>";
      echo "</td>";
      echo "</tr>";
  }
        
      
      ?>
    </table>
    <div class="pagination">
      <?php
    $totalEventos = $result->num_rows; // Total de eventos retornados pela consulta
      $totalPaginas = ceil($totalEventos / 10); // Calcula o número total de páginas (considerando 10 eventos por página)
    
      echo "<div class='pagination'>"; // Div para envolver os links de páginação
    
      if ($currentPage > $totalPaginas && $totalPaginas > 0) {
        header("Location: index.php?page=$totalPaginas");
        exit;
      }
    
      echo "</div>"; // Fechamento da div da paginação
    }  else {
      echo "<tr><td colspan='7'>Nenhum evento encontrado.</td></tr>";
  }
    ?>
    </div>
    </section>
</div>
    <script>
        function redirectToTodosEventos() {
            window.location.href = 'todos_eventos.php';
        }

        function alterarEvento(eventoId) {
            window.location.href = "atualizar_evento.php?id=" + eventoId;
        }

        function cancelarEvento(eventoId) {
            window.location.href = "cancelar_evento.php?id=" + eventoId;
        }
    </script>
</body>
</html>
