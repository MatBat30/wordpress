<?php
// Sécurité pour vérifier si le script est bien appelé depuis WordPress
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

// Vérification et exécution de la suppression
if ( isset( $_GET['delete'], $_REQUEST['_wpnonce'] ) && current_user_can( 'manage_options' ) ) {
	$partenaire_id = intval( $_GET['delete'] );
	$nonce_action  = 'delete-partenaire_' . $partenaire_id;

	if ( wp_verify_nonce( $_REQUEST['_wpnonce'], $nonce_action ) ) {
		$wpdb->delete( "{$wpdb->prefix}partenaires", [ 'id_partenaire' => $partenaire_id ], [ '%d' ] );
		echo '<div class="notice notice-success"><p>Partenaire supprimé avec succès.</p></div>';
	} else {
		echo '<div class="notice notice-error"><p>Erreur de vérification nonce.</p></div>';
	}
}

// Traitement du formulaire d'ajout
if ( isset( $_POST['nom_partenaire_ajouter'], $_POST['adresse_partenaire_ajouter'], $_POST['telephone_partenaire_ajouter'], $_POST['email_partenaire_ajouter'], $_POST['types_prestation_ajouter'], $_POST['partenaire_nonce'] ) && check_admin_referer( 'ajouter_partenaire', 'partenaire_nonce' ) && current_user_can( 'manage_options' ) ) {
	$nom              = sanitize_text_field( $_POST['nom_partenaire_ajouter'] );
	$adresse          = sanitize_text_field( $_POST['adresse_partenaire_ajouter'] );
	$telephone        = sanitize_text_field( $_POST['telephone_partenaire_ajouter'] );
	$email            = sanitize_email( $_POST['email_partenaire_ajouter'] );
	$types_prestation = sanitize_text_field( $_POST['types_prestation_ajouter'] );

	$data   = [
		'nom'              => $nom,
		'adresse'          => $adresse,
		'téléphone'        => $telephone,
		'email'            => $email,
		'types_prestation' => $types_prestation // Inclure 'types_prestation' ici
	];
	$format = [ '%s', '%s', '%s', '%s', '%s' ]; // Ajouter '%s' pour 'types_prestation'

	$insert=$wpdb->insert( "{$wpdb->prefix}partenaires", $data, $format );
    if ( ! $insert ) {
        echo '<div class="notice notice-error"><p>Erreur lors de l\'ajout. ' . $wpdb->last_error . '</p></div>';
    } else {
	    echo '<div class="notice notice-success"><p>Partenaire ajouté avec succès.</p></div>';

    }
}


// Modification d'un partenaire
if ( isset( $_POST['submit_edit'] ) && current_user_can( 'manage_options' ) ) {
	$id               = intval( $_POST['id_partenaire_update'] );
	$nom              = sanitize_text_field( $_POST['nom_partenaire_update'] );
	$adresse          = sanitize_text_field( $_POST['adresse_partenaire_update'] );
	$telephone        = sanitize_text_field( $_POST['telephone_partenaire_update'] );
	$email            = sanitize_email( $_POST['email_partenaire_update'] );
	$types_prestation = sanitize_text_field( $_POST['types_prestation_update'] );

	$updated = $wpdb->update(
		"{$wpdb->prefix}partenaires", // Assurez-vous que le préfixe de table est correct.
		[
			'nom'              => $nom,
			'adresse'          => $adresse,
			'téléphone'        => $telephone,
			'email'            => $email,
			'types_prestation' => $types_prestation
		],
		[ 'id_partenaire' => $id ], // Clé primaire pour identifier la ligne à mettre à jour.
		[ '%s', '%s', '%s', '%s', '%s' ], // Types des valeurs : s pour string (chaîne de caractères).
		[ '%d' ] // Type de la clé primaire.
	);

	if ( 0 === $updated ) {
		echo '<div class="notice notice-error"><p>Erreur lors de la mise à jour. ' . $wpdb->last_error . '</p></div>';
	} else {
		echo '<div class="notice notice-success"><p>Partenaire modifié avec succès.</p></div>';
	}
}
?>

