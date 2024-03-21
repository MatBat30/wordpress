<?php
// Vérifiez toujours que le script est appelé depuis WordPress
if (!defined('ABSPATH')) {

	exit; // Exit if accessed directly
}



// Ajouter un produit
if (isset($_POST['produit_nonce']) && wp_verify_nonce($_POST['produit_nonce'], 'ajouter_produit')) {
    // Vérifier les autorisations

    // Obtenir l'ID du partenaire basé sur le nom sélectionné
	$nom_partenaire = $_POST['id_prestataires'];
	$type_prestation = $_POST['id_types_prestations'];
	global $wpdb;

	$partenaire = $wpdb->get_row($wpdb->prepare(
		"SELECT id_partenaire FROM {$wpdb->prefix}partenaires WHERE nom = %s AND types_prestations = %s",
		$nom_partenaire, $type_prestation
	));


	if ($partenaire) {
		$id_partenaire = $partenaire->id_partenaire;
	} else {
		echo '<div class="notice notice-error"><p>Erreur lors de la récupération du partenaire.</p></div>';
		return;
	}

	$nom_produit = sanitize_text_field($_POST['nom_produit']);
	$description = sanitize_textarea_field($_POST['description']);
	$prix = sanitize_text_field($_POST['prix']);
	$stock = intval($_POST['stock']);

	$data = [
		'id_partenaire' => $id_partenaire,
		'nom_produit' => $nom_produit,
		'description' => $description,
		'prix' => floatval($prix),
        'stock' => $stock,
		'categorie' => $type_prestation, // Utiliser le type de prestation comme catégorie
	];
	$format = ['%d', '%s', '%s', '%f', '%d', '%s'];

	$insert = $wpdb->insert("{$wpdb->prefix}produits", $data, $format);
	if (!$insert) {
		echo '<div class="notice notice-error"><p>Erreur lors de l\'ajout du produit. ' . $wpdb->last_error . '</p></div>';
	} else {
		echo '<div class="notice notice-success"><p>Produit ajouté avec succès.</p></div>';
	}
}

// Fonctions pour obtenir les types de prestations et les noms des prestataires
function get_types_prestations() {
	global $wpdb;
	$query = "SELECT DISTINCT types_prestations FROM {$wpdb->prefix}partenaires"; // Sans 's' à la fin
	return $wpdb->get_col($query);
}


function get_name_prestataires() {
	global $wpdb;
	$query = "SELECT DISTINCT nom FROM {$wpdb->prefix}partenaires";
	return $wpdb->get_col($query);
}




// Affichage du formulaire d'ajout de produit
?>
<div class="wrap">
    <h1>Gestion des Produits</h1>
    <div style="display: flex;">
        <div style="flex: 1; padding-right: 20px;">
            <h2>Ajouter un nouveau Produit</h2>
            <form method="post" action="">
	            <?php wp_nonce_field('ajouter_produit', 'produit_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="id_types_prestations">Catégorie</label></th>
                        <td>
                            <select name="id_types_prestations" id="id_types_prestations" class="regular-text" required>
                                <option value="">Choisir une catégorie</option>
								<?php foreach (get_types_prestations() as $type) : ?>
                                    <option value="<?php echo esc_attr($type); ?>"><?php echo esc_html($type); ?></option>
								<?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="id_prestataires">Partenaire</label></th>
                        <td>
                            <select name="id_prestataires" id="id_prestataires" class="regular-text" required>
                                <option value="">Choisir un prestataire</option>
								<?php foreach (get_name_prestataires() as $nom) : ?>
                                    <option value="<?php echo esc_attr($nom); ?>"><?php echo esc_html($nom); ?></option>
								<?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="nom_produit">Nom du produit</label></th>
                        <td><input name="nom_produit" id="nom_produit" type="text" class="regular-text" required /></td>
                    </tr>
                    <tr>
                        <th><label for="description">Description</label></th>
                        <td><textarea name="description" id="description" class="regular-text" required></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="prix">Prix</label></th>
                        <td><input name="prix" id="prix" type="text" class="regular-text" required /></td>
                    </tr>
                    <tr>
                        <th><label for="stock">Stock</label></th>
                        <td><input name="stock" id="stock" type="number" class="regular-text" required /></td>
                    </tr>
                </table>
				<?php submit_button('Ajouter Produit'); ?>
            </form>
        </div>
        <div style="flex: 1; padding-left: 20px;">
            <h2>Liste des Produits</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <th>Nom du produit</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Catégorie</th>
                    <th>Partenaire</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
			    <?php afficher_produits(); ?>
                </tbody>
            </table>
        </div>


    </div>
<?php
function afficher_produits() {
	global $wpdb;
	$produits = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}produits");

	if ($produits) {
		foreach ($produits as $produit) {
			// Récupérer le nom du partenaire
			$partenaire = $wpdb->get_var($wpdb->prepare(
				"SELECT nom FROM {$wpdb->prefix}partenaires WHERE id_partenaire = %d",
				$produit->id_partenaire
			));

			echo "
                <tr>
                    <td>{$produit->nom_produit}</td>
                    <td>{$produit->description}</td>
                    <td>{$produit->prix}</td>
                    <td>{$produit->stock}</td>
                    <td>{$produit->categorie}</td>
                    <td>{$partenaire}</td>
                    <td>
                        <a class='button btn-edit'  >Modifier</a>
                    </td>
                    <td>
                        <a class='button btn-edit' >Supprimer</a>
                    </td>
        
                
            </tr>";
		}
	}
}



