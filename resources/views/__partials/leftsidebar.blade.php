<aside class="nav-container">
    <ul>
        <li class="nav-title">Navegación</li>
        <li class="{{ ($option == 'dashboard')? 'active' : '' }}">
            <a href="#" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE88A;</i>Resumen
            </a>
        </li>
        <li class="{{ ($option == 'shop')? 'active' : '' }}">
            <a href="#" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE8D1;</i>Planta PKI
            </a>
        </li>
        <li class="{{ ($option == 'category')? 'active' : '' }}">
            <a href="#" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE886;</i>Usuarios Active Directory
            </a>
        </li>
        <li class="{{ ($option == 'product')? 'active' : '' }}">
            <a href="#" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE0E0;</i>DNIe
            </a>
        </li>
        <li class="nav-divider"></li>
    </ul>
</aside>