<!-- CARGA LAYOUT DEL DASHBOARD DE CIO -->
<?= $this->extend('layouts/cio-dashboard') ?>

<!-- CONTENIDO PRINCIPAL -->
<?= $this->section('content') ?>

<style>
    .mainWindow {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .quote {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
</style>

<div class="mainWindow">
    <div class="container">
        <div class="quote">
            "Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do." - Steve Jobs
        </div>
    </div>
</div>

<?= $this->endSection() ?>