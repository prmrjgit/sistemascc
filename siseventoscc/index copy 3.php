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
    $horaf = $_POST["horaf"];
    $status = $_POST["status"];

    // Preparando a consulta SQL para inserir o evento na tabela de eventos
    $sql = "INSERT INTO evento (nome, endereco, tipo, data, hora, horaf, status)
            VALUES ('$nome', '$endereco', '$tipo', '$data', '$hora', '$horaf', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Evento agendado com sucesso!";
    } else {
        echo "Erro ao agendar evento: " . $conn->error;
    }
}


$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * 10;

$sql = "SELECT * FROM evento WHERE status = 'ativo' ORDER BY data DESC LIMIT 22 OFFSET $offset";

    $result = $conn->query($sql);;
     
    $eventos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $evento = array(
            'title' => $row['nome'],
            'start' => $row['data'],
            'color' => $row['status'] === 'ativo' ? '#3788d8' : '#e74c3c'
        );

        $eventos[] = $evento;
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eventos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
   
   
    
        <!-- Arquivos da biblioteca date-fns -->
    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.23.0/dist/date-fns.min.js"></script>

    <!-- Arquivo do plugin de localização para português -->
    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.23.0/locale/pt-BR/index.js"></script>
      
      
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>




<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
       
      
        events: <?php echo json_encode($eventos); ?>
        
        
    });
    
    calendar.render();
});

    </script>


    <!--
<script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'pt-br',
    eventRender: function(info) {
      if (info.event.extendedProps.status === 'ativo') {
        info.el.classList.add('evento-ativo');
      }
    },
    // Outras configurações do calendário

    // Função para lidar com o clique em um evento
    eventClick: function(info) {
      // Redirecionar para a página do evento com base no ID do evento
      window.location.href = 'pagina_evento.php?id=' + info.event.id;
    }
  });

  calendar.render();
});

    </script>

  
  <script>




document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      
      events: <?php echo json_encode($eventos); ?>
      
  });
  
  calendar.render();
});

</script>


 
 <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        
        locale: 'pt-br',
        defaultView: 'month',
        eventSources: [
          {
            
            url: 'script_de_eventos.php', // Caminho para o script PHP que retorna os eventos do banco
            method: 'GET',
            extraParams: {
              status: 'ativo' // Parâmetro adicional para filtrar os eventos ativos no script PHP
            }, 
            failure: function() {
              alert('Erro ao carregar os eventos');
            },
            header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
            // Outras configurações do evento
          }
        ],
        
        eventRender: function(info) {
          
          info.el.classList.add('evento-ativo');
        },
        
        // Outras configurações do calendário
      });

      calendar.render();
    });
    
  </script>

  
  <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                locale: 'pt-br',
                events: 'script_de_eventos.php', // URL do script PHP que retorna os eventos
                eventRender: function(event, element) {
                    // Personalize a renderização do evento se necessário
                }
            });
        });
    </script>
 
 -->
</meta>
<body>

  <div class="container">
          <div class="img-logo" id="logo">
            <img src="imagens/logosuinf.jpg" alt="logosuinf">
          </div>
          
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
                      <option value="nomeacoes">Nomeações</option>
                      <option value="gabinetemilitar">Gabinete Militar</option>
                  </select>
              </div>
              <div>
                  <label for="data">Data do Evento:</label><br>
                  <input type="date" name="data" id="data" required>
              </div>
              <div>
                  <label for="hora">Inicio do Evento:</label><br>
                  <input type="time" name="hora" id="hora" required>
              </div>
              <div>
                  <label for="horaf">Fim do Evento:</label><br>
                  <input type="time" name="horaf" id="horaf" required>
              </div>
              <div>
                  <label for="status">Status do Evento:</label><br>
                  <select name="status" id="status">
                      <option value="ativo">Ativo</option>
                      <option value="cancelado">Cancelado</option>
                  </select>
              </div><br>
              <input class="btn-enviar" type="submit" value="Agendar Evento" id="enviar">
          </form> <br>

          <button onclick="redirectToTodosEventos()" class="green-button">Todos os Eventos</button>
  <!--
          
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
        --><section>
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
        echo "<td>" . substr($row["horaf"], 0, 5) . "</td>";
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
