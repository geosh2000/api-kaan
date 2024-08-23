<?= $this->extend('Layouts/Zendesk/main') ?>

<?= $this->section('styles') ?>
    .btn-cancel {
        background-color: #FF0000;
        color: white;
        border: 1px solid #FF0000;
    }
    .btn-incluNoData {
        background-color: #FFFFFF;
        color: black;
        border: 1px solid #CCCCCC;
    }
    .btn-incluSolicitado {
        background-color: #800080;
        color: white;
        border: 1px solid #800080;
    }
    .btn-ligaPendiente {
        background-color: #26d2c7;
        color: white;
        border: 1px solid #26d2c7;
    }
    .btn-pagoPendiente {
        background-color: #FFA500;
        color: white;
        border: 1px solid #FFA500;
    }
    .btn-pagadoSinIngresar {
        background-color: #FFFF00;
        color: black;
        border: 1px solid #FFFF00;
    }
    .btn-pagadoRegistradoAtpm {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }
    .btn-pagadoRegistradoOlcp {
        background-color: #87CEEB;
        color: white;
        border: 1px solid #87CEEB;
    }
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="content">
        <div class="d-flex justify-content-end mb-2">
            <button id='btn-preview' class="btn btn-primary mx-1">Preview</button>
            <button id='btn-send' class="btn btn-success mx-1">Send</button>
            <button id='btn-download' class="btn btn-info mx-1">Download PDF</button>
        </div>
    </div>
    <div id="preview"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

    $(document).ready(function () {

        const appTitle = document.getElementById('appTitle');
        appTitle.innerHTML = "GG - ADH Confirmations";

        // Event Listeners

        $('#btn-preview').click(function(){
            getConf();
        });

        function getConf(){
            startLoader();

            $.ajax({
                    url: 'http://localhost:8888/adhApi/zd/mailing/confHtml?',
                    method: 'GET',
                    success: function(data) {
                        $('#preview').html( data );
                        startLoader(false);
                    },
                    error: function() {
                        alert('Hubo un error al cargar los datos.');
                        startLoader(false);
                    }
                });
        }

        
        
    });
</script>
<?= $this->endSection() ?>