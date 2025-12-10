<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento: <?= esc($event['title']) ?></title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-item strong {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Detalhes do Evento: <?= esc($event['title']) ?></h1>

        <div class="detail-item">
            <strong>Título:</strong>
            <span><?= esc($event['title']) ?></span>
        </div>

        <div class="detail-item">
            <strong>Descrição:</strong>
            <span><?= esc($event['description']) ?: 'Nenhuma descrição fornecida.' ?></span>
        </div>

        <div class="detail-item">
            <strong>Início:</strong>
            <span><?= esc($event['start_time']) ?></span>
        </div>

        <div class="detail-item">
            <strong>Fim:</strong>
            <span><?= esc($event['end_time']) ?: 'Não especificado.' ?></span>
        </div>

        <div class="detail-item">
            <strong>Criado em:</strong>
            <span><?= esc($event['created_at']) ?></span>
        </div>

        <hr>

        <a href="<?= url_to('Events::index') ?>" class="btn btn-secondary">← Voltar à Lista</a>

        <a href="<?= url_to('Events::edit', $event['id']) ?>" class="btn btn-primary">✏️ Editar</a>

        <form action="<?= url_to('Events::delete', $event['id']) ?>" method="post" style="display: inline-block;">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este evento?');">🗑️ Excluir</button>
        </form>
    </div>

</body>

</html>