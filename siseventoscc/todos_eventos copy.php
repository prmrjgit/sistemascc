<?php
include 'conexao.php';
?>

<?php

// Realize a conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "siseventosccuser");

// Verifique se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o número máximo de eventos a serem exibidos por página
$eventosPorPagina = 25;

// Consulta SQL para recuperar o total de eventos cadastrados
$sqlTotalEventos = "SELECT COUNT(*) AS total FROM evento";
$resultTotalEventos = $conn->query($sqlTotalEventos);
$rowTotalEventos = $resultTotalEventos->fetch_assoc();
$totalEventos = $rowTotalEventos['total'];
// Define o número máximo de eventos a serem exibidos por página
$eventosPorPagina = 25;


// Calcula o número total de páginas com base no total de eventos e eventos por página
$totalPaginas = ceil($totalEventos / $eventosPorPagina);

// Verifica se o parâmetro 'page' está definido na URL
if (isset($_GET['page'])) {
    // Converte o valor do parâmetro 'page' para um número inteiro
    $currentPage = intval($_GET['page']);
} else {
    // Se o parâmetro 'page' não estiver definido, define a página atual como 1
    $currentPage = 1;
}

// Calcula o deslocamento (offset) com base na página atual
$offset = ($currentPage - 1) * $eventosPorPagina;

// Consulta SQL para recuperar os eventos limitados por página
$sql = "SELECT * FROM evento LIMIT $offset, $eventosPorPagina";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>

        
    /* Estilo da tabela de eventos *//*
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }*/

    /* Estilo dos botões *//*
    .alterar {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }

    .cancelar {
        background-color: #FF0000;
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }*/

    /* Estilo do botão para ir para a página de todos eventos *//*
    .ver-todos {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }*/

    /* Estilo da paginação *//*
    .pagination {
        margin-top: 20px;
        text-align: center;
    }

    .pagination a {
        display: inline-block;
        padding: 8px 16px;
        text-decoration: none;
        color: #000;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 5px;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }*/
</style>

</head>
<body>
    

<!-- Exibir a tabela de eventos -->
<section>
    <h2 style="text-align: center; padding: 8px; font-size: 60px;">Eventos Agendados</h2> 
    <button onclick="redirectToTodosEventos()" class="green-button"> Inicio</button>

    <script>
    function redirectToTodosEventos() {
    window.location.href = 'index.php';
    }
    </script>
</section>
<table class="table">
    <thead>
        <tr>
            <th>Informações do Evento</th>
            <th>Local</th>
            <th>Tipo</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Status</th>     
            <th>Ação</th>        
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['endereco']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                <td><?php echo substr($row["hora"], 0, 5); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <button class="alterar" onclick="alterarEvento(<?php echo $row['id']; ?>)">Alterar</button>
                    <button class="cancelar" onclick="cancelarEvento(<?php echo $row['id']; ?>)">Cancelar</button>
                </td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
      function alterarEvento(eventoId) {
        // Lógica para redirecionar para a página de alteração do evento com o ID fornecido
        window.location.href = "atualizar_evento.php?id=" + eventoId;
      }

      function cancelarEvento(eventoId) {
        // Lógica para redirecionar para a página de cancelamento do evento com o ID fornecido
        window.location.href = "cancelar_evento.php?id=" + eventoId;
      }
    </script>
    
<!-- Exibir a paginação -->

    <div class="pagination">
        <?php if ($totalPaginas > 1) { ?>
            <?php if ($currentPage > 1) { ?>
                <a href="todos_eventos.php?page=<?php echo ($currentPage - 1); ?>">Anterior</a>
            <?php } ?>
            
            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                <?php if ($i == $currentPage) { ?>
                    <span class="current-page"><?php echo $i; ?></span>
                <?php } else { ?>
                    <a href="todos_eventos.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php } ?>
            <?php } ?>
            
            <?php if ($currentPage < $totalPaginas) { ?>
                <a href="todos_eventos.php?page=<?php echo ($currentPage + 1); ?>">Próxima</a>
            <?php } ?>
        <?php } ?>
    </div>

</body>
</html>
