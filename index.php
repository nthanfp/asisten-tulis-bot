<?php
require('./lib/config.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Asisten Tulis BOT Monitoring</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Datatable CSS -->
    <link href="https://theaxe.net/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <main role="main" class="container" style="padding-top: 25px;">
        <div class="starter-template">
            <h1 class="text-center">Asisten Tulis BOT</h1>
            <?php
            $message    = mysqli_query($conn, "SELECT * FROM `tbl_message`");
            $message    = mysqli_num_rows($message);
            $user       = mysqli_query($conn, "SELECT `chat_id` FROM `tbl_message` GROUP BY `chat_id`");
            $user       = mysqli_num_rows($user);
            ?>
            <li>
                Total Pesan Diterima : <strong><?= number_format($message); ?></strong>
            </li>
            <li>
                Total User : <strong><?= number_format($user); ?></strong>
            </li>
            <br>
            <div class="table-responsive">
                <table id="List-Data" class="display table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 145px;">Date</th>
                            <th>Chat ID</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="width: 145px;">Date</th>
                            <th>Chat ID</th>
                            <th>Message</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>
    <!-- /.container -->
    <!-- Bootstrap core JavaScript
            ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://theaxe.net/assets/js/jquery-3.3.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://theaxe.net/assets/js/jquery.dataTables.min.js"></script>
    <script src="https://theaxe.net/assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#List-Data').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?= $config['host']; ?>/model/listMessage.php",
                "order": [
                    [0, 'desc']
                ]
            });

        });
    </script>
</body>

</html>