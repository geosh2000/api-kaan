<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Detalles de la Reserva</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Número de Reserva</th>
                        <td><?= esc($reservation['ReservationNumber']) ?></td>
                    </tr>
                    <tr>
                        <th>Agencia</th>
                        <td><?= esc($reservation['agency_name']) ?> / <?= esc($reservation['agency_code']) ?> (<?= esc($reservation['AgencyNumber']) ?>)</td>
                    </tr>
                    <tr>
                        <th>Hotel</th>
                        <td><?= esc($reservation['hotel_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Habitación</th>
                        <td><?= esc($reservation['room_type_code']) ?> (<?= esc($reservation['room_type_name']) ?>)</td>
                    </tr>
                    <tr>
                        <th>Habitaciones</th>
                        <td><?= esc($reservation['Rooms']) ?></td>
                    </tr>
                    <tr>
                        <th>Fechas</th>
                        <td><?= date("y-M-d", strtotime(esc($reservation['DateFrom']))) ?> a <?= date("y-M-d", strtotime(esc($reservation['DateTo']))) ?></td>
                    </tr>
                    <tr>
                        <th>Titular</th>
                        <td><?= esc($reservation['Name']) ?> <?= esc($reservation['LastName']) ?></td>
                    </tr>
                    <tr>
                        <th>Correo Electrónico</th>
                        <td><?= esc($reservation['Email']) ?></td>
                    </tr>
                    <tr>
                        <th>Compañía</th>
                        <td><?= esc($reservation['Company']) ?></td>
                    </tr>
                    <tr>
                        <th>ID del Grupo</th>
                        <td><?= esc($reservation['GroupId']) ?></td>
                    </tr>
                    
                    <tr>
                        <th>ID VIP</th>
                        <td><?= esc($reservation['VipId']) ?></td>
                    </tr>
                    <tr>
                        <th>ID del Tipo de Reserva</th>
                        <td><?= esc($reservation['ReservationTypeId']) ?></td>
                    </tr>
                    <tr>
                        <th>ID del Canal</th>
                        <td><?= esc($reservation['ChannelId']) ?></td>
                    </tr>
                    <tr>
                        <th>ID del Catálogo de Formas de Pago</th>
                        <td><?= esc($reservation['FormsPaymentCatalogId']) ?></td>
                    </tr>
                    <tr>
                        <th>Adultos</th>
                        <td><?= esc($reservation['Adults']) ?></td>
                    </tr>
                    <tr>
                        <th>Noches</th>
                        <td><?= esc($reservation['Nights']) ?></td>
                    </tr>
                    <tr>
                        <th>Tarifa Neta</th>
                        <td><?= esc($reservation['NetRate']) ?></td>
                    </tr>
                    <tr>
                        <th>Notas</th>
                        <td><?= esc($reservation['Notes']) ?></td>
                    </tr>
                    <tr>
                        <th>Código de Promoción</th>
                        <td><?= esc($reservation['PromotionCode']) ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Reserva</th>
                        <td><?= esc($reservation['ReservationDate']) ?></td>
                    </tr>
                    <tr>
                        <th>ID de la Moneda Desde</th>
                        <td><?= esc($reservation['CurrencyIdFrom']) ?></td>
                    </tr>
                    <tr>
                        <th>ID de la Moneda Hacia</th>
                        <td><?= esc($reservation['CurrencyIdTo']) ?></td>
                    </tr>
                    <tr>
                        <th>Tasa de Cambio</th>
                        <td><?= esc($reservation['ExchangeRate']) ?></td>
                    </tr>
                    <tr>
                        <th>ID de las Razones de Cancelación</th>
                        <td><?= esc($reservation['ReasonsCancellationId']) ?></td>
                    </tr>
                    <tr>
                        <th>Número de Cancelación</th>
                        <td><?= esc($reservation['CancellationNumber']) ?></td>
                    </tr>
                    <tr>
                        <th>ID de la Habitación</th>
                        <td><?= esc($reservation['RoomId']) ?></td>
                    </tr>
                    <tr>
                        <th>Solicitud Especial</th>
                        <td><?= esc($reservation['SpecialRequest']) ?></td>
                    </tr>
                    <tr>
                        <th>Bebés</th>
                        <td><?= esc($reservation['Infants']) ?></td>
                    </tr>
                    <tr>
                        <th>Niños</th>
                        <td><?= esc($reservation['Children']) ?></td>
                    </tr>
                    <tr>
                        <th>Adolescentes</th>
                        <td><?= esc($reservation['Teens']) ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Cancelación</th>
                        <td><?= esc($reservation['DateCancel']) ?></td>
                    </tr>
                    <tr>
                        <th>Usuario de Cancelación</th>
                        <td><?= esc($reservation['UserCancel']) ?></td>
                    </tr>
                    <tr>
                        <th>ID del Método de Pago</th>
                        <td><?= esc($reservation['PaymentMethodId']) ?></td>
                    </tr>
                    <tr>
                        <th>ID de la Llamada</th>
                        <td><?= esc($reservation['CallId']) ?></td>
                    </tr>
                    <tr>
                        <th>Fuente</th>
                        <td><?= esc($reservation['Source']) ?></td>
                    </tr>
                    <tr>
                        <th>Usuario de ADH</th>
                        <td><?= esc($reservation['AdhUser']) ?></td>
                    </tr>
                </table>
                <a href="/reservations" class="btn btn-primary">Volver</a>
                <a href="/reservations/edit/<?= esc($reservation['ReservationId']) ?>" class="btn btn-warning">Editar</a>
                <form action="/reservations/delete/<?= esc($reservation['ReservationId']) ?>" method="post" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta reserva?');">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
