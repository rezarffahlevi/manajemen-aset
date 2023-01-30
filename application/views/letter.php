<style>
    @page {
        margin-top: 25px;
        margin-left: 40px;
        margin-right: 40px;
        margin-bottom: 0px;
    }

    /* @font-face {
            font-family: RespondentBold;
            src: url(<?= base_url() . 'assets/fonts/RespondentBold.otf' ?>) format('opentypes');
        } */

    .ttd {
        font-family: 'monospace';
        font-size: xx-large;
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
</style>

<body>
    <div style="text-align: center;">
        <img src="<?= $logo ?>" style="width: 80pt;" />
        <br /><b>PT. INDONESIA COMNETS PLUS</b>
        <br />Jl. KH. Abdul Rochim No. 1, Kuningan Barat
        <br />Mampang - Jakarta Selatan 12710
        <br />Telp. 021-29532400 Email: humas@iconpln.cp.id www.iconpln.co.id
        <div style="width: 100%; height:1px; background-color: #000; margin:10px 0px;"></div>
        <h4 style="margin-bottom: 0; margin-top: 5px">
            S U R A T&nbsp;&nbsp;&nbsp;J A L A N
            <!-- <br />No. : <?= $data->no_so ?> -->
        </h4>
        PERMOHONAN KENDARAAN UNTUK KEPERLUAN
        <br />Umum - Aktivasi - Gangguan - Pemeliharaan - Penjualan - Marketing
    </div>

    <br />

    <table style="width: 100%;">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= $data->nama_pegawai ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td><?= $data->jabatan_pegawai ?></td>
        </tr>
        <tr>
            <td>Jenis Kendaraan</td>
            <td>:</td>
            <td>
                Mobil
            </td>
        </tr>
        <tr>
            <td>Jumlah Penumpang</td>
            <td>:</td>
            <td><?= $data->jumlah_penumpang ?> (<?= $data->terbilang ?>) Orang</td>
        </tr>
        <tr>
            <td>Tujuan/Keperluan</td>
            <td>:</td>
            <td><?= $data->keperluan ?></td>
        </tr>
        <tr>
            <td>No. SO/IO/AR</td>
            <td>:</td>
            <td><?= $data->no_so ?></td>
        </tr>
    </table>
    <br>
    <table style="width: 100%;" align="center">
        <tr align="center">
            <td>
                Menyetujui
            </td>
            <td>
                <!-- Mengetahui -->
            </td>
            <td>
                Jakarta, <?= $tanggal ?>
            </td>
        </tr>
        <tr align="center">
            <!-- <td><span id="detail_ttd_kapool" class="ttd"><?= $data->nama_kapool ?></span></td>
            <td><span id="detail_ttd_ptl" class="ttd"><?= $data->nama_ptl ?></span></td>
            <td><span id="detail_ttd_pegawai" class="ttd"><?= $data->nama_pegawai ?></span></td> -->
            <td><br /><br /><br /></td>
            <td></td>
            <td></td>
        </tr>
        <tr align="center">
            <td>
                (<?= $data->nama_kapool ?>)<br />
                Kapool
            </td>
            <td>
                <!-- (<?= $data->nama_ptl ?>)<br />
                Supervisor -->
            </td>
            <td>
                (<?= $data->nama_pegawai ?>)<br />
                Pemohon
            </td>
        </tr>
    </table>

    <hr />

    <div style="text-align: center;">
        <h4 style="margin-bottom: 0; margin-top: 0">
            PERINTAH PERJALANAN
        </h4>
        (Diisi oleh Bag. Kendaraan/Pool)
    </div>

    <br />

    <table style="width: 100%;">
        <tr>
            <td>Pengemudi</td>
            <td>:</td>
            <td colspan="7"><?= $data->nama_sopir ?></td>
        </tr>
        <tr>
            <td>Tanggal Berangkat</td>
            <td>:</td>
            <td><?= date('Y-m-d', strtotime($data->tgl_berangkat)) ?></td>
        <tr>
            <td>Jenis Kendaraan</td>
            <td>:</td>
            <td>Mobil</td>
        </tr>
        <tr>
            <td>No. Pol</td>
            <td>:</td>
            <td><?= $data->plat ?></td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>:</td>
            <td colspan="7"><?= $data->status_peminjaman == 'done' ? date('Y-m-d', strtotime($data->tgl_kembali)) : '...........' ?> </td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>:</td>
            <td colspan="7"><?= $data->nama_pelanggan ?>, <?= $data->alamat_pelanggan ?></td>
        </tr>
        <tr align="center">
            <td colspan="8"></td>
            <td>
                <p>Sopir</p><br /><br /><br />
                (<?= $data->nama_sopir ?>)<br />
                Sopir
            </td>
        </tr>
    </table>
</body>