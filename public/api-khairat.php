<?php



add_action( 'rest_api_init', 'khai_check_user');
function khai_check_user(){
     register_rest_route( 'api/v1', '/data', array(
            'methods' => 'POST',
            'callback' => 'khai_check_user_callback'
        ));

        //http://khairat.test/wp-json/api/v1/data
}

function khai_check_user_callback(){


    $_POST['test'] = 'nothing' ;

    


$current_user = wp_get_current_user() ; 
$stage_daftar = get_user_meta( get_current_user_id(), 'stage_daftar', true ) ;
		
	
		// deb(array_key_exists('pentadbir', $current_user->allcaps));
		// deb($current_user);exit();
	
		if ( array_key_exists('pentadbir', $current_user->allcaps)){
	
			if($stage_daftar == 0){
				
					// Change the redirection Url
					// $redirection_url = get_home_url()."/my-account/daftarkariah";
					
			}
		}

		if ( array_key_exists('ahli', $current_user->allcaps)){
	
			if($stage_daftar == 0){
					// Change the redirection Url
					// $redirection_url = get_home_url()."/my-account/daftarahli"; 
			}
		}
		

        
 $_POST['current_user'] = 'ddd' ;



    return json_encode($_POST) ;
}





add_action( 'rest_api_init', 'khai_check_login_user' );
function khai_check_login_user() {

     $GLOBALS['khai_user_id'] = wp_get_current_user(); //<- add this


    register_rest_route( 'khai_check_login_user/v1', 'data/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'khai_check_login_user_callback'
    ) );
}
function khai_check_login_user_callback( $request ) {
    return  $GLOBALS['khai_user_id']; 
}



?>