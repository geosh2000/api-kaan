<?= $this->extend('layouts/main') ?>

<?php

    $styleMap = [
        "ATELIER-INCLUIDA"                              => 'btn-incluNoData',
        "ATELIER-INCLUIDA (SOLICITADO)"                 => 'btn-incluSolicitado',
        "ATELIER-PAGO PENDIENTE"                        => 'btn-pagoPendiente',
        "ATELIER-CORTESÍA (CAPTURA PENDIENTE)"          => 'btn-pagadoSinIngresar',
        "ATELIER-PAGO EN DESTINO (CAPTURA PENDIENTE)"   => 'btn-pagadoSinIngresar',
        "ATELIER-PAGADA (CAPTURA PENDIENTE)"            => 'btn-pagadoSinIngresar',
        "ATELIER-CANCELADA"                             => 'btn-cancel',
        "ATELIER-CORTESÍA (CAPTURADO)"                  => 'btn-pagadoRegistradoAtpm',
        "ATELIER-PAGO EN DESTINO (CAPTURADO)"           => 'btn-pagadoRegistradoAtpm',
        "ATELIER-PAGADA (CAPTURADO)"                    => 'btn-pagadoRegistradoAtpm',
        "Atelier Playa Mujeres-INCLUIDA"                              => 'btn-incluNoData',
        "Atelier Playa Mujeres-INCLUIDA (SOLICITADO)"                 => 'btn-incluSolicitado',
        "Atelier Playa Mujeres-PAGO PENDIENTE"                        => 'btn-pagoPendiente',
        "Atelier Playa Mujeres-CORTESÍA (CAPTURA PENDIENTE)"          => 'btn-pagadoSinIngresar',
        "Atelier Playa Mujeres-PAGO EN DESTINO (CAPTURA PENDIENTE)"   => 'btn-pagadoSinIngresar',
        "Atelier Playa Mujeres-PAGADA (CAPTURA PENDIENTE)"            => 'btn-pagadoSinIngresar',
        "Atelier Playa Mujeres-CANCELADA"                             => 'btn-cancel',
        "Atelier Playa Mujeres-CORTESÍA (CAPTURADO)"                  => 'btn-pagadoRegistradoAtpm',
        "Atelier Playa Mujeres-PAGO EN DESTINO (CAPTURADO)"           => 'btn-pagadoRegistradoAtpm',
        "Atelier Playa Mujeres-PAGADA (CAPTURADO)"                    => 'btn-pagadoRegistradoAtpm',
        "OLEO-INCLUIDA"                              => 'btn-incluNoData',
        "OLEO-INCLUIDA (SOLICITADO)"                 => 'btn-incluSolicitado',
        "OLEO-PAGO PENDIENTE"                        => 'btn-pagoPendiente',
        "OLEO-CORTESÍA (CAPTURA PENDIENTE)"          => 'btn-pagadoSinIngresar',
        "OLEO-PAGO EN DESTINO (CAPTURA PENDIENTE)"   => 'btn-pagadoSinIngresar',
        "OLEO-PAGADA (CAPTURA PENDIENTE)"            => 'btn-pagadoSinIngresar',
        "OLEO-CANCELADA"                             => 'btn-cancel',
        "OLEO-CORTESÍA (CAPTURADO)"                  => 'btn-pagadoRegistradoOlcp',
        "OLEO-PAGO EN DESTINO (CAPTURADO)"           => 'btn-pagadoRegistradoOlcp',
        "OLEO-PAGADA (CAPTURADO)"                    => 'btn-pagadoRegistradoOlcp',
        "Oleo Cancun Playa-INCLUIDA"                              => 'btn-incluNoData',
        "Oleo Cancun Playa-INCLUIDA (SOLICITADO)"                 => 'btn-incluSolicitado',
        "Oleo Cancun Playa-PAGO PENDIENTE"                        => 'btn-pagoPendiente',
        "Oleo Cancun Playa-CORTESÍA (CAPTURA PENDIENTE)"          => 'btn-pagadoSinIngresar',
        "Oleo Cancun Playa-PAGO EN DESTINO (CAPTURA PENDIENTE)"   => 'btn-pagadoSinIngresar',
        "Oleo Cancun Playa-PAGADA (CAPTURA PENDIENTE)"            => 'btn-pagadoSinIngresar',
        "Oleo Cancun Playa-CANCELADA"                             => 'btn-cancel',
        "Oleo Cancun Playa-CORTESÍA (CAPTURADO)"                  => 'btn-pagadoRegistradoOlcp',
        "Oleo Cancun Playa-PAGO EN DESTINO (CAPTURADO)"           => 'btn-pagadoRegistradoOlcp',
        "Oleo Cancun Playa-PAGADA (CAPTURADO)"                    => 'btn-pagadoRegistradoOlcp',
    ];

