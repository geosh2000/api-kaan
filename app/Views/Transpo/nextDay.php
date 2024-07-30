<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
        .hotel-ATELIER {
            background-color: green;
            color: white;
        }
        .hotel-OLEO {
            background-color: blue;
            color: white;
        }
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="container mt-4">
        <h1 class="mb-4">Transportaciones</h1>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Hotel</th>
                    <th>Tipo</th>
                    <th>Folio</th>
                    <th>Item</th>
                    <th>Date</th>
                    <th>Pax</th>
                    <th>Guest</th>
                    <th>Time</th>
                    <th>Flight</th>
                    <th>Airline</th>
                    <th>Pick Up</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transportaciones as $transpo): ?>
                    <tr class="hotel-<?= $transpo['hotel'] ?>">
                        <td><?= $transpo['hotel'] ?></td>
                        <td><?= $transpo['tipo'] ?></td>
                        <td><?= $transpo['folio'] ?></td>
                        <td><?= $transpo['item'] ?></td>
                        <td><?= $transpo['date'] ?></td>
                        <td><?= $transpo['pax'] ?></td>
                        <td><?= $transpo['guest'] ?></td>
                        <td><?= $transpo['time'] ?></td>
                        <td><?= $transpo['flight'] ?></td>
                        <td><?= $transpo['airline'] ?></td>
                        <td><?= $transpo['pick_up'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>

