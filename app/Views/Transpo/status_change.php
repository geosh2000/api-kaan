<div class="dropdown text-center">
        <button style="font-size:smaller" class="btn <?= $styleMap[$transportacion['hotel'].'-'.$transportacion['status']] ?? 'btn-secondary' ?> dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $transportacion && $transportacion['status'] ? $transportacion['status'] : 'Selecciona una opción' ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/INCLUIDA') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="INCLUIDA">INCLUIDA</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/INCLUIDA (SOLICITADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="INCLUIDA (SOLICITADO)">INCLUIDA (SOLICITADO)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO PENDIENTE') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO PENDIENTE">PAGO PENDIENTE</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CORTESÍA (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CORTESÍA (CAPTURA PENDIENTE)">CORTESÍA (CAPTURA PENDIENTE)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CORTESÍA (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CORTESÍA (CAPTURADO)">CORTESÍA (CAPTURADO)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO EN DESTINO (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO EN DESTINO (CAPTURA PENDIENTE)">PAGO EN DESTINO (CAPTURA PENDIENTE)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO EN DESTINO (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO EN DESTINO (CAPTURADO)">PAGO EN DESTINO (CAPTURADO)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGADA (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGADA (CAPTURA PENDIENTE)">PAGADA (CAPTURA PENDIENTE)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGADA (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGADA (CAPTURADO)">PAGADA (CAPTURADO)</a>
            <a class="dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CANCELADA') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CANCELADA">CANCELADA</a>
        </div>
        <input type="hidden" name="status" id="status" value="<?= $transportacion ? $transportacion['status'] : '' ?>">
</div>