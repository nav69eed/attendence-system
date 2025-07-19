<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-calendar-check me-2"></i>Attendance System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('attendance.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-alt me-1"></i>Attendance
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('attendance.create') }}">
                                <i class="fas fa-check-circle me-1"></i>Mark Attendance
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('attendance.history') }}">
                                <i class="fas fa-history me-1"></i>View History
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('leaves.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-minus me-1"></i>Leave Requests
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('leaves.create') }}">
                                <i class="fas fa-plus-circle me-1"></i>Request Leave
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('leaves.index') }}">
                                <i class="fas fa-list me-1"></i>My Requests
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('tasks.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-tasks me-1"></i>Tasks
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks.index') }}">
                                <i class="fas fa-list me-1"></i>All Tasks
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 class="rounded-circle me-1" 
                                 width="24" 
                                 height="24" 
                                 alt="Profile Picture">
                        @else
                            <i class="fas fa-user-circle me-1"></i>
                        @endif
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-edit me-1"></i>Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>