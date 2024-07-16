<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    body {
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      width: 300px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container">
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            <span><?= session('success') ?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
            <span><?= session('error') ?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

  <div class="card">
    <h4 class="text-center mb-4">Iniciar sesión</h4>
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <form action="<?= site_url('login') ?>" method="POST">
      <div class="form-group">
        <label for="inputEmail">Correo electrónico</label>
        <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Ingresa tu correo electrónico" required autofocus>
      </div>
      <div class="form-group">
        <label for="inputPassword">Contraseña</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>
      </div>
      <button class="btn btn-primary btn-block mt-4" type="submit">Iniciar sesión</button>
    </form>
    <a class="mx-auto my-2" href="/forgot-password">Forgot Password?</a>
  </div>
</div>

  <?= $this->endSection() ?>