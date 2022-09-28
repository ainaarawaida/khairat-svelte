<?php



add_action( 'rest_api_init', 'khai_check_user');
function khai_check_user(){
    global $wpdb ; 

	// $GLOBALS['khai_temp_data']['user_id'] = wp_get_current_user(); //<- production
    $GLOBALS['khai_temp_data']['user_id'] =  get_user_by( 'id', 22 ); // development

	$GLOBALS['khai_temp_data']['stage_daftar'] = get_user_meta( $GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', true ) ;
	$GLOBALS['khai_temp_data']['logout_url'] = wp_logout_url( get_permalink() ); //<- production


    //dapatkan maklumat kariah bagi pentadbir yg dah daftar
    if (array_key_exists("pentadbir", $GLOBALS['khai_temp_data']['user_id']->caps) && $GLOBALS['khai_temp_data']['stage_daftar'] > 0){
         $check_author_site_name = $wpdb->get_results( 
            $wpdb->prepare("SELECT ID,post_name,post_title FROM {$wpdb->prefix}posts WHERE post_type =%s AND post_author = %d", array('khai_page_name', $GLOBALS['khai_temp_data']['user_id']->ID)) 
        );

        if($check_author_site_name){
            $GLOBALS['khai_temp_data']['kariah'] = $check_author_site_name ;
            $GLOBALS['khai_temp_data']['kariah'][0]->alamat_kariah = get_post_meta(  $check_author_site_name[0]->ID, 'alamat_kariah', true ) ;
          
        }
        
    }
   
    if($_POST['action'] && $_POST['action'] === 'daftarkariah'){
        $GLOBALS['khai_temp_data']['submitpost']['error'] = false ; 

        $check_author_site_name = $wpdb->get_results( 
            $wpdb->prepare("SELECT ID,post_name,post_title FROM {$wpdb->prefix}posts WHERE post_type =%s AND post_author = %d", array('khai_page_name', $GLOBALS['khai_temp_data']['user_id']->ID)) 
        );
        
        $check_exist_post_title = $wpdb->get_results( 
            $wpdb->prepare("SELECT ID,post_author FROM {$wpdb->prefix}posts WHERE post_type =%s AND (post_title = %s)", array('khai_page_name', wp_strip_all_tags( $_POST['kariah_name'] ))) 
        );

        $check_exist_site_name = $wpdb->get_results( 
                $wpdb->prepare("SELECT ID,post_author FROM {$wpdb->prefix}posts WHERE post_type =%s AND (post_name = %s)", array('khai_page_name', str_replace(' ', '-', strtolower($_POST['site_page_url'])))) 
            );

             $my_post = array(
                        'post_title'    => wp_strip_all_tags( $_POST['kariah_name'] ),
                        'post_content'  => '',
                        'post_status'   => 'publish',
                        'post_author'   => $GLOBALS['khai_temp_data']['user_id']->ID,
                        'post_type' => 'khai_page_name',
                        'post_name' => $_POST['site_page_url']
                    );

            $condition = '';
            $GLOBALS['khai_temp_data']['submitpost']['error'] = array() ; 

            if(!$check_author_site_name && !$check_exist_post_title && !$check_exist_site_name){
                $condition = 'data0nama0url0';
                $my_post['ID'] =  wp_insert_post( $my_post );
                update_post_meta($my_post['ID'], 'alamat_kariah', $_POST['alamat_kariah']) ; 
                update_user_meta($GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', 1) ; 
            }
            if(!$check_author_site_name && !$check_exist_post_title && $check_exist_site_name){
                 $condition = 'data0nama0url1';
                 $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Site URL telah wujud' ; 
            }
            if(!$check_author_site_name && $check_exist_post_title && !$check_exist_site_name){
                 $condition = 'data0nama1url0';
                $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Nama Kariah telah wujud' ; 
            }
             if(!$check_author_site_name && $check_exist_post_title && $check_exist_site_name){
                 $condition = 'data0nama1url1';
                 $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Nama Kariah telah wujud' ; 
                 $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Site URL telah wujud' ; 
            }
             if($check_author_site_name && !$check_exist_post_title && !$check_exist_site_name){
                $condition = 'data1nama0url0';
                $my_post['ID'] = $check_author_site_name[0]->ID;
               
                wp_update_post( $my_post );
                update_post_meta($my_post['ID'], 'alamat_kariah', $_POST['alamat_kariah']) ; 
                update_user_meta($GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', 1) ; 
            }
             if($check_author_site_name && !$check_exist_post_title && $check_exist_site_name){
                 $condition = 'data1nama0url1';
                    $my_post['ID'] = $check_author_site_name[0]->ID;
                if($check_author_site_name[0]->post_name ===  str_replace(' ', '-', strtolower($_POST['site_page_url']))){
                    
                    wp_update_post( $my_post );
                    update_post_meta($my_post['ID'], 'alamat_kariah', $_POST['alamat_kariah']) ; 
                    update_user_meta($GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', 1) ; 
                }else{
                    $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Site URL telah wujud' ; 
                }

            }
            if($check_author_site_name && $check_exist_post_title && !$check_exist_site_name){
                 $condition = 'data1nama1url0';
                  $my_post['ID'] = $check_author_site_name[0]->ID;
                   if($check_author_site_name[0]->post_title ===  wp_strip_all_tags( $_POST['kariah_name'] ) ){
                      
                        wp_update_post( $my_post );
                        update_post_meta($my_post['ID'], 'alamat_kariah', $_POST['alamat_kariah']) ; 
                        update_user_meta($GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', 1) ; 
                    }else{
                        $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Nama Kariah telah wujud' ; 
                    }

            }
            if($check_author_site_name && $check_exist_post_title && $check_exist_site_name){
                 $condition = 'data1nama1url1';
                  $my_post['ID'] = $check_author_site_name[0]->ID;
                if($check_author_site_name[0]->post_name ===  str_replace(' ', '-', strtolower($_POST['site_page_url']))){
                    if($check_author_site_name[0]->post_title ===  wp_strip_all_tags( $_POST['kariah_name'] ) ){
                        
                        wp_update_post( $my_post );
                        update_post_meta($my_post['ID'], 'alamat_kariah', $_POST['alamat_kariah']) ; 
                        update_user_meta($GLOBALS['khai_temp_data']['user_id']->ID, 'stage_daftar', 1) ; 
                    }else{
                        $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Nama Kariah telah wujud' ; 
                    }
                }else{
                  
                    $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Site URL telah wujud' ; 
                    if($check_author_site_name[0]->post_title !==  wp_strip_all_tags( $_POST['kariah_name'] ) ){
                        $GLOBALS['khai_temp_data']['submitpost']['error'][] = 'Nama Kariah telah wujud' ; 
                    }
                }


            }


           
            
    }
   


     register_rest_route( 'api/v1', '/data', array(
            'methods' => 'POST',
            'callback' => 'khai_check_user_callback'
        ));

        //http://khairat.test/wp-json/api/v1/data
}

function khai_check_user_callback(){
    return json_encode($GLOBALS['khai_temp_data']); 
}




//http://khairat.test/wp-json/khai_api/v1/data
add_action( 'rest_api_init', 'khai_rest_api_init' );
function khai_rest_api_init() {

   
	//  $GLOBALS['khai_temp_data']['user_id'] =  get_user_by( 'id', 1 ); // development
		$GLOBALS['khai_temp_data']['user_id'] = wp_get_current_user(); //<- production
		$GLOBALS['khai_temp_data']['logout_url'] = wp_logout_url( get_permalink() ); //<- production
	
	
    register_rest_route( 'khai_api/v1', 'data', array(
        'methods' => 'GET',
        'callback' => 'khai_api_callback',
    ) );
}
function khai_api_callback( $request ) {

    return  json_encode($GLOBALS['khai_temp_data']); 
}








?>