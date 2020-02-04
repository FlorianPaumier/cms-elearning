<nav class="sidebar-nav bg-gradient-primary sidebar sidebar-dark accordion col-md-2 col-sm-3" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="col-sm-1 row" style="justify-content: space-between">
        <span class="text-center">

        <a class="sidebar-brand" href="{{ app_home|path }}">
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>
        </span>
        <div class="hamburger" id="hamburger-4">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>


    <!-- Divider -->
    <hr class="sidebar-divider solid my-0">

    <ul>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt list-icon"></i>
                <span class="list-content">Dashboard <?= $session["user"] ?></span></a>
        </li>

        <!-- Divider -->
        <li class="sidebar-divider solid"></li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog list-icon"></i>
                <span class="list-content">Components</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench list-icon"></i>
                <span class="list-content">Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <li class="sidebar-divider solid"></li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder list-icon"></i>
                <span class="list-content">Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area list-icon"></i>
                <span class="list-content">Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table list-icon"></i>
                <span class="list-content">Tables</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ app_admin_newsletter_index|path }}" class="nav-link">
                <i class="fas fa-envelope list-icon"></i>
                <span class="list-content">Newsletter</span>
            </a>
        </li>
        <span class="sidebar-nav--footer">
            <!-- Divider -->
            <li class="sidebar-divider solid"></li>

            <li>
                <a href="{{ app_admin_configuration_index|path }}">
                <i class="fas fa-cogs list-icon"></i>
                <span class="list-content">Configuration</span>
                </a>
            </li>

            <li>
                <a href="{{ app_user_logout|path }}">
                <i class="fas fa-sign-out-alt list-icon"></i>
                <span class="list-content">Ce déconnecter</span>
                </a>
            </li>
        </span>
    </ul>
</nav>