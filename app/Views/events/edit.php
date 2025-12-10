<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Evento: <?= esc($event['title']) ?></title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        .btn {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>✏️ Editar Evento: <?= esc($event['title']) ?></h1>

        <?php if (session()->getFlashdata('errors')): ?>
            <ul style="color: red; padding: 10px; border: 1px solid red; list-style-type: none;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="<?= url_to('Events::update', $event['id']) ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="_method" value="PUT">

            <div>
                <label for="title">Título do Evento <span style="color:red;">*</span></label>
                <input type="text" id="title" name="title" value="<?= old('title', $event['title']) ?>" required>
            </div>

            <div>
                <label for="description">Descrição</label>
                <textarea id="description" name="description"><?= old('description', $event['description']) ?></textarea>
            </div>

            <div>
                <label for="start_time">Data e Hora de Início <span style="color:red;">*</span></label>
                <input type="datetime-local" id="start_time" name="start_time" value="<?= old('start_time', $event['start_time']) ?>" required>
            </div>

            <div>
                <label for="end_time">Data e Hora de Fim</label>
                <input type="datetime-local" id="end_time" name="end_time" value="<?= old('end_time', $event['end_time']) ?>">
            </div>

            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="<?= url_to('Events::show', $event['id']) ?>" class="btn btn-secondary">Cancelar e Voltar</a>
        </form>
    </div>

</body>

</html>