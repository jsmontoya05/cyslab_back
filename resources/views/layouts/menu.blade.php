<li class="side-menus {{ Request::is('home*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>
<li class="side-menus {{ Request::is('credentials*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('credentials.index') }}"><i class="fas fa-tape"></i><span>Credenciales</span></a>
</li>

<li class="side-menus {{ Request::is('settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-cogs"></i><span>Configuraciones</span></a>
</li>

