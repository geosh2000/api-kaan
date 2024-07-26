<div class="container">
    <?php foreach ($data as $reservation): ?>
        <div class="card mb-2">
            <div class="card-body" style="line-height: 0.5">
                <h5 class="card-title"><?= $reservation['hotel'] ?> - <?= $reservation['globalStatus'] ?></h5>
                <p class="card-text" style="line-height: normal"><strong>Guest:</strong> <?= $reservation['guest'] ?> (pax: <?= $reservation['pax'] ?>)</p>
                <p class="card-text"><strong>Email:</strong> <?= $reservation['correo'] ?></p>
                <p class="card-text"><strong>Res. No:</strong> <?= $reservation['folio'] ?></p>
                <p class="card-text"><strong>CRS / PMS:</strong> <?= $reservation['crs_id'] ?> / <?= $reservation['pms_id'] ?></p>
                <p class="card-text"><strong>Dates:</strong> <?= date('Y-m-d', strtotime($reservation['date_in'])) ?> to <?= date('Y-m-d', strtotime($reservation['date_out'])) ?></p>
                <p class="card-text" style="line-height: normal"><strong>Agency:</strong> <?= $reservation['agency_id'] ?></p>
                <input type="text" value='<?= json_encode($reservation) ?>' class="jsonReg" id="json-<?= $reservation['folio'] ?>" hidden>
                <div class="d-flex justify-content-end">
                    <button class="ml-auto btn btn-primary btn-select" data-reg="<?= $reservation['folio'] ?>">
                        <i class="fas fa-check"></i> Select
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
