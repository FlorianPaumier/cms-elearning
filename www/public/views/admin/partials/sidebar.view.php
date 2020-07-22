<style>
    a, a:active, a:hover{
        color: white;
        text-decoration: none;
    }
</style>

<div class="sidebar-tmp"></div>
<div class="sidebar">
    <div class="logo">
        <img alt="CMS-ELEARNING">
    </div>
    <nav>
        <ul>
            <li class="item">
                <i class="fas fa-home icon"></i>
                <span>Tableau de bord</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
            <li class="item">
                <i class="fas fa-file icon"></i>
                <span>Page</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
            <li class="item">
                <span>Article</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
            <li class="item">
                <i class="fas fa-books icon"></i>
                <span>Cours</span>
                <ul class="submenu">
                    <a href="@path(admin_lesson_list)"><li>Cours</li></a>
                    <a href="@path(admin_lesson_chapter_index)"><li>Chapitre</li></a>
                </ul>
            </li>
            <li class="item">
                <i class="fas fa-calendar-alt icon"></i>
                <span>évenements</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
            <a href="@path(admin_faq_list)">
                <li class="item">
                    <i class="fas fa-thumbtack icon"></i>
                    FAQ
                </li>
            </a>
            <a href="@path(admin_sondage_list)">
                <li class="item">
                    <i class="fas fa-question icon"></i>
                    Sondages
                </li>
            </a>
            <li class="item">
                <i class="fas fa-thumbtack icon"></i>
                <span>Utilisateurs</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
            <li class="item">
                <i class="fas fa-envelope icon"></i>
                <span>Newsletter</span>
                <ul class="submenu">
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                    <a href="#"><li>Menu item</li></a>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="additonal-list">
        <a href="#" class="additonal-list-button">
            <i class="far fa-cogs icon"></i>
            <span>
                Configuration
            </span>
        </a>
        <a href="#" class="additonal-list-button">
            <i class="fas fa-sign-out-alt icon"></i>
            <span>
                Déconnexion
            </span>
        </a>
    </div>
</div>
