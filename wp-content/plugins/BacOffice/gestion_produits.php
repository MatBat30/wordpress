<?php
// Sécurité pour vérifier si le script est bien appelé depuis WordPress
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


// Fonction pour obtenir les types de prestation disponibles
function get_types_prestation() {
    global $wpdb;
	$table_name = $wpdb->prefix . 'partenaires'; // Assurez-vous que le préfixe de table correspond à votre installation WordPress

	$query = "SELECT DISTINCT types_prestations FROM $table_name";

    return $wpdb->get_col($query);
}
function get_prestataires($type_prestation) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'partenaires'; // Assurez-vous que le préfixe de table correspond à votre installation WordPress

	$query = "SELECT DISTINCT nom FROM $table_name WHERE types_prestations = $type_prestation ";

	return $wpdb->get_col($query);
}
?>
<div class="wrap">
    <h1>Gestion des Produits</h1>
    <div style="display: flex;">
        <div style="flex: 1; padding-right: 20px;">
            <h2>Ajouter un nouveau Produit</h2>
            <form method="post" action="">
				<?php wp_nonce_field('ajouter_produit', 'produit_nonce'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="nom_produit">Nom du Produit</label></th>
                            <td><input type="text" name="nom_produit" id="nom_produit" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="prix_produit">Prix du Produit</label></th>
                            <td><input type="number" name="prix_produit" id="prix_produit" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="description_produit">Description du Produit</label></th>
                            <td><textarea name="description_produit" id="description_produit" class="regular-text" required></textarea></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="type_produit">Categorie de Produit</label></th>
                            <td>
                                <select name="type_produit" id="type_produit" required>
                                    <option value="">Choisir une categorie de produit</option>
			                        <?php foreach (get_types_prestation() as $type) : ?>
                                        <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
			                        <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <?php

                        ?>
                    </tbody>

                </table>
				<?php submit_button('Ajouter Produit'); ?>
            </form>
        </div>
</div>
<script>

</script>


