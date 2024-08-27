<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <!-- Dashboard Link (accessible to all users) -->
                    <li>
                        <a href="<?php echo base_url()?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <?php 
                        // Get user type from session
                        $login = $this->session->userdata('nama_kategori');
                    ?>

                    <!-- Conditional menu items based on user type -->
                    <?php if ($login === 'Manager' || $login === 'Dokter'): ?>
                        <!-- Menu items accessible to both Manager and Dokter -->
                        <li>
                            <a href="<?php echo base_url()?>praktik/jadwal_praktik"> 
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span>Jadwal Praktik Dokter</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($login === 'Manager'): ?>
                        <!-- Manager-specific menu items -->
                        <li>
                            <a href="<?php echo base_url()?>master"> 
                                <i class="fa fa-database" aria-hidden="true"></i>
                                <span>Master Data</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>pembelian"> 
                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                <span>Pembelian</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>stok"> 
                                <i class="fa fa-reorder" aria-hidden="true"></i>
                                <span>Stok</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>penjualan"> 
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span>Penjualan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>keuangan"> 
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>Keuangan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>laporan"> 
                                <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                                <span>Laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>user/user"> 
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span>Manajemen User</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>tools/profil"> 
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span>Tools</span>
                            </a>
                        </li>
                    <?php elseif ($login === 'Dokter'): ?>
                        <!-- Dokter-specific menu items -->
                        <!-- You may include additional items here if needed -->
                    <?php endif; ?>
                </ul>
            </nav>

            <hr class="separator" />
        </div>
    </div>
</aside>


            <!-- end: sidebar -->

            