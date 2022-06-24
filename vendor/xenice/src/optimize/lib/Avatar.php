<?php
namespace xenice\optimize\lib;

use xenice\theme\Theme;

class Avatar
{
 	private $user_id_being_edited;
 
	public function __construct()
	{
		add_filter( 'get_avatar', [$this, 'get'], 10, 5 );
 	    add_filter( 'user_profile_picture_description', [$this, 'edit'], 10, 2 );
		add_action( 'personal_options_update', [$this, 'set']);
		add_action( 'edit_user_profile_update', [$this, 'set']);
		add_action( 'admin_footer', [$this, 'footer']);

	}
 
	public function get( $avatar = '', $id_or_email = null, $size = 96, $default = '', $alt = false )
	{
		if ( is_numeric($id_or_email) )
			$user_id = (int) $id_or_email;
		elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) )
			$user_id = $user->ID;
		elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) )
			$user_id = (int) $id_or_email->user_id;
 
		if ( empty( $user_id ) )
			return $avatar;
         
        $p = Theme::new("user_pointer", $user_id);
		$local_avatars = $p->getValue('local_avatar');
 
		if ( empty( $local_avatars ) || empty( $local_avatars['full'] ) )
			return $avatar;
 
		$size = (int) $size;
 
		if ( empty( $alt ) )
			$alt = get_the_author_meta( 'display_name', $user_id );
 
		// generate a new size
		if ( empty( $local_avatars[$size] ) ) {
			$upload_path = wp_upload_dir();
			$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $local_avatars['full'] );
			$image_sized = image_resize( $avatar_full_path, $size, $size, true );		
			// deal with original being >= to original image (or lack of sizing ability)
			$local_avatars[$size] = is_wp_error($image_sized) ? $local_avatars[$size] = $local_avatars['full'] : str_replace( $upload_path['basedir'], $upload_path['baseurl'], $image_sized );	
			// save updated avatar sizes
			$p->setValue('local_avatar', $local_avatars);
		} elseif ( substr( $local_avatars[$size], 0, 4 ) != 'http' ) {
			$local_avatars[$size] = home_url( $local_avatars[$size] );
		}
 
		$author_class = is_author( $user_id ) ? ' current-author' : '' ;
		$avatar = "<img alt='" . esc_attr( $alt ) . "' src='" . $local_avatars[$size] . "' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";
 
		return Theme::call( 'local_avatar', $avatar, $p);
	}
 
	public function edit($description, $profileuser ) 
	{
		if (current_user_can('upload_files')){
		    $p = Theme::new('user_pointer', $profileuser->ID);
			Theme::call('local_avatar_notices', $p); 
			wp_nonce_field( 'xenice_local_avatar_nonce', 'xenice_local_avatar_nonce', false ); 
			$description = '<input type="file" name="xenice-local-avatar" id="xenice-local-avatar" onchange="previewImage()"/><br />';
			if ($p->getValue('local_avatar'))
    			$description .= '
    					<input type="checkbox" name="xenice-local-avatar-erase" value="1" /> ' . _t('Delete local avatar') . '<br />
    					<span class="description">' . _t('Replace the local avatar by uploading a new avatar, or erase the local avatar (falling back to a gravatar) by checking the delete option.') . '</span>
    				';
			else 
				$description .= '<span class="description">' . _t('No local avatar is set. Use the upload field to add a local avatar.') . '</span>';	
		}
		return $description;
	}
 
	public function set($user_id )
	{
	    
		if ( !isset( $_POST['xenice_local_avatar_nonce'] ) || ! wp_verify_nonce( $_POST['xenice_local_avatar_nonce'], 'xenice_local_avatar_nonce' ) )			
			return;
	    
		$p = Theme::new('user_pointer', $user_id);
		
		if ( ! empty( $_FILES['xenice-local-avatar']['name'] ) ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
				'bmp' => 'image/bmp',
				'tif|tiff' => 'image/tiff'
			);
 
			if ( ! function_exists( 'wp_handle_upload' ) )
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
            
			$this->delete($p);	// delete old images if successful
			
			// need to be more secure since low privelege users can upload
			if ( strstr( $_FILES['xenice-local-avatar']['name'], '.php' ) )
				wp_die('For security reasons, the extension ".php" cannot be in your file name.');
 
			$this->user_id_being_edited = $user_id; // make user_id known to unique_filename_callback function
			
			$avatar = wp_handle_upload( $_FILES['xenice-local-avatar'],['mimes' => $mimes, 'test_form' => false, 'unique_filename_callback' => [ $this, 'uniqueFilenameCallback']] );
			;
			if ( empty($avatar['file']) ) {		// handle failures
				switch ( $avatar['error'] ) {
					case 'File type does not meet security guidelines. Try another.' :
						add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error",_t("Please upload a valid image file for the avatar."));') );				
						break;
					default :
						add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error","<strong>"._t("There was an error uploading the avatar:")."</strong> ' . esc_attr( $avatar['error'] ) . '");') );
				}
				return;
			}
            $p->setValue('local_avatar', ['full' => $avatar['url']]);
		} elseif ($_POST['xenice-local-avatar-erase']) {
			$this->delete($p);
		}
	}
 
	/**
	 * delete avatars based on user_id
	 */
	public function delete($user_pointer )
	{
		$old_avatars = $user_pointer->getValue('local_avatar');
		$upload_path = wp_upload_dir();
 
		if ( is_array($old_avatars) ) {
			foreach ($old_avatars as $old_avatar ) {
				$old_avatar_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $old_avatar );
				@unlink( $old_avatar_path );	
			}
		}
        $user_pointer->setValue('local_avatar','');
	}
 
	public function uniquFilenameCallback( $dir, $name, $ext )
	{
		$user = get_user_by( 'id', (int) $this->user_id_being_edited ); 
		$name = $base_name = sanitize_file_name( $user->display_name . '_avatar' );
		$number = 1;
 
		while ( file_exists( $dir . "/$name$ext" ) ) {
			$name = $base_name . '_' . $number;
			$number++;
		}
 
		return $name . $ext;
	}
	
	public function footer()
	{
	    ?>
	    <script>
	    var form = document.getElementById('your-profile');
	    form.encoding = 'multipart/form-data';
	    form.setAttribute('enctype', 'multipart/form-data');
	    
	    function previewImage()
	    {
          var preview = document.querySelector('td .photo');
          var file    = document.querySelector('#xenice-local-avatar').files[0];
          var reader  = new FileReader();
        
          reader.onloadend = function () {
            preview.src = reader.result;
          }
        
          if (file) {
            reader.readAsDataURL(file);
          } else {
            preview.src = "";
          }
        }
        </script>
	    <?php
	}
}