<div class="container">
    <?php foreach ($reservations as $reservation): ?>
        <div class="card mb-2">
            <div class="card-body" style="line-height: 0.5">
                <h5 class="card-title"><?= $reservation['Hotel'] ?></h5>
                <p class="card-text" style="line-height: normal"><strong>Guest:</strong> <?= $reservation['Guest'] ?> (pax: </strong> <?= $reservation['pax'] ?>)</p>
                <p class="card-text"><strong>Email:</strong> <?= $reservation['Email'] ?></p>
                <p class="card-text"><strong>Res. No:</strong> <?= $reservation['rsvAgencia'] ?></p>
                <p class="card-text"><strong>CRS / PMS:</strong> <?= $reservation['rsvCrs'] ?> / <?= $reservation['rsvPms'] ?></p>
                <p class="card-text"><strong>Dates:</strong> <?= date('Y-m-d', strtotime($reservation['DateFrom'])) ?> to <?= date('Y-m-d', strtotime($reservation['DateTo'])) ?> (<?= $reservation['nights'] ?> noches)</p>
                <p class="card-text"><strong>Tipo de Pago:</strong> <?= $reservation['isIncluida'] == "1" ? 'Cortesia' : 'De Pago' ?></p>
                <p class="card-text"  style="line-height: normal"><strong>Agency:</strong> <?= $reservation['Agencia'] ?> (<?= $reservation['Canal'] ?>)</p>
                <input type="text" value='<?= json_encode( $reservation ) ?>' class="jsonReg" id="json-<?= $reservation['rsvPms'] ?>" hidden>
                <div class="d-flex justify-content-end">
                    <button class="ml-auto btn btn-primary btn-select" data-reg-crs="<?= $reservation['rsvPms'] ?>" >
                        <i class="fas fa-check"></i> Select
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>