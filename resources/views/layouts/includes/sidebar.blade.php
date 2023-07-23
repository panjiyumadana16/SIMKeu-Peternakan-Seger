 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="#" class="brand-link bg-secondary">
         <img src="{{ asset('img/Logo.png') }}" alt="" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">Peternakan Seger</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image mt-2">
                 <i class="fa fa-user-circle text-white" style="font-size: 40px;" aria-hidden="true"></i>
             </div>
             <div class="info text-md">
                 <a href="#" class="d-block">{{ Auth::user()->username }} <br>
                     ({{ Auth::user()->role->role }})</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         @if (Auth::user()->role_id == 1)
             <nav class="mt-2">
                 <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                     <li class="nav-item">
                         <a href="{{ route('dashboard') }}"
                             class="nav-link {{ request()->is('*/dashboard') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">MASTER</li>
                     <li class="nav-item">
                         <a href="{{ route('kandang') }}"
                             class="nav-link {{ request()->is('*/kandang') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-home"></i>
                             <p>
                                 Kandang Ayam
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('stok') }}" class="nav-link {{ request()->is('*/stok') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-egg"></i>
                             <p>
                                 Stok Penen
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('kategori') }}"
                             class="nav-link {{ request()->is('*/kategori') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-tags"></i>
                             <p>
                                 Kategori
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('ongkir-kota') }}"
                            class="nav-link {{ request()->is('*/ongkir-kota') ? ' active' : '' }}">
                            <i class="nav-icon fas fa-shipping-fast"></i>
                            <p>
                                Ongkir Kota
                            </p>
                        </a>
                    </li>
                     <li class="nav-item">
                         <a href="{{ route('produk') }}"
                             class="nav-link {{ request()->is('*/produk') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-cube"></i>
                             <p>
                                 Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('agen') }}"
                             class="nav-link {{ request()->is('*/agen') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-user-tie"></i>
                             <p>
                                 Agen
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="{{ route('pesanan') }}"
                             class="nav-link {{ request()->is('*/pesanan') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-clipboard-list"></i>
                             <p>
                                 Data Pesanan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('penjualan') }}"
                             class="nav-link {{ request()->is('*/penjualan') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-money-bill"></i>
                             <p>
                                 Data Penjualan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('return') }}"
                             class="nav-link {{ request()->is('*/return') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-reply"></i>
                             <p>
                                 Data Pesanan Return
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">LAPORAN KEUANGAN</li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-home"></i>
                             <p>
                                 Laporan Pendapatan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-home"></i>
                             <p>
                                 Laporan Pengeluaran
                             </p>
                         </a>
                     </li>
                 </ul>
             </nav>
         @elseif(Auth::user()->role_id == 2)
             <nav class="mt-2">
                 <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                     <li class="nav-header">TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="{{ route('agen.dashboard') }}"
                             class="nav-link {{ request()->is('*/dashboard') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-egg"></i>
                             <p>
                                 List Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('agen.pesanan') }}"
                             class="nav-link {{ request()->is('*/pesanan') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-clipboard-list"></i>
                             <p>
                                 Pesanan & Pembayaran
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('agen.return') }}"
                             class="nav-link {{ request()->is('*/return') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-reply"></i>
                             <p>
                                 Pesanan Return
                             </p>
                         </a>
                     </li>
                 </ul>
             </nav>
         @endif
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
