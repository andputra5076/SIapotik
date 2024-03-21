<table class="table table-bordered table-striped table-condensed mb-none">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Upah Peracik</th>
            <th>Harga Item</th> 
            <th>Total Harga</th>  
        </tr>
    </thead>
    <tbody> 
<?php foreach($posts as $post): ?> 
<tr> 
    <td><?php echo tgl_indo($post['tanggal']); ?></td> 
    <td><?php echo $post['nama_admin']; ?></td>  
    <td><?php echo rupiah($post['total_upah_peracik']); ?></td>  
    <td><?php echo rupiah($post['total_harga_item']); ?></td>  
    <td><?php echo rupiah($post['total']); ?></td>  
</tr> 
<?php endforeach;?>  
</tbody>
</table>
<ul class="pagination">
<?php echo $this->ajax_pagination->create_links(); ?>
</ul> 