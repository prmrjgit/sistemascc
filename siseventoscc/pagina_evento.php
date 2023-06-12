<?php



// Verificar se o ID do evento está presente na URL
if (isset($_GET['id'])) {
    // Obter o ID do evento da URL
    $eventoId = $_GET['id'];

    // Aqui você pode adicionar o código necessário para recuperar as informações completas do evento com base no ID
    // Isso pode envolver uma consulta ao banco de dados ou qualquer outra lógica necessária

    // Exemplo de informações do evento
    $nomeEvento = "Nome do Evento";
    $enderecoEvento = "Endereço do Evento";
    $tipoEvento = "Tipo do Evento";
    $dataEvento = "Data do Evento";
    $horaEvento = "Hora do Evento";
    $statusEvento = "Status do Evento";

    // Exibir as informações do evento
    echo "<h1>Detalhes do Evento</h1>";
    echo "<p><strong>Nome:</strong> " . $nomeEvento . "</p>";
    echo "<p><strong>Endereço:</strong> " . $enderecoEvento . "</p>";
    echo "<p><strong>Tipo:</strong> " . $tipoEvento . "</p>";
    echo "<p><strong>Data:</strong> " . $dataEvento . "</p>";
    echo "<p><strong>Hora:</strong> " . $horaEvento . "</p>";
    echo "<p><strong>Status:</strong> " . $statusEvento . "</p>";
} else {
    echo "ID do evento não encontrado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
    // Verificar se a variável de sucesso está presente na URL
    var urlParams = new URLSearchParams(window.location.search);
    var success = urlParams.get('success');

    // Se a variável de sucesso for igual a 1, exibir o popup de sucesso
    if (success == 1) {
        alert('Evento criado com sucesso!');
    }
</script>

</body>
</html>
