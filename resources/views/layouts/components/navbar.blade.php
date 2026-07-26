<nav class="top-navbar">





    <button class="icon-btn menu-toggle" id="menuToggle">
        <i class="bi bi-list" id="menuIcon"></i>
    </button>

    <div class="search-box">




    </div>

    <div class="navbar-right">

        <button class="icon-btn">
            <i class="bi bi-bell"></i>
            <span class="badge">5</span>
        </button>



        <div class="user-box">

            <div class="dropdown user-dropdown">

                <button class="user-box dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">


                    


                    <div class="user-info">

                        <strong>
                            {{ Auth::user()->name ?? 'Administrador' }}
                        </strong>


                        <small>
                            {{ Auth::user()->email ?? 'admin@sacvadmin.com' }}
                        </small>


                    </div>


                </button>



                <ul class="dropdown-menu dropdown-menu-end user-menu">


                    <li>

                        <div class="user-header">

                           


                            <div>

                                <strong>
                                    {{ Auth::user()->name ?? 'Administrador' }}
                                </strong>

                                <small>
                                    Usuario del sistema
                                </small>

                            </div>


                        </div>

                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>



                    <li>

                        <a href="#" class="dropdown-item">

                            <i class="bi bi-person"></i>

                            Mi perfil

                        </a>

                    </li>



                    <li>

                        <a href="#" class="dropdown-item">

                            <i class="bi bi-gear"></i>

                            Configuración

                        </a>

                    </li>



                    <li>

                        <hr class="dropdown-divider">

                    </li>



                    <li>


                        <form method="POST" action="{{ route('logout') }}">

                            @csrf


                            <button type="submit" class="dropdown-item logout-item">


                                <i class="bi bi-box-arrow-right"></i>

                                Cerrar sesión


                            </button>


                        </form>


                    </li>


                </ul>


            </div>

        </div>


    </div>

</nav>
