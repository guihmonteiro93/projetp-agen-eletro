<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🗓️ Agenda de Eventos (Visualização em Calendário)</h2>
        <a href="<?= url_to('events_new') ?>" class="btn btn-primary">
            Novo Evento
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
    <?php endif; ?>

    <div id='calendar'></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Configurações Básicas
            initialView: 'dayGridMonth', // Visualização inicial (mês)
            locale: 'pt-br', // Usa a tradução em português

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // Opções de visualização
            },

            // Configuração de Eventos
            // O FullCalendar faz uma requisição GET automática para esta URL, que retorna o JSON
            events: '<?= base_url('events/json') ?>',

            // Interações
            eventClick: function(info) {
                // Ao clicar, redireciona para a página de detalhes do evento (rota /events/{id})
                if (info.event.url) {
                    window.location.href = info.event.url;
                    return false; // Previne o comportamento padrão do navegador
                }
            },

            // Opções de Data e Hora
            timeZone: 'local',
            editable: false, // Desabilita edição por arrastar
            navLinks: true, // Permite clicar nos nomes dos dias/semanas
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            }
        });

        // Renderiza o calendário na tela
        calendar.render();
    });
</script>

<?= $this->endSection() ?>