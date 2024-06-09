@vite(['resources/css/sidebar.css'])
<link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

<nav>
    <div class="sidebar">
        <div class="logo">
            <span class="logo-name">Clinic System</span>
        </div>

        <div class="sidebar-content">
            <ul class="lists">
                <li class="list">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="bx bx-home-alt icon"></i>
                        <span class="link">Main Page</span>
                    </a>
                </li>
                @if(Auth::user()->type == "admin")
                    <li class="list">
                        <a href="{{ route('admin_add') }}" class="nav-link">
                            <i class="bx bx-bar-chart-alt-2 icon"></i>
                            <span class="link">Add New User</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->type != "doctor")
                    <li class="list">
                        <a href="{{ route('appointment') }}" class="nav-link">
                            <i class="bx bx-bell icon"></i>
                            <span class="link">Appointment</span>
                        </a>
                    </li>
                @endif
                <li class="list">
                    <a href="{{ route('consultation') }}" class="nav-link">
                        <i class="bx bx-message-rounded icon"></i>
                        <span class="link">Consultation</span>
                    </a>
                </li>
                <li class="list">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="logout"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            <i class="bx bx-log-out icon"></i>
                                            <span class="link">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