?>


<?= $this->section('content') ?>
<link rel="stylesheet" href="btnStyles.css">
<style>
    /* Estilos para los enlaces de paginación */

/* Botón Cancel - Rojo */
.btn-cancel {
    background-color: #FF0000;
    color: white;
    border: 1px solid #FF0000;
}
.btn-cancel:hover {
    background-color: #CC0000;
    border-color: #CC0000;
}
.btn-cancel:focus, .btn-cancel.focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.5);
}
.btn-cancel:disabled, .btn-cancel.disabled {
    background-color: #FFCCCC;
    border-color: #FFCCCC;
}

/* Botón IncluNoData - Blanco */
.btn-incluNoData {
    background-color: #FFFFFF;
    color: black;
    border: 1px solid #CCCCCC;
}
.btn-incluNoData:hover {
    background-color: #F0F0F0;
    border-color: #CCCCCC;
}
.btn-incluNoData:focus, .btn-incluNoData.focus {
    box-shadow: 0 0 0 0.2rem rgba(204, 204, 204, 0.5);
}
.btn-incluNoData:disabled, .btn-incluNoData.disabled {
    background-color: #F9F9F9;
    border-color: #CCCCCC;
}

/* Botón IncluSolicitado - Morado */
.btn-incluSolicitado {
    background-color: #800080;
    color: white;
    border: 1px solid #800080;
}
.btn-incluSolicitado:hover {
    background-color: #660066;
    border-color: #660066;
}
.btn-incluSolicitado:focus, .btn-incluSolicitado.focus {
    box-shadow: 0 0 0 0.2rem rgba(128, 0, 128, 0.5);
}
.btn-incluSolicitado:disabled, .btn-incluSolicitado.disabled {
    background-color: #E0B3E0;
    border-color: #E0B3E0;
}

/* Botón PagoPendiente - Naranja */
.btn-pagoPendiente {
    background-color: #FFA500;
    color: white;
    border: 1px solid #FFA500;
}
.btn-pagoPendiente:hover {
    background-color: #CC8400;
    border-color: #CC8400;
}
.btn-pagoPendiente:focus, .btn-pagoPendiente.focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 165, 0, 0.5);
}
.btn-pagoPendiente:disabled, .btn-pagoPendiente.disabled {
    background-color: #FFE0B3;
    border-color: #FFE0B3;
}

/* Botón PagadoSinIngresar - Amarillo */
.btn-pagadoSinIngresar {
    background-color: #FFFF00;
    color: black;
    border: 1px solid #FFFF00;
}
.btn-pagadoSinIngresar:hover {
    background-color: #CCCC00;
    border-color: #CCCC00;
}
.btn-pagadoSinIngresar:focus, .btn-pagadoSinIngresar.focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 0, 0.5);
}
.btn-pagadoSinIngresar:disabled, .btn-pagadoSinIngresar.disabled {
    background-color: #FFFFE0;
    border-color: #FFFFE0;
}

/* Botón PagadoRegistradoAtpm - Verde */
.btn-pagadoRegistradoAtpm {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
}
.btn-pagadoRegistradoAtpm:hover {
    background-color: #45a049;
    border-color: #45a049;
}
.btn-pagadoRegistradoAtpm:focus, .btn-pagadoRegistradoAtpm.focus {
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
}
.btn-pagadoRegistradoAtpm:disabled, .btn-pagadoRegistradoAtpm.disabled {
    background-color: #c8e6c9;
    border-color: #c8e6c9;
}

