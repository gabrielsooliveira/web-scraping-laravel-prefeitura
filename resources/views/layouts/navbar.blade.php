<nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4" aria-label="navbar principal">
    <div class="container-xl">
      <a class="navbar-brand" href="#">WebScrapping</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal" aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Alternar de navegação">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarPrincipal">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Inicio</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Conteudos</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item {{ Route::currentRouteName() == 'cgm_informes' ? 'active' : '' }}" href="{{ route('cgm_informes') }}">Informes da CGM</a></li>
              <li><a class="dropdown-item {{ Route::currentRouteName() == 'portalt_servidores' ? 'active' : '' }}" href="{{ route('portalt_servidores') }}">Servidores da Prefeitura</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
</nav>