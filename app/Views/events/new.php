<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Novo Evento</title>
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
        <h1>📝 Criar Novo Evento</h1>

        <?php if (session()->getFlashdata('errors')): ?>
            <ul style="color: red; padding: 10px; border: 1px solid red; list-style-type: none;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form id="eventForm" action="<?= url_to('Events::create') ?>" method="post">
            <?= csrf_field() ?>

            <div>
                <label for="title">Título do Evento <span style="color:red;">*</span></label>
                <input type="text" id="title" name="title" value="<?= old('title') ?>" required>
                <?php if (session('errors.title')): ?><p class="error-message"><?= session('errors.title') ?></p><?php endif; ?>
            </div>

            <div>
                <label for="description">Descrição</label>
                <textarea id="description" name="description"><?= old('description') ?></textarea>
            </div>

            <div>
                <label for="start_time">Data e Hora de Início <span style="color:red;">*</span></label>
                <input type="datetime-local" id="start_time" name="start_time" class="date-input"
                    value="<?= old('start_time') ? date('Y-m-d\TH:i', strtotime(old('start_time'))) : '' ?>" required>
                <?php if (session('errors.start_time')): ?><p class="error-message"><?= session('errors.start_time') ?></p><?php endif; ?>
            </div>

            <div>
                <label for="end_time">Data e Hora de Fim</label>
                <input type="datetime-local" id="end_time" name="end_time" class="date-input"
                    value="<?= old('end_time') ? date('Y-m-d\TH:i', strtotime(old('end_time'))) : '' ?>">
                <?php if (session('errors.end_time')): ?><p class="error-message"><?= session('errors.end_time') ?></p><?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success">Salvar Evento</button>
            <a href="<?= url_to('Events::index') ?>" class="btn btn-secondary">Cancelar e Voltar</a>
        </form>
    </div>

    <script>
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            const dateInputs = document.querySelectorAll('.date-input');

            dateInputs.forEach(input => {
                const value = input.value;

                if (value) {
                    // 1. O valor enviado pelo input datetime-local (via seletor) é YYYY-MM-DDTHH:MM.
                    // 2. Trocamos o 'T' por espaço e adicionamos segundos para o formato do BD (YYYY-MM-DD HH:MM:SS).
                    let formattedValue = value.replace('T', ' ');

                    if (formattedValue.split(':').length === 2) {
                        formattedValue += ':00';
                    }

                    // Define o novo valor formatado que será lido pelo Controller.
                    input.value = formattedValue;
                }
            });
            // O formulário é enviado.
        });
    </script>

</body>

</html>