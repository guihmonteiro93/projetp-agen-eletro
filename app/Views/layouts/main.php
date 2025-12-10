<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Eventos | CodeIgniter 4</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />

    <style>
        /* Estilos básicos para o footer e corpo */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex-grow: 1;
        }

        footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        /* Estilos para diferenciar os status dos eventos no calendário (FullCalendar) */
        .event-completed {
            background-color: #28a745 !important;
            border-color: #1e7e34;
        }

        /* Verde */
        .event-cancelled {
            background-color: #dc3545 !important;
            border-color: #bd2130;
        }

        /* Vermelho */
        .event-pending {
            background-color: #007bff !important;
            border-color: #0056b3;
        }

        /* Azul */
        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('events') ?>">🗓️ Minha Agenda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Olá, <?= esc(session()->get('login')) ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url_to('Events::index') ?>">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-danger btn-sm" href="<?= url_to('logout') ?>">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url_to('register') ?>">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-success btn-sm" href="<?= url_to('login') ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <?= $this->renderSection('content') ?>
    </div>

    <footer>
        <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Agenda de Eventos | Desenvolvido com CodeIgniter 4</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales-all.global.min.js'></script>
</body>

</html>