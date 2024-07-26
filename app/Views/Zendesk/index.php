<?= $this->extend('Layouts/Zendesk/main') ?>

<?= $this->section('content') ?>
    <div class="container">
        <div class="d-flex justify-content-end">
            <p>Usuario: <span id="$user"></span></p>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        console.log("Index grupo de funciones ready");

        var getFields = [
            "ticket",
            "currentUser",
            'ticket.customField:custom_field_26495291237524', // Categoria
            'ticket.customField:custom_field_26260741418644', // Reserva
        ];
        
        
        // ZAF METHODS
        var client = ZAFClient.init();
        client.get(getFields).then(function(data) {
            setUser(data.currentUser.name);
            loadInstance( data.ticket.form.id );
        });

        function setUser( user ){
            const userDiv = document.getElementById('$user');
            userDiv.innerHTML = user;
        }

        function loadInstance( form ){
            var ins = ''
            switch( form ){
              case 26597917087124:
                redirectToPost('/zdapp/transpo');
                  break;
              default:
                  break;
            }
          }

        function redirect( url ){
            window.location.href = "<?= site_url(); ?>" + url;
        }

        function redirectToPost(url) {
            // Crear un formulario
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= site_url(); ?>" + url;

            // Agregar datos como campos ocultos
            var hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'token';
            hiddenField.value = "<?= $_POST['token']; ?>";

            form.appendChild(hiddenField);

            // Agregar el formulario al cuerpo del documento y enviarlo
            document.body.appendChild(form);
            form.submit();
        }
        
        
    });
</script>
<?= $this->endSection() ?>