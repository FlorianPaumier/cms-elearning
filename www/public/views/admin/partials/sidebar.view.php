<?php
    $menus = [
        "Tableau de bord" => [
            "pictogramme" => "fas fa-home icon",
            "menu" => [
                [
                    "link" => "@path(admin_home)",
                    "name" => "Dashboard"
                ],
            ]
        ],
        "Article" => [
            "pictogramme" => "fas fa-file icon",
            "menu" => [
                [
                    "link" => "@path(admin_article_list)",
                    "name" => "Article"
                ],
            ]
        ],
        "Cours" => [
            "pictogramme" => "fas fa-books icon",
            "menu" => [
                [
                    "link" => "@path(admin_lesson_list)",
                    "name" => "Cours"
                ],
                [
                    "link" => "@path(admin_lesson_chapter_index)",
                    "name" => "Chapitres"
                ],
                [
                    "link" => "@path(admin_notation_index)",
                    "name" => "Notations"
                ],
                [
                    "link" => "@path(admin_evaluation_list)",
                    "name" => "Evaluation"
                ]
            ]
        ],
        "Evenements" => [
            "pictogramme" => "fas fa-calendat-alt icon",
            "menu" => [
                [
                    "link" => "@path(admin_events_list)",
                    "name" => "Evenements"
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
        "Contact" => [
            "pictogramme" => "fas fa-thumbtack icon",
            "menu" => [
                [
                    "link" => "@path(admin_contact_list)",
                    "name" => "Liste Contact"
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
                    "link" => "@path(admin_user_list)",
                    "name" => "Utilisateur"
                ],
            ]
        ],
        "Newsletter" => [
            "pictogramme" => "fas fa-envelope icon",
            "menu" => [
                [
                    "link" => "@path(admin_newsletter)",
                    "name" => "Newsletter"
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
                        <a href="<?= $button['link'] ?>"><li><?= $button['name'] ?></li></a>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="additonal-list">
        <a href="@path(admin_config)" class="additonal-list-button">
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
