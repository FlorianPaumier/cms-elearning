<?php
    $menus = [
        "Tableau de bord" => [
            "pictogramme" => "fas fa-home icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "Page" => [
            "pictogramme" => "fas fa-file icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "Article" => [
            "pictogramme" => "fas fa-file icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "Cours" => [
            "pictogramme" => "fas fa-books icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "Evenements" => [
            "pictogramme" => "fas fa-calendat-alt icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "FAQ" => [
            "pictogramme" => "fas fa-thumbtack icon",
            "menu" => [
                [
                    "link" => "/admin/faq",
                    "name" => "Gestion des FAQ"
                ],
            ]
        ],
        "Sondages" => [
            "pictogramme" => "fas fa-question icon",
            "menu" => [
                [
                    "link" => "/admin/sondage",
                    "name" => "Gestion des sondages"
                ],
            ]
        ],
        "Utilisateurs" => [
            "pictogramme" => "fas fa-thumbtack icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
        "Newsletter" => [
            "pictogramme" => "fas fa-envelope icon",
            "menu" => [
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
                [
                    "link" => "#",
                    "name" => "Menu Item"
                ],
            ]
        ],
    ];
?>
<div class="sidebar-tmp"></div>
<div class="sidebar">
    <div class="logo">
        <img src="/assets/images/logo.png" alt="CMS-ELEARNING">
    </div>
    <nav>
        <ul>
            <?php foreach ($menus as $menu => $buttons): ?>
                <li class="item">
                    <i class="<?= $buttons['pictogramme'] ?>>"></i>
                    <span><?= $menu ?></span>
                    <ul class="submenu">
                        <?php foreach ($buttons['menu'] as $button): ?>
                        <a href="<?php $button['link'] ?>"><li><?= $button['name'] ?></li></a>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
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
