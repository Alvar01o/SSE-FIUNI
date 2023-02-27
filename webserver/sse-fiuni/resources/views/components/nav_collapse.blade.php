<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content scrollbar">
        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
            @if(!auth()->user()->hasRole('egresado'))
            <li class="nav-item">
                <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Pagina Principal</span>
                    </div>
                </a>
                <ul class="nav collapse show" id="dashboard">
                    <li class="nav-item"><a class="nav-link active" href="/" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Inicio</span>
                        </div>
                        </a>
                        <!-- more inner pages-->
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasRole('administrador'))
                <x-nav_admin/>
            @endif
            @if(auth()->user()->hasRole('egresado'))
                <x-nav_egresados/>
            @endif
            @if(auth()->user()->hasRole('empleador'))
                <x-nav_empleadores/>
            @endif
        </ul>
    </div>
</div>
