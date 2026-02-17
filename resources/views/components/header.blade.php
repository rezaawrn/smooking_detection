<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">

    <!-- LEFT SIDE -->
    <ul class="navbar-nav mr-auto">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>


    <!-- RIGHT SIDE -->
    <ul class="navbar-nav navbar-right">

        <!-- MESSAGE
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep">
                <i class="far fa-envelope"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages</div>
                <div class="dropdown-list-content dropdown-list-message">

                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>

                </div>
            </div> -->
        </li>


        <!-- NOTIF -->
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle beep">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications</div>

                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            System Ready
                            <div class="time text-primary">Now</div>
                        </div>
                    </a>
                </div>

            </div>
        </li>


        <!-- USER -->
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, Operator</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Online</div>

                <a href="#" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
