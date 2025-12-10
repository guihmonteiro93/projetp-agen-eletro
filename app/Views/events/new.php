<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2>📝 Criar Novo Evento</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="eventForm" action="<?= base_url('events') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="title" class="form-label">Título do Evento <span style="color:red;">*</span></label>
            <input type="text" id="title" name="title" class="form-control" value="<?= old('title') ?>" required>
            <?php if (session('errors.title')): ?><p class="error-message text-danger"><?= session('errors.title') ?></p><?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea id="description" name="description" class="form-control"><?= old('description') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Data e Hora de Início <span style="color:red;">*</span></label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control date-input"
                value="<?= old('start_time') ? date('Y-m-d\TH:i', strtotime(old('start_time'))) : '' ?>" required>
            <?php if (session('errors.start_time')): ?><p class="error-message text-danger"><?= session('errors.start_time') ?></p><?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Data e Hora de Fim</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control date-input"
                value="<?= old('end_time') ? date('Y-m-d\TH:i', strtotime(old('end_time'))) : '' ?>">
            <?php if (session('errors.end_time')): ?><p class="error-message text-danger"><?= session('errors.end_time') ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Salvar Evento</button>
        <a href="<?= base_url('events') ?>" class="btn btn-secondary">Cancelar e Voltar</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            const dateInputs = document.querySelectorAll('.date-input');

            dateInputs.forEach(input => {
                const value = input.value;
                if (value) {
                    // Formata YYYY-MM-DDTHH:MM para YYYY-MM-DD HH:MM:SS
                    let formattedValue = value.replace('T', ' ');
                    if (formattedValue.split(':').length === 2) {
                        formattedValue += ':00';
                    }
                    input.value = formattedValue;
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>