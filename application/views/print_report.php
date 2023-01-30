<style>
    @page {
        margin-top: 25px;
        margin-left: 40px;
        margin-right: 40px;
        margin-bottom: 0px;
    }

    body {
        font-size: 9.5pt;
    }

    .row {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-md-4 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .table {
        border: 1px solid #000;
        width: 100%;
        border-spacing: 0;
        border-collapse: collapse;
    }

    table.text-center,
    table.text-center td,
    table.text-center th {
        text-align: center;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
        border: 1px solid #000;
    }
</style>

<body>
    <div style="text-align: center;">
        <img src="<?= $logo ?>" style="width: 80pt;" />
        <br /><br /><b>PT. INDONESIA COMNETS PLUS</b>
        <br />Jl. KH. Abdul Rochim No. 1, Kuningan Barat
        <br />Mampang - Jakarta Selatan 12710
        <br />Telp. 021-29532400 Email: humas@iconpln.cp.id www.iconpln.co.id
        <h4 style="margin-bottom: 0; margin-top: 10px">
            SUMMARY REPORT <?= $data->group ?>
            <br />
        </h4>
        Dari <?= $data->from . ' sampai ' . $data->to ?>
    </div>

    <br />
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No.</th>
                <?php
                foreach ($data->field as $key => $value) : ?>
                    <th><?= $value ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($data->data as $key => $row) {
                $no++; ?>
                <tr>
                    <td><?= $no ?></td>
                    <?php
                    foreach ($data->field as $key => $value) :
                        if ($key == 'tanggal')
                            echo "<td width='70'>" . str_replace(',', ',<br>', $row->tanggal) . "</td>";
                        elseif ($key == 'jam')
                            echo "<td>" . str_replace(',', ',<br>', $row->jam) . "</td>";
                        elseif ($key == 'tujuan')
                            echo "<td>" . str_replace(',', ',<br>', $row->tujuan) . "</td>";
                        else
                            echo "<td>" . ($row->$key ?? '-') . "</td>";
                    endforeach; ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>