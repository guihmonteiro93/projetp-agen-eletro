<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cadastro de Usuário</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?= form_open('register') ?>

                    <div class="mb-3">
                        <label for="login" class="form-label">Login (Nome de Usuário)</label>
                        <input type="text"
                            name="login"
                            id="login"
                            class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>"
                            value="<?= old('login') ?>"
                            required>
                        <?php if (session('errors.login')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                            required>
                        <?php if (session('errors.password')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="pass_confirm" class="form-label">Confirmar Senha</label>
                        <input type="password"
                            name="pass_confirm"
                            id="pass_confirm"
                            class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>"
                            required>
                        <?php if (session('errors.pass_confirm')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.pass_confirm') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </div>

                    <?= form_close() ?>

                    <hr>
                    <p class="text-center">
                        Já tem conta? <a href="<?= url_to('login') ?>">Faça Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>