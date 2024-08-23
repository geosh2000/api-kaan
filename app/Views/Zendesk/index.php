<?= $this->extend('Layouts/Zendesk/main') ?>

<?= $this->section('content') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        
        client.get("ticket").then(function(data) {
            formRedirect( data.ticket.form.id );
        }); 
        
    });
</script>
<?= $this->endSection() ?>