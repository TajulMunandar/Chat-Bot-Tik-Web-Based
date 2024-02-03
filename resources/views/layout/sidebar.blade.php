<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex align-items-center" href="/">
            <dotlottie-player src="https://lottie.host/f6d7b494-db1b-410a-bff6-db17b1c207fe/FjQHjjLD17.json" background="transparent" speed="1" style="width: 30px; height: 30px;" loop autoplay></dotlottie-player>
            <span class="ms-1 font-weight-bold">Chat Bot TIK</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-70 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-duotone fa-gauge {{ Request::is('dashboard') ? '' : 'text-dark' }} fs-6 "></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/aiml') ? 'active' : '' }}" href="/dashboard/aiml">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-message-bot {{ Request::is('dashboard/aiml') ? '' : 'text-dark' }} fs-6 "></i>
                    </div>
                    <span class="nav-link-text ms-1">AIML</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master</h6>
              </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/category') ? 'active' : '' }}" href="/dashboard/category">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-sitemap {{ Request::is('dashboard/category') ? '' : 'text-dark' }} fs-6 "></i>
                    </div>
                    <span class="nav-link-text ms-1">Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/mahasiswa') ? 'active' : '' }}" href="/dashboard/mahasiswa">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-duotone fa-users {{ Request::is('dashboard/mahasiswa') ? '' : 'text-dark' }} fs-6 "></i>
                    </div>
                    <span class="nav-link-text ms-1">Mahasiswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/user') ? 'active' : '' }}" href="/dashboard/user">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user {{ Request::is('dashboard/user') ? '' : 'text-dark' }} fs-6 "></i>
                    </div>
                    <span class="nav-link-text ms-1">User</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="btn bg-gradient-primary mt-4 w-100"  type="button">Logout</button>
        </form>
      </div>
</aside>
