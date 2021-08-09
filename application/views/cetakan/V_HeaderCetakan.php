<style>
    .header_cetakan_dokter{
        width: 50%;
        vertical-align: top;
        /* font-weight: normal;
        text-align: left;
        float: left; */
        /* margin-bottom: 5px; */
    }
    .header_cetakan_pasien{
        width: 50%;
        vertical-align: top;
        /* font-weight: normal;
        text-align: left;
        float: left; */
        /* margin-bottom: 5px; */
    }
    .header_penanggung_jawab{
        width: 100%;
        margin-left: 50%;
        margin-bottom: 5px;
        font-style: italic;
        text-decoration: underline;
        font-weight: bold;
        font-size: 12px;
        text-align: left;
    }
    .header_content{
        text-align: left;
        font-size: 12px;
    }
    .header_label{
        vertical-align: top;
        font-size: 12px;
    }
    .div_header_element{
        width: 100%;
    }
    .header_element_label{
        vertical-align: top !important;
        float: left !important;
        width: 25% !important;
        font-size: 12px !important;
    }
    .header_element_colon{
        vertical-align: top !important;
        float: left !important;
        width: 3% !important;
        font-size: 14px !important;
    }
    .header_element_value{
        vertical-align: top !important;
        float: right !important;
        width: 70% !important;
        font-size: 14px !important;
    }
</style>
<div style="width: 100%;" class="table_header">
    <div class="header_penanggung_jawab">
        <?php
            $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
            if(!$pendaftaran['id_m_dokter_pengirim']){
                $dokter_pengirim = 'Atas Permintaan Sendiri';
            }
        ?>
        <span>Penanggung Jawab Laboratorium : <?=$pendaftaran['nama_dokter_dpjp']?></span>
    </div>
    <table style="width: 100%;">
        <thead>
            <th class="header_cetakan_dokter">
                <table style="width: 100%;">
                    <tr>
                        <td><span class="header_content"><i><b>Dokter</b></i></span></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Nama</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=strtoupper($dokter_pengirim)?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Alamat</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=strtoupper($pendaftaran['alamat_dokter_pengirim'])?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">No. Telp</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=strtoupper($pendaftaran['nomor_telepon_dokter_pengirim'])?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Tanggal</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=strtoupper(formatDateNamaBulan($pendaftaran['tanggal_pendaftaran']))?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Halaman</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=$page_number.' / '.$page_count?></td>
                    </tr>
                </table>
            </th>
            <th class="header_cetakan_pasien">
                <table style="width: 100%;">
                    <tr>
                        <td><span class="header_content"><i><b>Pasien</b></i></span></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Nama</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=$pendaftaran['nama_pasien']?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">Alamat</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=$pendaftaran['alamat']?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">No. Telp</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=$pendaftaran['nomor_telepon']?></td>
                    </tr>
                    <tr>
                        <?php
                            $umur = countDiffDateLengkap($pendaftaran['tanggal_lahir'], date('Y-m-d'), ['tahun']);
                            $jenis_kelamin = $pendaftaran['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan';
                        ?>
                        <td class="header_element_label">Umur/Kel.</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=strtoupper($umur.' / '.$jenis_kelamin)?></td>
                    </tr>
                    <tr>
                        <td class="header_element_label">No. Pendaftaran</td>
                        <td class="header_element_colon">:</td>
                        <td class="header_element_value"><?=$pendaftaran['nomor_pendaftaran']?></span></td>
                    </tr>
                </table>
            </th>
        </thead>
    </table>
</div>