/* Botón PagadoRegistradoOlcp - Azul Cielo */
.btn-pagadoRegistradoOlcp {
    background-color: #87CEEB;
    color: white;
    border: 1px solid #87CEEB;
}
.btn-pagadoRegistradoOlcp:hover {
    background-color: #6bb6d8;
    border-color: #6bb6d8;
}
.btn-pagadoRegistradoOlcp:focus, .btn-pagadoRegistradoOlcp.focus {
    box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.5);
}
.btn-pagadoRegistradoOlcp:disabled, .btn-pagadoRegistradoOlcp.disabled {
    background-color: #d1ecf8;
    border-color: #d1ecf8;
}


.pagination {
    margin-top: 20px; /* Espacio entre la tabla y la paginación */
    text-align: center; /* Centrar los enlaces de paginación */
}

.pagination li {
    display: inline-block;
    margin-right: 5px; /* Espacio entre los enlaces */
}

.pagination a {
    padding: 5px 10px;
    background-color: transparent;
    color: #007bff; /* Color de los enlaces */
    text-decoration: none;
    border: 1px solid #007bff; /* Borde de los enlaces */
    border-radius: 3px; /* Borde redondeado */
    transition: background-color 0.3s, color 0.3s; /* Transición suave */
}

.pagination a:hover {
    background-color: #007bff; /* Cambio de color al pasar el ratón */
    color: #fff; /* Cambio de color al pasar el ratón */
}

.pagination .active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    pointer-events: none; /* Desactivar el enlace activo */
}

.table-sm-custom {
            font-size: 0.75rem; /* Tamaño de fuente reducido */
            width: 50%; /* Ajusta este valor según tus necesidades */
        }
.table-sm-custom td, .table-sm-custom th {
    padding: 0.3rem; /* Ajusta el padding según sea necesario */
}

.dropdown-menu {
    position: absolute !important; /* Asegura que el dropdown flote */
    will-change: transform; /* Mejora el rendimiento de la animación */
}

.copy-button {
            cursor: pointer;
            font-size: 12px; /* Ajusta el tamaño según tus necesidades */
            margin-left: 4px;
            margin-right: 4px;
            color: brown;
        }

.add-button {
    cursor: pointer;
    font-size: 15px; /* Ajusta el tamaño según tus necesidades */
    margin-left: 4px;
    margin-right: 4px;
    color: #4CAF50;
}

.remove-button {
    cursor: pointer;
    font-size: 15px; /* Ajusta el tamaño según tus necesidades */
    margin-left: 4px;
    margin-right: 4px;
    color: #CC0000;
}

