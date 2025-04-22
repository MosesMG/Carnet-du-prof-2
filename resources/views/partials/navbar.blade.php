<nav class="navbar navbar-main navbar-expand-lg mt-1 px-0 ms-0 me-2 shadow-none border-radius-xl bg-white" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h5 class="font-weight-bold mb-0">Dashboard | Administration du site</h5>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">

            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            
            <ul class="navbar-nav justify-content-end">
                
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>

                @auth('admin')

                    <li class="nav-item dropdown pe-1 ms-3 d-flex align-items-center">
                        <a class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/assets/images/logo.png" alt="" class="avatar avatar-sm">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-lg-1 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            <li class="mb-1">
                                <p class="mb-0">
                                    <span class="text-sm font-weight-bold ms-2">
                                        {{ auth()->guard('admin')->user()->name }}
                                    </span>
                                </p>
                            </li>
                            <hr class="my-2">
                            <li class="mb-1">
                                <a href="" class="mb-0">
                                    <span class="text-sm font-weight-bold ms-2">
                                        Profil
                                    </span>
                                </a>
                            </li>
                            <hr class="mt-2 mb-3">
                            <li>
                                <form action="{{ route('admin.logout') }}" method="post" class="dropdown-item p-0">
                                    @method('DELETE')
                                    @csrf

                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="btn btn-outline-info m-0">
                                            Déconnexion
                                            <i class="fa fa-sign-out ms-2"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>

                @endauth

            </ul>
        </div>
    </div>
</nav>