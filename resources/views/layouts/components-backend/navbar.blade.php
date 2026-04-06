<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars text-white"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                
                {{-- Nama User Dinamis --}}
                <span class="mr-3 d-none d-lg-inline text-white small fw-bold">
                    {{ Auth::user()->name }}
                </span>

                {{-- Foto User (Bisa ganti logic jika user punya kolom foto) --}}
                <img class="img-profile rounded-circle border border-2 border-white" 
                     src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets/backend/img/boy.png') }}" 
                     style="width: 35px; height: 35px; object-fit: cover;">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-header text-center">
                    <h6 class="mb-0 text-dark">{{ Auth::user()->name }}</h6>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
                <div class="dropdown-divider"></div>
                
                
                <div class="dropdown-divider"></div>

                {{-- Logout Form yang Benar --}}
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-left">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>

<style>
    /* Tambahan style agar lebih premium */
    .bg-navbar {
        background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
    }
    .img-profile {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .dropdown-header {
        padding: 0.5rem 1.5rem;
        background-color: #f8f9fa;
    }
</style>