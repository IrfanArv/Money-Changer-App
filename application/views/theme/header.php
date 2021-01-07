<nav class="topbar-main">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="<?php echo base_url().''?>" class="logo">
            <span><img src="<?php echo base_url().'uploads/logo.png'?>" class="logo-sm"> </span>
        </a>
    </div>
    <!--topbar-left-->
    <!--end logo-->
    <ul class="list-unstyled topbar-nav float-right mb-0">
    <?php if($this->session->userdata('level')=='3'){ ;?>
        <li class="hidden-sm">
            <div class="crypto-balance" data-container="body" data-toggle="popover" title="" data-placement="bottom" 
            data-content="
            1. Membuka Menu Transaksi -> ALT + S
            2. Kirim Data Input Transaksi -> ALT + K
            3. Selesai (Proses Transaksi) -> ALT + P
            4. Cetak Struk -> ALT + T
            "
            data-original-title="Pintasan Keyboard" aria-describedby="popover564901">
            <i class="mdi mdi-keyboard-close align-self-center"></i>
            </div>    
                                 
        </li> 
        <li class="hidden-sm">
            <button type="button" onclick="riwayattransaksi()" class="crypto-balance btn btn-outline-dark waves-effect waves-light"><i class="dripicons-wallet align-self-center"></i>
                <div class="btc-balance">
                    <span>Riwayat Transaksi</span>
                </div>
            </button>
        </li> 
    <?php }?>
    <?php if($this->session->userdata('level')=='2'){ ;?>
        <li class="hidden-sm">
            <button type="button" onclick="laci()" data-toggle="tooltip" data-placement="top" title="Lihat Stock Barang" class="crypto-balance btn btn-outline-primary waves-effect waves-light">
                <i class="dripicons-wallet align-self-center"></i>
                <div class="btc-balance">
                    <h5 class="m-0" id="total_barang" ></h5>
                </div>
            </button>
        </li> 
    <?php }?>

        
        <li class="dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user pr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <!-- <img src="<?php echo base_url().'/assets/theme/assets/images/users/user-4.jpg'?>" alt="profile-user" class="rounded-circle">  -->
                <span class="ml-1 nav-user-name hidden-sm"><?php echo $this->session->userdata('username') ?> 
                (
                    <?php 
                    if($this->session->userdata('level')=='1'){echo "Administrator";}
                    elseif($this->session->userdata('level')=='2'){echo "Backoffice";}
                    elseif($this->session->userdata('level')=='3'){echo "Teller";}
                    elseif($this->session->userdata('level')=='4'){echo "General Manager";}
                    ?>
                )   
                    <i class="mdi mdi-chevron-down"></i></span></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- <a class="dropdown-item" href="#"><i class="dripicons-user text-muted mr-2"></i> Profile</a> 
                    <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="<?= base_url() ?>valas/adminvalas/logout">
                        <i class="dripicons-exit text-muted mr-2"></i> Logout</a>
            </div>
        </li>
        <!--end dropdown-->
        <li class="menu-item">
            <!-- Mobile menu toggle--> <a class="navbar-toggle nav-link" id="mobileToggle">
                <div class="lines"><span></span> <span></span> <span></span></div>
            </a><!-- End mobile menu toggle-->
        </li>
        <!--end menu item-->
    </ul>
    <!--end topbar-nav-->

    <!--end topbar-nav-->
