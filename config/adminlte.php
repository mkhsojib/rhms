<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Ruqyah & Hijama Center',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Ruqyah</b> & Hijama',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Ruqyah & Hijama Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        
        // Dashboard
        [
            'text' => 'Dashboard',
            'url' => 'home',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        // Super Admin Menu Items
        [
            'text' => 'User Management',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Users',
                    'url' => 'superadmin/users',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add New User',
                    'url' => 'superadmin/users/create',
                    'icon' => 'fas fa-fw fa-user-plus',
                ],
            ],
        ],

        [
            'text' => 'System Settings',
            'icon' => 'fas fa-fw fa-cogs',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Settings',
                    'url' => '/superadmin/settings',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'General Settings',
                    'url' => '/superadmin/settings/general',
                    'icon' => 'fas fa-fw fa-cog',
                ],
                [
                    'text' => 'Appearance',
                    'url' => '/superadmin/settings/appearance',
                    'icon' => 'fas fa-fw fa-palette',
                ],
                [
                    'text' => 'System Settings',
                    'url' => '/superadmin/settings/system',
                    'icon' => 'fas fa-fw fa-server',
                ],
                [
                    'text' => 'Business Settings',
                    'url' => '/superadmin/settings/business',
                    'icon' => 'fas fa-fw fa-briefcase',
                ],
            ],
        ],

        // Admin (Raqi) Menu Items
        [
            'text' => 'Appointments',
            'icon' => 'fas fa-fw fa-calendar-check',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'My Appointments',
                    'url' => 'admin/appointments',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Appointment',
                    'url' => 'admin/appointments/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],
        
        [
            'text' => 'My Availability',
            'icon' => 'fas fa-fw fa-clock',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'View Availability',
                    'url' => 'admin/availability',
                    'icon' => 'fas fa-fw fa-calendar-alt',
                ],
                [
                    'text' => 'Set Availability',
                    'url' => 'admin/availability/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Treatments',
            'icon' => 'fas fa-fw fa-hand-holding-medical',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Treatment Records',
                    'url' => 'admin/treatments',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Treatment',
                    'url' => 'admin/treatments/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        // Super Admin can also see Admin menus
        [
            'text' => 'Appointments (All)',
            'icon' => 'fas fa-fw fa-calendar-check',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Appointments',
                    'url' => '/superadmin/appointments',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Appointment',
                    'url' => '/superadmin/appointments/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Treatments (All)',
            'icon' => 'fas fa-fw fa-hand-holding-medical',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Treatments',
                    'url' => '/superadmin/treatments',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Treatment',
                    'url' => '/superadmin/treatments/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Blog Management',
            'icon' => 'fas fa-fw fa-blog',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Blogs',
                    'url' => '/superadmin/blogs',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Blog',
                    'url' => '/superadmin/blogs/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Category Management',
            'icon' => 'fas fa-fw fa-tags',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Categories',
                    'url' => '/superadmin/categories',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create Category',
                    'url' => '/superadmin/categories/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Website Management',
            'icon' => 'fas fa-fw fa-globe',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'Contact Information',
                    'url' => '/superadmin/contact-information',
                    'icon' => 'fas fa-fw fa-address-book',
                ],
                [
                    'text' => 'Contact Form Submissions',
                    'url' => '/superadmin/contact-form-submissions',
                    'icon' => 'fas fa-fw fa-envelope',
                ],
            ],
        ],

        [
            'text' => 'Raqis Available Time',
            'icon' => 'fas fa-fw fa-clock',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'All Availability',
                    'url' => '/superadmin/raqi-availability',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add Availability',
                    'url' => '/superadmin/raqi-availability/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Questions Management',
            'url'  => 'superadmin/questions',
            'icon' => 'fas fa-question-circle',
            'can'  => 'super_admin',
        ],

        [
            'text' => 'Invoices',
            'url'  => 'superadmin/invoices',
            'icon' => 'fas fa-file-invoice',
            'can'  => 'super_admin',
        ],
        [
            'text' => 'Invoices',
            'url'  => 'admin/invoices',
            'icon' => 'fas fa-file-invoice',
            'can'  => 'admin',
        ],

        // Accounting
        [
            'text' => 'Accounting',
            'icon' => 'fas fa-fw fa-money-bill-wave',
            'can' => 'super_admin',
            'submenu' => [
                [
                    'text' => 'Bank Accounts',
                    'url'  => 'superadmin/bank-accounts',
                    'icon' => 'fas fa-university',
                ],
                [
                    'text' => 'Cash In/Out',
                    'url'  => 'superadmin/cash-flows',
                    'icon' => 'fas fa-exchange-alt',
                ],
                [
                    'text' => 'Transactions',
                    'url'  => 'superadmin/transactions',
                    'icon' => 'fas fa-exchange-alt',
                ],
                [
                    'text' => 'Payments',
                    'url'  => 'superadmin/payments',
                    'icon' => 'fas fa-file-invoice',
                ],
            ],
        ],

        // Account Settings
        ['header' => 'Account Settings'],
        [
            'text' => 'Profile',
            'url' => 'admin/profile',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'admin-profile',
        ],
        [
            'text' => 'Change Password',
            'url' => 'admin/profile/change-password',
            'icon' => 'fas fa-fw fa-lock',
            'can' => 'admin-profile',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
