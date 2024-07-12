<!-- upload_csv.php -->
<form method="post" action="<?= base_url('csv/upload') ?>" enctype="multipart/form-data">
    <input type="file" name="csv_file" accept=".csv">
    <button type="submit">Subir CSV</button>
</form>