</nav><!-- end navbar-->
<!-- MENU  -->
<div class="navbar-custom-menu">
    <div class="container-fluid">
        <div id="navigation">
            
            <ul class="navigation-menu">
                <li <?php if($this->uri->segment(0)=="valas"){echo "class='has-submenu active last-elements'";}?>>
                    <a href="<?php echo base_url().''?>">
                        <i class="dripicons-home"></i>Dashboard
                    </a>
                </li>
                <?php if($this->session->userdata('level')=='3'){ ;?>
                <li><a href="#" onclick="create_beli()">
                        <i class="dripicons-download"></i>Transaksi Pembelian
                    </a>
                </li>
                <?php };?>
                <?php if($this->session->userdata('level')=='1'){ ;?>
                <!-- <li <?php if($this->uri->segment(2)=="transcation_today" || "recap_validasi" || "recap_teller"){echo "class='has-submenu active'";}?>><a href="#">
                    <i class="dripicons-archive"></i>
                    <span>Data Pembelian</span></a>
                    <ul class="submenu">
                        <li <?php if($this->uri->segment(2)=="transcation_today"){echo "class='active'";}?> ><a href="<?php echo base_url().'administrator/transcation_today'?>"><i class="dripicons-card"></i>Pembelian Hari Ini</a></li>
                        <li class="has-submenu <?php if($this->uri->segment(2)=="recap_validasi" || "recap_teller"){echo "active";}?>"><a href="#"><i class="dripicons-copy"></i>Recap Pembelian</a>
                            <ul class="submenu">
                                <li class="<?php if($this->uri->segment(2)=="recap_validasi"){echo "active";}?>"><a href="<?php echo base_url().'administrator/recap_validasi'?>">Recap Validasi Transaksi</a></li>
                                <li class="<?php if($this->uri->segment(2)=="recap_teller"){echo "active";}?>"><a href="<?php echo base_url().'administrator/recap_teller'?>">Recap Transaksi Teller</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- <li><a href="#" onclick="create_jual()">
                    <i class="dripicons-browser-upload"></i>Penjualan
                    </a>
                </li> -->
                
                <li class="has-submenu <?php if($this->uri->segment(3)=="transcation_today"){echo "active";}?> <?php if($this->uri->segment(3)=="penjualan"){echo "active";}?> <?php if($this->uri->segment(3)=="recap_teller" ){echo "active";}?> <?php if($this->uri->segment(3)=="detail_penjualan" ){echo "active";}?> <?php if($this->uri->segment(3)=="faktur" ){echo "active";}?>"><a href="#">
                    <i class="dripicons-swap"></i>
                    <span>Transaksi</span></a>
                    <ul class="submenu">
                        <li class="has-submenu <?php if($this->uri->segment(3)=="transcation_today"){echo "active";}?> <?php if($this->uri->segment(3)=="recap_teller"){echo "active";}?>">
                            <a href="#">
                                <i class="dripicons-cart"></i>Pembelian</a>
                            <ul class="submenu">
                                <li <?php if($this->uri->segment(3)=="transcation_today"){echo "class='active'";}?> ><a href="<?php echo base_url().'valas/adminvalas/transcation_today'?>"><i class="dripicons-clipboard"></i>Pembelian Hari Ini</a></li>
                                <li <?php if($this->uri->segment(3)=="recap_teller"){echo "class='active'";}?> ><a href="<?php echo base_url().'valas/adminvalas/recap_teller'?>"><i class="dripicons-calendar"></i>Recap Transaksi Teller</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu <?php if($this->uri->segment(3)=="faktur" ){echo "active";}?> <?php if($this->uri->segment(3)=="penjualan" ){echo "active";}?> <?php if($this->uri->segment(3)=="detail_penjualan" ){echo "active";}?>">
                            <a href="#">
                                <i class="dripicons-store"></i>Penjualan</a>
                            <ul class="submenu">
                                <li><a href="#" onclick="create_jual()">
                                <i class="dripicons-browser-upload"></i>Buat Penjualan Baru</a>
                                </li>
                                <li <?php if($this->uri->segment(3)=="faktur"){echo "class='active'";}?> <?php if($this->uri->segment(3)=="penjualan"){echo "class='active'";}?> <?php if($this->uri->segment(3)=="detail_penjualan"){echo "class='active'";}?>><a href="<?php echo base_url().'valas/adminvalas/penjualan'?> ">
                                <i class="dripicons-view-list"></i>Data Penjualan Valas</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                

                <li class="has-submenu <?php if($this->uri->segment(3)=="barang"){echo "active";}?> last-elements"><a href="#">
                    <i class="dripicons-wallet"></i>
                    <span>Rupiah</span></a>
                    <ul class="submenu">
                        <li <?php if($this->uri->segment(3)=="barang"){echo "class='active'";}?> ><a href="<?php echo base_url().'valas/adminvalas/barang'?>"><i class="dripicons-ticket"></i>Drop Rupiah</a></li>
                    </ul>
                </li>

                <!-- <li><a href="#" onclick="laci_user()">
                        <i class="dripicons-archive"></i>Laci User
                    </a>
                </li> -->

                <li class="has-submenu <?php if($this->uri->segment(3)=="relasi"){echo "active";}?> last-elements"><a href="<?php echo base_url().'valas/adminvalas/relasi'?>">
                        <i class="dripicons-user-group"></i>Relasi
                    </a>
                </li>

                <li class="has-submenu <?php if($this->uri->segment(3)=="user"){echo "active";}?> last-elements"><a href="#">
                    <i class="dripicons-gear"></i>
                    <span>Pengaturan</span></a>
                    <ul class="submenu">
                        <li <?php if($this->uri->segment(3)=="user"){echo "class='active'";}?> ><a href="<?php echo base_url().'valas/adminvalas/user'?>"><i class="dripicons-user"></i>Akun</a></li>
                    </ul>
                </li>

                <?php };?>
            </ul>
        </div>
    </div>
</div> 