.actionBtn{
    zoom:0.8;
    margin: 1px;
}
</style>
<div class="container-fluid px-5">
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
        <h2 class="text-center mt-4 mb-4">Transportaciones</h2>
    
        <!-- Formulario de filtro -->
        <div class="d-flex justify-content-between mb-3">
            <form action="<?= site_url('transpo/') ?>" method="get" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inicio">Fecha de inicio:</label>
                        <input type="date" name="inicio" id="inicio" class="form-control" value="<?= $inicio ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="fin">Fecha de fin:</label>
                        <input type="date" name="fin" id="fin" class="form-control" value="<?= $fin ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="status">Status:</label>
                        <select name="status[]" id="status" class="form-control" multiple>
                            <option value="INCLUIDA" <?= in_array('INCLUIDA', $status) ? 'selected' : '' ?>>INCLUIDA</option>
                            <option value="INCLUIDA (SOLICITADO)" <?= in_array('INCLUIDA (SOLICITADO)', $status) ? 'selected' : '' ?>>INCLUIDA (SOLICITADO)</option>
                            <option value="PAGO PENDIENTE" <?= in_array('PAGO PENDIENTE', $status) ? 'selected' : '' ?>>PAGO PENDIENTE</option>
                            <option value="CORTESÍA (CAPTURA PENDIENTE)" <?= in_array('CORTESÍA (CAPTURA PENDIENTE)', $status) ? 'selected' : '' ?>>CORTESÍA (CAPTURA PENDIENTE)</option>
                            <option value="PAGO EN DESTINO (CAPTURA PENDIENTE)" <?= in_array('PAGO EN DESTINO (CAPTURA PENDIENTE)', $status) ? 'selected' : '' ?>>PAGO EN DESTINO (CAPTURA PENDIENTE)</option>
                            <option value="PAGADA (CAPTURA PENDIENTE)" <?= in_array('PAGADA (CAPTURA PENDIENTE)', $status) ? 'selected' : '' ?>>PAGADA (CAPTURA PENDIENTE)</option>
                            <option value="CANCELADA" <?= in_array('CANCELADA', $status) ? 'selected' : '' ?>>CANCELADA</option>
                            <option value="CORTESÍA (CAPTURADO)" <?= in_array('CORTESÍA (CAPTURADO)', $status) ? 'selected' : '' ?>>CORTESÍA (CAPTURADO)</option>
                            <option value="PAGO EN DESTINO (CAPTURADO)" <?= in_array('PAGO EN DESTINO (CAPTURADO)', $status) ? 'selected' : '' ?>>PAGO EN DESTINO (CAPTURADO)</option>
                            <option value="PAGADA (CAPTURADO)" <?= in_array('PAGADA (CAPTURADO)', $status) ? 'selected' : '' ?>>PAGADA (CAPTURADO)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="hotel">Hotel:</label>
                        <select name="hotel[]" id="hotel" class="form-control" multiple>
                            <option value="ATELIER" <?= in_array('ATELIER', $hotel) ? 'selected' : '' ?>>ATELIER</option>
                            <option value="OLEO" <?= in_array('OLEO', $hotel) ? 'selected' : '' ?>>OLEO</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo">Tipo:</label>
                        <select name="tipo[]" id="tipo" class="form-control" multiple>
                            <option value="ENTRADA" <?= in_array('ENTRADA', $tipo) ? 'selected' : '' ?>>ENTRADA</option>
                            <option value="SALIDA" <?= in_array('SALIDA', $tipo) ? 'selected' : '' ?>>SALIDA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="guest">Guest:</label>
                        <input type="text" name="guest" id="guest" class="form-control" value="<?= $guest ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" value="<?= $correo ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="folio">Folio:</label>
                        <input type="text" name="folio" id="folio" class="form-control" value="<?= $folio ?>">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="loadbtn btn btn-primary mr-2">Filtrar</button>
                    <button type="button" class="create-button loadbtn btn btn-success mr-2">Crear</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Importar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="loadbtn dropdown-item" href="<?= site_url('transpo/db/get/1') ?>">1 día</a></li>
                            <li><a class="loadbtn dropdown-item" href="<?= site_url('transpo/db/get/2') ?>">2 días</a></li>
                            <li><a class="loadbtn dropdown-item" href="<?= site_url('transpo/db/get/3') ?>">3 días</a></li>
                            <li><a class="loadbtn dropdown-item" href="<?= site_url('transpo/db/get/5') ?>">5 días</a></li>
                            <li><a class="loadbtn dropdown-item" href="<?= site_url('transpo/db/get/10') ?>">10 días</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="table-responsive" style="position: relative; overflow:visible">
        <table class="table table-sm table-striped table-bordered table-sm-custom" id="transferTable">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>Folio</th>
                    <th>Tipo</th>
                    <th>Guest</th>
                    <th>Date</th>
                    <th>Flight</th>
                    <th>Pax</th>
                    <th>Pick-up</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Ticket</th>
                    <th>Price</th>
                    <th>Phone</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transpo as $transportacion): ?>
                <tr>
                    <td class="text-center">
                        <?= $transportacion['id'] ?><br>
                        <button class="btn btn-primary history-button" id="history-<?= $transportacion['id'] ?>">
                            <i class="fas fa-history"></i>
                        </button>

                    </td>
                    <td><?= $transportacion['hotel'] == "ATELIER" ? "Atelier Playa Mujeres" : ($transportacion['hotel'] == "OLEO" ? "Oleo Cancun Playa" : $transportacion['hotel']) ?></td>
                    <td class=""><i class="far fa-copy copy-button" text="<?= $transportacion['folio'] ?>"></i> <?= $transportacion['folio'] ?>-<?= $transportacion['item'] ?></td>
                    <td class=""><i class="far fa-copy copy-button" text="<?= $transportacion['tipo'] ?>"></i> <?= $transportacion['tipo'] ?></td>
                    <td><i class="far fa-copy copy-button" text="<?= $transportacion['guest'] ?>"></i><?= $transportacion['guest'] ?><br><i class="far fa-copy copy-button" text="<?= $transportacion['correo'] ?>"></i><?= $transportacion['correo'] ?></td>
                    <td class=""><i class="far fa-copy copy-button" text="<?= $transportacion['date'] ?>"></i><?= $transportacion['date'] ?><br><i class="far fa-copy copy-button" text="<?= $transportacion['time'] ?>"></i> <?= $transportacion['time'] ?></td>
                    <td class=""><i class="far fa-copy copy-button" text="<?= $transportacion['airline'] ?>"></i><?= $transportacion['airline'] ?><br><i class="far fa-copy copy-button" text="<?= $transportacion['flight'] ?>"></i> <?= $transportacion['flight'] ?></td>
                    <td  class=""><i class="far fa-copy copy-button" text="<?= $transportacion['pax'] ?>"></i> <?= $transportacion['pax'] ?></td>
                    <td  class="">
                        <?php if( $transportacion['pick_up'] != null ): ?>
                            <i class="far fa-copy copy-button" text="<?= $transportacion['pick_up'] ?>"></i> <?= $transportacion['pick_up'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="dropdown text-center">
                            <button style="font-size:smaller" class="btn <?= $styleMap[$transportacion['hotel'].'-'.$transportacion['status']] ?? 'btn-secondary' ?> dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $transportacion && $transportacion['status'] ? $transportacion['status'] : 'Selecciona una opción' ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/INCLUIDA') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="INCLUIDA">INCLUIDA</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/INCLUIDA (SOLICITADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="INCLUIDA (SOLICITADO)">INCLUIDA (SOLICITADO)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO PENDIENTE') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO PENDIENTE">PAGO PENDIENTE</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CORTESÍA (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CORTESÍA (CAPTURA PENDIENTE)">CORTESÍA (CAPTURA PENDIENTE)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CORTESÍA (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CORTESÍA (CAPTURADO)">CORTESÍA (CAPTURADO)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO EN DESTINO (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO EN DESTINO (CAPTURA PENDIENTE)">PAGO EN DESTINO (CAPTURA PENDIENTE)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGO EN DESTINO (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGO EN DESTINO (CAPTURADO)">PAGO EN DESTINO (CAPTURADO)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGADA (CAPTURA PENDIENTE)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGADA (CAPTURA PENDIENTE)">PAGADA (CAPTURA PENDIENTE)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/PAGADA (CAPTURADO)') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="PAGADA (CAPTURADO)">PAGADA (CAPTURADO)</a>
                                <a class="loadbtn dropdown-item" href="<?= site_url('transpo/editStatus/'.$transportacion['id'].'/CANCELADA') ?>?<?= $_SERVER['QUERY_STRING'] ?>" data-value="CANCELADA">CANCELADA</a>
                            </div>
                            <input type="hidden" name="status" id="status" value="<?= $transportacion ? $transportacion['status'] : '' ?>">
                        </div>
                    </td>
                    <td  class="text-center">
                        <?php if( $transportacion['status'] == "INCLUIDA" ): ?>
                            <a href="" class="actionBtn btn btn-success"><i class="far fa-paper-plane"></i></a>
                        <?php endif; ?>
                        <button class="actionBtn btn btn-info edit-button" id="delete-<?= $transportacion['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="actionBtn btn btn-danger delete-button" id="delete-<?= $transportacion['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <!-- <a href="<?= site_url('transpo/confirmDelete/'.$transportacion['id']).'?'.$_SERVER['QUERY_STRING'] ?>" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a> -->
                        
                    </td>
                    <td class="text-center">
                        <?php $tickets = json_decode($transportacion['tickets']); ?>
                        <?php foreach ($tickets as $tkt): ?>
                            <a href="https://atelierdehoteles.zendesk.com/agent/tickets/<?= $tkt ?>" target="_blank"><?= $tkt ?></a><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <span class="mr-auto">$</span>    
                            <span><?= $transportacion['precio'] ?></span>    
                        </div>
                        
                    </td>
                    <td><div class="d-flex justify-content-end"><span><?= $transportacion['phone'] ?></span></div></td>
                    <td><div class="d-flex justify-content-end"><span><?= $transportacion['dtCreated'] ?></span></div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>

<!-- Loader -->
<div id="loader" class="loader" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Historial de Transporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="historyTable">
                    <!-- Los datos se cargarán aquí -->
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" data-backdrop="static" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="deleteContent">
                    <!-- Los datos se cargarán aquí -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" data-backdrop="static" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editContent">
                    <!-- Los datos se cargarán aquí -->
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function(){

            // Recuperar y aplicar la posición del scroll almacenada
            if (localStorage.getItem('scrollPosition') !== null) {
                $(window).scrollTop(localStorage.getItem('scrollPosition'));
                localStorage.removeItem('scrollPosition'); // Limpiar el valor almacenado
            }

            // Guardar la posición del scroll antes de recargar
            $(window).on('beforeunload', function() {
                localStorage.setItem('scrollPosition', $(window).scrollTop());
            });

            $('#transferTable').DataTable();
        });

        $(document).ready(function(){

            function startLoader( v = true ){
                if( v ){
                    $('#loader').css('display', 'flex');
                }else{
                    $('#loader').css('display', 'none');
                }
            }


            $(document).on('click', '.loadbtn', function() {
                startLoader();    
            });
            
            $(document).on('click', '.history-button', function() {
                startLoader();
                var id = $(this).attr('id').split('-')[1]; // Obtiene el ID después del guion
                var url = '<?= site_url('transpo/history/') ?>' + id;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        // Asegúrate de destruir cualquier instancia existente de DataTable
                        if ($.fn.DataTable.isDataTable('#historyTable')) {
                            $('#historyTable').DataTable().destroy();
                        }

                        // Limpia la tabla antes de cargar los nuevos datos
                        $('#historyTable').empty().html(data);

                        $('#historyTable').html(data); // Carga los datos en la tabla

                        console.log(data);
                        $('#historyTable').DataTable();
                        $('#historyModal').modal('show'); // Muestra el modal
                        startLoader(false);
                    },
                    error: function() {
                        alert('Hubo un error al cargar los datos.');
                        startLoader(false);
                    }
                });
            });
            
            $(document).on('click', '.delete-button', function() {
                startLoader();
                var id = $(this).attr('id').split('-')[1]; // Obtiene el ID después del guion
                var url = '<?= site_url('transpo/confirmDelete/') ?>' + id + '?<?= $_SERVER['QUERY_STRING'] ?>';

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('#deleteContent').html(data); // Carga los datos en la tabla
                        $('#deleteModal').modal('show'); // Muestra el modal
                        startLoader(false);
                    },
                    error: function() {
                        alert('Hubo un error al cargar los datos.');
                        startLoader(false);
                    }
                });
            });

            function create( e, v = false ){
                startLoader();

                var id;
                var url;
                if( !v ){
                    id = e.attr('id').split('-')[1]; // Obtiene el ID después del guion
                    url = '<?= site_url('transpo/edit/') ?>' + id + '?<?= $_SERVER['QUERY_STRING'] ?>';
                }else{
                    url = '<?= site_url('transpo/create/') ?>?<?= $_SERVER['QUERY_STRING'] ?>';
                }
    
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('#editContent').html(data); // Carga los datos en la tabla
                        if( !v ){
                            $('#newTicket').hide();
                        }
                        $('#editModal').modal('show'); // Muestra el modal
                        startLoader(false);
                    },
                    error: function() {
                        alert('Hubo un error al cargar los datos.');
                        startLoader(false);
                    }
                });
            }
            
            $(document).on('click', '.edit-button', function() {
                create($(this));
            });
            
            $(document).on('click', '.create-button', function() {
                create($(this), true);
            });

            // Delegación de eventos para el botón "Cancelar"
            $(document).on('click', '#cancelModal', function() {
                $('.modal').modal('hide');
            });

            // Delegación de eventos para el botón "Confirmar"
            // $(document).on('click', '#confirmModal', function() {
            //     $('.modal').modal('hide');
            //     startLoader();
            // });

            // Agregar Ticket
            $(document).on('click', '.add-ticket-button', function() {
                $('#newTicket').show();
                $(this).hide();
            });

            $(document).on('submit', 'form', function(event) {
                console.log("form submitted");
                startLoader();
            });
        });
    </script>

<?= $this->endSection() ?>