<div class="wrap">
    <h1>Gestion des Partenaires</h1>
    <div style="display: flex;">
        <div style="flex: 1; padding-right: 20px;">
            <h2>Ajouter un nouveau Partenaire</h2>
            <form method="post" action="">
				<?php wp_nonce_field( 'ajouter_partenaire', 'partenaire_nonce' ); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="nom_partenaire_ajouter">Nom</label></th>
                        <td><input name="nom_partenaire_ajouter" id="nom_partenaire_ajouter" type="text" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th><label for="adresse_partenaire_ajouter">Adresse</label></th>
                        <td><input name="adresse_partenaire_ajouter" id="adresse_partenaire_ajouter" type="text" class="regular-text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="telephone_partenaire_ajouter">Téléphone</label></th>
                        <td><input name="telephone_partenaire_ajouter" id="telephone_partenaire_ajouter" type="text"
                                   class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th><label for="email_partenaire_ajouter">Email</label></th>
                        <td><input name="email_partenaire_ajouter" id="email_partenaire_ajouter" type="email" class="regular-text"/>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="types_prestation_ajouter">Types de prestation</label></th>
                        <td><input name="types_prestation_ajouter" id="types_prestation_ajouter" type="text" class="regular-text"/></td>
                    </tr>

                </table>
				<?php submit_button( 'Ajouter Partenaire' ); ?>
            </form>
        </div>
        <div style="flex: 1; padding-left: 20px;">
            <h2>Liste des Partenaires</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Types de prestation</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
				<?php afficher_partenaires(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="editPartenaire" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" action="">
            <input type="hidden" name="id_partenaire_update" id="partenaire_id_update" value=" " >
            <h2>Modifier Partenaire</h2>
            <table class="form-table">
                <tr>
                    <th><label for="nom_partenaire_update">Nom</label></th>
                    <td><input name="nom_partenaire_update" id="nom_partenaire_update" type="text" class="regular-text"/></td>
                </tr>
                <tr>
                    <th><label for="adresse_partenaire_update">Adresse</label></th>
                    <td><input name="adresse_partenaire_update" id="adresse_partenaire_update" type="text" class="regular-text"/></td>
                </tr>
                <tr>
                    <th><label for="telephone_partenaire_update">Téléphone</label></th>
                    <td><input name="telephone_partenaire_update" id="telephone_partenaire_update" type="text" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="email_partenaire_update">Email</label></th>
                    <td><input name="email_partenaire_update" id="email_partenaire_update" type="email" class="regular-text"/></td>
                </tr>
                <tr>
                    <th><label for="types_prestation_update">Types de prestation</label></th>
                    <td><input name="types_prestation_update" id="types_prestation_update" type="text" class="regular-text"/></td>
                </tr>
            </table>
            <input type="submit" name="submit_edit" value="Modifier Partenaire" class="button">

        </form>
    </div>
</div>


<?php
function afficher_partenaires() {
	global $wpdb;
	$partenaires = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}partenaires" );
	foreach ( $partenaires as $partenaire ) {
		$delete_nonce = wp_create_nonce( 'delete-partenaire_' . $partenaire->id_partenaire );
		echo "<tr>
        <td>{$partenaire->nom}</td>
        <td>{$partenaire->adresse}</td>
        <td>{$partenaire->téléphone}</td>
        <td>{$partenaire->email}</td>
        <td>{$partenaire->types_prestations}</td>
        <td>
            <a href='#' class='button btn-edit' data-id='{$partenaire->id_partenaire}' data-name='{$partenaire->nom}' data-adresse='{$partenaire->adresse}' data-telephone='{$partenaire->téléphone}' data-email='{$partenaire->email}' data-types='{$partenaire->types_prestations}' >Modifier</a>
        </td>
        <td>
            <a href='" . wp_nonce_url( admin_url( 'admin.php?page=bac-office&tab=partenaires&delete=' . $partenaire->id_partenaire ), 'delete-partenaire_' . $partenaire->id_partenaire ) . "' class='button'>Supprimer</a>
        </td>
      </tr>";

	}
}

?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.btn-edit').click(function () {
            // Récupérer les données de l'élément cliqué
            var partenaire_id = $(this).data('id');
            var nom_partenaire = $(this).data('name');
            var adresse_partenaire = $(this).data('adresse');
            var telephone_partenaire = $(this).data('telephone');
            var email_partenaire = $(this).data('email');
            var types_prestation = $(this).data('types');

            // Remplir les champs du formulaire dans la modal
            $('#editPartenaire #nom_partenaire_update').val(nom_partenaire);
            $('#editPartenaire #adresse_partenaire_update').val(adresse_partenaire);
            $('#editPartenaire #telephone_partenaire_update').val(telephone_partenaire);
            $('#editPartenaire #email_partenaire_update').val(email_partenaire);
            $('#editPartenaire #types_prestation_update').val(types_prestation);
            $('#editPartenaire #partenaire_id_update').val(partenaire_id); // S'assurer que cette ligne est correcte

            // Afficher la modal
            $('#editPartenaire').show();
        });

        // Fermer la modal quand on clique sur .close
        $('#editPartenaire .close').click(function () {
            $('#editPartenaire').hide();
        });

        // Fermer la modal quand on clique en dehors de celle-ci
        $(window).click(function (event) {
            if ($(event.target).is('#editPartenaire')) {
                $('#editPartenaire').hide();
            }
        });
    });

</script>

