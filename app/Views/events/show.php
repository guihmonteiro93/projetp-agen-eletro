<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento: <?= esc($event['name'] ?? $event['title'] ?? 'Evento sem Título') ?></title>
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
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        p {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
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
        <h1>Detalhes do Evento: <?= esc($event['name'] ?? $event['title']) ?></h1>

        <p><span class="info-label">ID:</span> <?= esc($event['id']) ?></p>

        <p><span class="info-label">Descrição:</span> <?= nl2br(esc($event['description'] ?? 'Sem descrição.')) ?></p>

        <p><span class="info-label">Início:</span> <?= esc($event['start_time']) ?></p>

        <p><span class="info-label">Fim:</span> <?= esc($event['end_time'] ?? 'Não definido') ?></p>

        <p><span class="info-label">Status:</span> <?= esc($event['status'] ?? 'Não definido') ?></p>

        <p><span class="info-label">Criado em:</span> <?= esc($event['created_at']) ?></p>

        <p><span class="info-label">Atualizado em:</span> <?= esc($event['updated_at']) ?></p>

        <hr>

        <a href="<?= url_to('Events::edit', $event['id']) ?>" class="btn btn-primary">Editar</a>

        <form action="<?= url_to('Events::delete', $event['id']) ?>" method="post" style="display: inline-block;">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este evento?');">Excluir</button>
        </form>

        <a href="<?= url_to('Events::index') ?>" class="btn btn-secondary" style="margin-left: 10px;">Voltar para Agenda</a>
    </div>
</body>

</html>