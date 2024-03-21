<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed sidebar-left-collapsed">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo base_url() ?>/assets/images/favicon.png" type="image/ico">
    <title>Apotek</title>
    <meta name="author" content="Paber">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/stylesheets/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/stylesheets/skins/default.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/stylesheets/theme-custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.css" />

    <!-- Head Libs -->
    <script src="<?php echo base_url() ?>/assets/vendor/modernizr/modernizr.js"></script>
</head>

<body class="bgbody">
    <section class="body">

        <?php $this->load->view("komponen/header.php") ?>
        <div class="inner-wrapper">
            <?php $this->load->view("komponen/sidebar.php") ?>
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Kartu Stok</h2>
                </header>
                <!-- start: page -->
                <section class="panel">
                    <header class="panel-heading">
                        <div class="row show-grid">
                            <div class="col-md-6" align="left">
                                <h2 class="panel-title">Data Kartu Stok</h2>
                            </div>
                        </div>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped" id="itemsdata">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Kode Item (Barcode)</th>
                                    <th>Nama Item</th>
                                    <th>Stok</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </section>
                <!-- end: page -->
            </section>
        </div>
    </section>

    <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <section class="panel panel-primary">
                    <header class="panel-heading">
                        <h2 class="panel-title">Detail Kartu Stok</h2>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped dataTable no-footer">
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td><input type='text' name='startdate' class='form-control input-sm tanggalformstart' value='<?php echo date('Y-m-d'); ?>'></td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td><input type='text' name='enddate' class='form-control input-sm tanggalformend' value='<?php echo date('Y-m-d'); ?>'></td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body" id="showdetail">
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </div>



    <!-- Vendor -->
    <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/select2/select2.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
    <script src="<?php echo base_url() ?>assets/javascripts/theme.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.js"></script>
    <script src="<?php echo base_url() ?>assets/javascripts/theme.init.js"></script>

    <script type="text/javascript">
        var tableitems = $('#itemsdata').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url() ?>stok/datakartustok",
                "type": "GET"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
        $('.tanggalformstart').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('.tanggalformend').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('.tanggalformstart').change(function() {
            $('#htmlStartDate').val(this.value);
            $('#pdfStartDate').val(this.value);
        });
        $('.tanggalformend').change(function() {
            $('#htmlEndDate').val(this.value);
            $('#pdfEndDate').val(this.value);
        });

        function detail(elem) {
            var dataId = $(elem).data("id");
            $('#idd_html').val(dataId);
            $('#idd_pdf').val(dataId);
            $('#detailData').modal();
            $('#showdetail').html('Loading...');
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>master/itemdetail',
                data: 'id=' + dataId,
                dataType: 'json',
                success: function(response) {
                    var datarow = '';
                    $.each(response, function(i, item) {
                        datarow += '<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                        datarow += "<tr><td>Kode Item (Barcode)</td><td>: " + item.kode_item + "</td></tr>";
                        datarow += "<tr><td>Jenis</td><td>: " + item.jenis + "</td></tr>";
                        datarow += "<tr><td>Kategori</td><td>: " + item.kategori + "</td></tr>";
                        datarow += "<tr><td>Nama Item</td><td>: " + item.nama_item + "</td></tr>";
                        datarow += "<tr><td>Harga Jual</td><td>: " + item.harga_jual + "</td></tr>";
                        datarow += "<tr><td>Satuan (Retail)</td><td>: " + item.satuan + "</td></tr>";
                        datarow += "<tr><td>Merk</td><td>: " + item.merk + "</td></tr>";
                        datarow += "<tr><td>Keterangan</td><td>: " + item.keterangan + "</td></tr>";
                        datarow += "</table>";
                    });
                    $('#showdetail').html(datarow);
                }
            });
            return false;
        }
        // Alert untuk stok obat hampir habis dan habis
        <?php
        $list = $this->stok_model->get_datakartustok_datatable();
        $alertMessages = array(); // Gunakan array untuk menyimpan pesan peringatan

        foreach ($list as $r) {
            if ($r->stok == 0) {
                $alertMessages[$r->kode_item] = "Obat habis untuk " . $r->nama_item;
            } elseif ($r->stok <= 5) {
                $alertMessages[$r->kode_item] = "Stok obat hampir habis untuk " . $r->nama_item;
            }
        }

        // Loop melalui pesan peringatan dan tampilkan menggunakan PNotify
        foreach ($alertMessages as $kode_item => $message) {
            echo 'new PNotify({ title: "Peringatan Stok", text: "' . $message . '", type: "warning" });';
        }
        ?>
    </script>
</body>

</html>