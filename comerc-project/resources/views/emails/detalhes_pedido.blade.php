<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
</head>
<body>
    <h1>Detalhes do Pedido</h1>

    <p>Olá, {{ $detalhesPedido['cliente_nome'] }}!</p>

    <p>O seu pedido de número #{{ $detalhesPedido['pedido_id'] }} foi criado com sucesso.</p>
    <!-- Adicione outras informações relevantes do pedido aqui -->

    <p>Obrigado por escolher a nossa pastelaria!</p>
</body>
</html>