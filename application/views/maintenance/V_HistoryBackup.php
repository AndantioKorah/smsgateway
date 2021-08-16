<?php if($result){ ?>
    <table class="table table-sm table-hover table-striped">
        <thead>
            <th class="text-center">No</th>
            <th>Tanggal Backup</th>
            <th>User</th>
            <th class="text-center">DB Name</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=formatDate($rs['created_date'])?></td>
                    <td><?=$rs['nama']?></td>
                    <td class="text-center"><?=$rs['db_name']?></td>
                    <td class="text-center">
                        <a type="button" href="<?=base_url($rs['sql_file'])?>" class="btn btn-sm btn-navy"><i class="fa fa-download"></i> Download</a>

                        <!-- <form action="<?=base_url('maintenance/C_Maintenance/previewFile/'.$rs['id'])?>" target="_blank">
                            <button type="submit" class="btn btn-sm btn-navy"><i class="fa fa-search"></i> Preview SQL</button>
                        </form -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>