<?php

/**
 * la classe pour la creation du formulaire
 */
class Forme
{
	
	function __construct()
	{
		add_shortcode('comment_Article',array($this,'creationForm'));
		add_action('wp_loaded', array($this, 'save_info'));
		add_action('admin_menu',array($this,'add_sub_menu'),20);

	}
	public function creationForm()
	{
		?>
		<form method="post" action=" ">
			<label for="prenom">Prenom</label><input type="text" name="prenom" id="prenom" />
			<label for="comment">Commentaire</label><input type="text" name="commentaire" id="comment"/>
			<label for="email">Email:</label><input type="email" name="email" id="email">
			<label for="site">Site internet</label><input type="url" name="site" id="site"/>
			<input type="submit" name="poster" value="Poster"/>
		</form>
<?php
	}
	public static function install()
	{
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_commentaireArticle (id INT AUTO_INCREMENT PRIMARY KEY, prenom VARCHAR(255) NOT NULL,comment VARCHAR(300) NOT NULL,email VARCHAR(50) NOT NULL,site VARCHAR(50) );");
	}
	public static function uninstall()
	{
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}_commentaireArticle ;");
	}
	public function save_info() //enregistrer les info du formulaire dans la db
	{
		
		if( (isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['commentaire']) && !empty($_POST['commentaire'])) && (isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['site']) && !empty($_POST['site'])) )
		{

			global $wpdb;
			$prenom = $_POST['prenom'];
			$comment = $_POST['commentaire'];
			$email = $_POST['email'];
			$site = $_POST['site'];

			$wpdb->insert("{$wpdb->prefix}_commentaireArticle", array('prenom'=> $prenom,
																	  'commentaire'=> $comment,
																	  'email' => $email,
																	  'site'=> $site) );

		}

		else 
			echo "echec d'insertion";

		
	}
	public function add_sub_menu()
	{
		add_submenu_page('comment','Commentaires','liste_commentaire','manage_options','commentliste',array($this,'submenu_html'));
	}
	public function submenu_html()
	{
		echo "<h1>".get_admin_page_title()."</h1>";
		echo "<p>La liste des commentaire poster</p>";
		
		global $wpdb;
		$wpdb->query("SELECT * FROM {$wpdb->prefix}_commentaireArticle;");

	}
	
}