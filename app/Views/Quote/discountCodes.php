<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Codes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Discount Codes</h2>
        <div class="text-right mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                Add New
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Property</th>
                    <th>Discount</th>
                    <th>Currency</th>
                    <th>Travel Window</th>
                    <th>Booking Window</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($discountCodes as $code): ?>
                    <tr>
                        <td><?= $code['code'] ?></td>
                        <td><?= $code['description'] ?></td>
                        <td><?= $code['property'] ?></td>
                        <td><?= $code['discount'] ?></td>
                        <td><?= $code['currency'] ?></td>
                        <td><?= $code['tw_start'] ?> - <?= $code['tw_end'] ?></td>
                        <td><?= $code['bw_start'] ?> - <?= $code['bw_end'] ?></td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $code['id'] ?>">
                                Delete
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailsModal<?= $code['id'] ?>">
                                Details
                            </button>
                        </td>
                    </tr>
                     <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $code['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $code['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $code['id'] ?>">Confirm Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this discount code?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

              
                    <!-- Details Modal -->
<div class="modal fade" id="detailsModal<?= $code['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?= $code['id'] ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel<?= $code['id'] ?>">Discount Code Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Description:</strong> <?= $code['description'] ?></p>
                <p><strong>Property:</strong> <?= $code['property'] ?></p>
                <p><strong>Discount:</strong> <?= $code['discount'] ?></p>
                <p><strong>Currency:</strong> <?= $code['currency'] ?></p>
                <p><strong>Travel Window:</strong> <?= $code['tw_start'] ?> - <?= $code['tw_end'] ?></p>
                <p><strong>Booking Window:</strong> <?= $code['bw_start'] ?> - <?= $code['bw_end'] ?></p>
                <p><strong>Blackout Dates:</strong>
                    <?php foreach (json_decode($code['blackout_dates']) as $blackout_date): ?>
                        <?= date_format(date_create($blackout_date->start), 'Y-m-d') ?> to <?= date_format(date_create($blackout_date->end), 'Y-m-d') ?><br>
                    <?php endforeach; ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                Add New
            </button>
        </div>


<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addModalLabel">Add New Discount Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_discount_code.php" method="POST">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="property">Property</label>
                        <input type="text" class="form-control" id="property" name="property" required>
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select class="form-control" id="currency" name="currency" required>
                            <option value="USD">USD</option>
                            <option value="MXN">MXN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount (%)</label>
                        <input type="number" class="form-control" id="discount" name="discount" required>
                    </div>
                    <div class="form-group">
                        <label for="tw">Travel Window</label>
                        <input type="text" class="form-control" id="tw" name="tw" required>
                    </div>
                    <div class="form-group">
                        <label for="bw">Booking Window</label>
                        <input type="text" class="form-control" id="bw" name="bw" required>
                    </div>
                    <div class="form-group">
                        <label for="blackout_dates">Blackout Dates</label>
                        <textarea class="form-control" id="blackout_dates" name="blackout_dates" rows="3" placeholder="Enter blackout dates in JSON format"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {
        $('#tw').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('#bw').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
</script>

</body>
</html>
