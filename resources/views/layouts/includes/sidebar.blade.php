 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link bg-secondary">
         <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                                 Kandang (Stok)
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('produk') }}"
                             class="nav-link {{ request()->is('*/produk') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-box"></i>
                             <p>
                                 Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('agen') }}" class="nav-link {{ request()->is('*/agen') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-user-tie"></i>
                             <p>
                                 Agen
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-home"></i>
                             <p>
                                 Data Penjualan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-home"></i>
                             <p>
                                 Data Pesanan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-home"></i>
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
                 </ul>
                 </ul>
                 </ul>
             </nav>
         @elseif(Auth::user()->role_id == 2)
             <nav class="mt-2">
                 <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                     <li class="nav-item">
                         <a href="{{ route('loginpage') }}"
                             class="nav-link {{ request()->is('login') ? ' active' : '' }}">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">MASTER</li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-box"></i>
                             <p>
                                 Ukuran
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link">
                             <i class="nav-icon fas fa-box"></i>
                             <p>
                                 Gaji
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
