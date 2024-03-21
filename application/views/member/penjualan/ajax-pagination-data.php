<?php if(!empty($posts)): foreach($posts as $post): ?>
<div class="col-sm-12 col-md-3 col-lg-3">
    <div class="thumbnail">
        <div class="thumb-preview"> 
                <img src="<?php echo base_url()?>/images/<?php echo $post['gambar']; ?>" class="img-responsive fit-image" alt="Foto Produk"> 
        </div>
        <span class="mg-title nama_produk">
        <?php if($post['jenis'] == 'racikan') echo"<b>[racikan]</b>"; ?> <?php echo $post['nama_item']; ?>
        </span>
        <div class="row">
            <div class="col-md-12"> 
                <span class="text-bold">
                <?php echo rupiah($post['harga_jual']); ?>
                </span>
            </div> 
            </div>
        <div class="row">
            <div class="col-md-12"> 
            <a class="btn btn-xs btn-success" id="beli-item<?php echo $post['kode_item']; ?>" onclick="beli(this)" data-barcode="<?php echo $post['kode_item']; ?>"><i class="fa fa-shopping-cart"></i> Beli Produk</a> 
            </div> 
            </div>  
    </div>
</div> 
<?php endforeach; else: ?>
<div class="col-sm-12 col-md-12 col-lg-12">
<p>Product not available.</p>
</div>
<?php endif; ?>
<div class="col-sm-12 col-md-12 col-lg-12">
<ul class="pagination">
<?php echo $this->ajax_pagination->create_links(); ?>
</ul>
</div>