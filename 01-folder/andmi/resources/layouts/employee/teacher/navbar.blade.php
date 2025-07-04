<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <font size='3px'><i class="fas fa-globe"></i></font>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="border-radius: 8px; padding: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                <a href="#" class="dropdown-item lang-item">O'zbekcha (lotincha)</a>
                <a href="#" class="dropdown-item lang-item">O'zbekcha (krillcha)</a>
                <a href="#" class="dropdown-item lang-item">Ruscha</a>
                <a href="#" class="dropdown-item lang-item">Inglizcha</a>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <font size='3px'><i class="fas fa-comments"></i></font>
                <span class="badge badge-danger navbar-badge">{{ count($messages) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Talabalar yuborgan xabarlari</span>
                <div class="dropdown-divider"></div>
                @foreach ($messages as $message)
                    <a href="{{ route('employee.teacher.chat', ['chat'=> $message['id']]) }}" class="dropdown-item">
                        <div class="media">
                            <img src="{{ $message['picture_path'] }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ $message['fio'] }}
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">{{ $message['message'] }}</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $message['sended_at'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{ route('employee.teacher.chat') }}" class="dropdown-item dropdown-footer">Barchasini ko'rish</a>
            </div>
        </li>

        <!-- Dark/Light mode toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle">
                <font size='3px'><i class="fas fa-moon"></i></font>
            </a>
        </li>

        <!-- Role Switcher -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <font size='3px'>
            <i class="fas fa-exchange-alt"></i>
            </font>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($user->roles as $role)
                    <a href="{{ route("employee.{$role->name}.dashboard") }}" class="dropdown-item"> {{ $role->label }}</a>
                @endforeach
            </div>
         </li>

        <!-- Profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ $user->picture_path() }}" alt="User" class="img-circle" style="height: 30px; padding-right: 8px;">
                <span class="d-none d-md-inline">{{ $user->full_name() }}</span>
                <span class="d-inline d-md-none">{{ $user->short_name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('employee.teacher.edit-profile') }}" class="dropdown-item">
                    <i class="nav-icon fas fa-pencil"></i> Profilni tahrirlash
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Chiqish
                </a>
            </div>
        </li>
    </ul>
</nav>
