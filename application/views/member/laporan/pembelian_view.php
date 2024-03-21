<table class="table table-bordered table-striped table-condensed mb-none">
    <thead>
        <tr>
            <th>Nomor Faktur</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Supplier</th> 
            <th>Nama Supplier</th> 
            <th class="text-right">Total Harga</th>
            <th class="text-right">Pembayaran</th>
            <th class="text-right">Termin</th> 
            <th class="text-right">Keterangan</th> 
        </tr>
    </thead>
    <tbody> 
<?php foreach($posts as $post): ?> 
<tr>
    <td><?php echo $post['nomor_faktur']; ?></td>
    <td><?php echo tgl_indo($post['tgl_pembelian']); ?></td>
    <td><?php echo $post['supplier']; ?></td>
    <td><?php echo $post['nama_supplier']; ?></td> 
    <td class="text-right"><?php echo rupiah($post['total']); ?></td>
    <td class="text-right"><?php echo $post['pembayaran']; ?></td>
    <td class="text-right"><?php echo $post['termin']; ?> Hari</td> 
    <td class="text-right"><?php echo $post['keterangan']; ?></td>
</tr> 
<?php endforeach;?>  
</tbody>
</table>
<ul class="pagination">
<?php echo $this->ajax_pagination->create_links(); ?>
</ul> 