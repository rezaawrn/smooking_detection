<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <!-- BRAND -->
        <div class="sidebar-brand">
            <a href="#">
                <img src="https://poliban.ac.id/wp-content/uploads/2021/12/poliban3.png" 
                     alt="Logo Poliban" 
                     style="height:40px;">
            </a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">
                <img src="https://poliban.ac.id/wp-content/uploads/2022/02/Logo-Poliban-Standar-Okt-2018.png" 
                     alt="Logo Small" 
                     style="height:35px;">
            </a>
        </div>

        <!-- MENU -->
        <ul class="sidebar-menu">

            <!-- KAMERA -->
            <li class="menu-header">Kamera</li>
            <li class="nav-item {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" class="nav-link">
                    <i class="fas fa-video"></i>
                    <span>Monitoring Kamera</span>
                </a>
            </li>

            <!-- PELANGGARAN -->
            <li class="menu-header">Pelanggaran</li>
            <li class="nav-item {{ Request::is('monitoring-pelanggaran') ? 'active' : '' }}">
                <a href="{{ url('monitoring-pelanggaran') }}" class="nav-link">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Monitoring Pelanggaran</span>
                </a>
            </li>

        </ul>

    </aside>
</div>

