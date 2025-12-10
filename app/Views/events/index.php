<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minha Agenda de Eventos</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        .actions-cell {
            width: 200px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>📅 Agenda de Eventos</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="color: green; background-color: #e6ffe6; padding: 10px; border: 1px solid green;"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <p style="color: red; background-color: #ffe6e6; padding: 10px; border: 1px solid red;"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <a href="<?= url_to('Events::new') ?>" class="btn btn-primary">➕ Novo Evento</a>

        <?php if (empty($events)): ?>
            <p>Nenhum evento encontrado. Adicione um novo!</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th class="actions-cell">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= esc($event['title']) ?></td>
                            <td><?= esc($event['start_time']) ?></td>
                            <td><?= esc($event['end_time']) ?></td>
                            <td class="actions-cell">
                                <a href="<?= url_to('Events::show', $event['id']) ?>" class="btn btn-info btn-sm">Ver</a>

                                <a href="<?= url_to('Events::edit', $event['id']) ?>" class="btn btn-primary btn-sm">Editar</a>

                                <form action="<?= url_to('Events::delete', $event['id']) ?>" method="post" style="display: inline-block;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este evento?');">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>