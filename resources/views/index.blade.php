<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
        }
        .container {
            margin-top: 150px;
        }
        .btn-nova-venda {
            font-size: 1.2rem;
            padding: 10px 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4">Bem-vindo ao Sistema de Vendas</h1>
        <p class="mb-5">Clique abaixo para iniciar uma nova venda:</p>
        <form action="{{ route('vendas') }}" method="get">
        <button type="submit">Nova Venda</button>
    </form>
    </div>
</body>
</html>
