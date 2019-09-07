<?php
/* Plugin name: Formaulaire Inscription
Plugin url: https://formeInscription.com
Author: Diami
Description: un plugin qui contient un formulaire d'inscription
Version:1.0
License: GPL2
*/
/**
  * 
  */
 class Plugin_Forme
 {
 	
 	function __construct()
 	{
 		include_once plugin_dir_path(__FILE__).'/form.php';
		new Forme();
		add_action('admin_menu',array($this,'add_menu'));
		/*add_action('wp_loaded',array('Forme','save_info'));*/
		register_activation_hook(__FILE__,array('Forme','install'));
		register_uninstall_hook(__FILE__,array('Forme','uninstall')); 
 	}

 	public function add_menu()
 	{
 		add_menu_page('Commentaire_Article','Comment_article','manage_options','comment',array($this,'menu_html'));
 	}
 	public function menu_html()
 	{
 		echo '<h1>'.get_admin_page_title().'</h1>';
 		echo '<p>voici les commentaires</p>';
 	}
 	

 } 
new Plugin_Forme();