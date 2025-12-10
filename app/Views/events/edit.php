<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">

    <h1>✏️ Editar Evento: <?= esc($event['name'] ?? $event['title'] ?? 'Evento sem Título') ?></h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul class="alert alert-danger" style="list-style-type: none;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= url_to('Events::update', $event['id']) ?>" method="post">
        <?= csrf_field() ?>

        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label for="title" class="form-label">Título do Evento <span style="color:red;">*</span></label>
            <input type="text" id="title" name="title" class="form-control"
                value="<?= old('title', $event['name'] ?? $event['title'] ?? '') ?>" required>
            <?php if (session('errors.title')): ?><p class="error-message text-danger"><?= session('errors.title') ?></p><?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea id="description" name="description" class="form-control"><?= old('description', $event['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Data e Hora de Início <span style="color:red;">*</span></label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control"
                value="<?= old('start_time', $event['start_time']) ?>" required>
            <?php if (session('errors.start_time')): ?><p class="error-message text-danger"><?= session('errors.start_time') ?></p><?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Data e Hora de Fim</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                value="<?= old('end_time', $event['end_time'] ?? '') ?>">
            <?php if (session('errors.end_time')): ?><p class="error-message text-danger"><?= session('errors.end_time') ?></p><?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="pendente" <?= old('status', $event['status'] ?? '') == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="concluída" <?= old('status', $event['status'] ?? '') == 'concluída' ? 'selected' : '' ?>>Concluída</option>
                <option value="cancelada" <?= old('status', $event['status'] ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>


        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="<?= url_to('Events::show', $event['id']) ?>" class="btn btn-secondary">Cancelar e Voltar</a>
    </form>
</div>

<?= $this->endSection() ?>