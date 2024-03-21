<?php
/*
Plugin Name: Mon Plugin Bac Office
Description: Plugin pour la gestion du bac office (pizzas, grillades, etc.)
Version: 1.0
*/

add_action('admin_menu', 'hook');

function hook() {
    add_menu_page(
        'Gestion du Bac Office', // Titre de la page
        'Bac Office', // Titre du menu
        'manage_options', // Capability
        'bac-office', // Slug de la page
        'bac_office_page_content', // Fonction pour rendre la page
        '',
        2 // Position dans le menu
    );

    // Ajouter ici un sous-menu pour la gestion des pizzas
    add_submenu_page(
        'bac-office', // Slug du menu parent
        'Gestion des Pizzas', // Titre de la page
        'Pizzas', // Titre du sous-menu
        'manage_options', // Capability
        'bac-office&tab=pizzas', // Slug de la page - Définit l'onglet par défaut à afficher
        'bac_office_page_content' // Fonction pour afficher le contenu
    );
    add_submenu_page(
        'bac-office',
        'Gestion des Événements',
        'Événements',
        'manage_options',
        'bac-office&tab=evenements',
        'bac_office_page_content'
    );
	add_submenu_page(
		'bac-office',
		'Gestion des Partenaires',
		'Partenaires',
        'manage_options',
        'bac-office&tab=partenaires',
        'bac_office_page_content'
    );


}

function bac_office_page_content() {
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'pizzas';

    ?>
    <div class="wrap">
        <h2 class="nav-tab-wrapper">
            <a href="?page=bac-office&tab=produits" class="nav-tab <?php echo $tab == 'produits' ? 'nav-tab-active' : ''; ?>">Produits</a>
            <a href="?page=bac-office&tab=locataires" class="nav-tab <?php echo $tab == 'locataires' ? 'nav-tab-active' : ''; ?>">Locataires</a>
            <a href="?page=bac-office&tab=partenaires" class="nav-tab <?php echo $tab == 'partenaires' ? 'nav-tab-active' : ''; ?>">Partenaires</a>
            <a href="?page=bac-office&tab=commandes" class="nav-tab <?php echo $tab == 'commandes' ? 'nav-tab-active' : ''; ?>">Commandes</a>
            <a href="?page=bac-office&tab=clients" class="nav-tab <?php echo $tab == 'clients' ? 'nav-tab-active' : ''; ?>">Clients</a>
            <a href="?page=bac-office&tab=parametres" class="nav-tab <?php echo $tab == 'parametres' ? 'nav-tab-active' : ''; ?>">Paramètres</a>
        </h2>
        <?php
        switch ($tab) {
            case 'produits':
                include( dirname( __FILE__ ) . '/gestion_produits.php' );
                break;
            case 'locataires':
                include(dirname(__FILE__) . '/gestion_locataires.php');
                break;
            case 'partenaires':
                include(dirname(__FILE__) . '/gestion_partenaires.php');
                break;
        }
        ?>
    </div>
    <?php
}
?>
