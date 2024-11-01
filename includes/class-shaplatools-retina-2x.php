<?php

if ( ! class_exists('ShaplaTools_Retina_2x')):

class ShaplaTools_Retina_2x
{
    /**
     * initialization of class
     * @param string $plugin_url
     */
	public function __construct() {

        if (is_admin()) {
            add_filter( 'wp_generate_attachment_metadata', array( $this, 'retina_attachment_metadata' ), 10, 2 );
            add_filter( 'delete_attachment', array( $this, 'delete_retina_image' ));
        }
	}

    /**
     * if the uploaded file is an image, create retina image
     * 
     * @param  array    $metadata      An array of attachment meta data.
     * @param  integer  $attachment_id  Current attachment ID.
     * 
     * @return array
     */
	public function retina_attachment_metadata( $metadata, $attachment_id ) {
        foreach ( $metadata as $key => $value ) {
            if ( is_array( $value ) ) {
                foreach ( $value as $image => $attr ) {
                    if ( is_array( $attr ) && isset($attr['width'],$attr['height']) ){
                        $this->create_retina_image(
                            get_attached_file( $attachment_id ),
                            $attr['width'],
                            $attr['height'],
                            true
                        );
                    }
                }
            }
        }
     
        return $metadata;
    }

    /**
     * Create a retina-ready higher quality image
     * 
     * @param  string   $file    The file path to the attached file. 
     * @param  integer  $width   The original width of image
     * @param  integer  $height  The original height of image
     * @param  boolean  $crop
     * 
     * @return boolean|array
     */
    public function create_retina_image( $file, $width, $height, $crop = false ) {
        if ( $width || $height ) {
            $resized_file = wp_get_image_editor( $file );
            if ( ! is_wp_error( $resized_file ) ) {
                $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
     
                $resized_file->resize( $width * 2, $height * 2, $crop );
                $resized_file->save( $filename );
     
                $info = $resized_file->get_size();
     
                return array(
                    'file' => wp_basename( $filename ),
                    'width' => $info['width'],
                    'height' => $info['height'],
                );
            }
        }
        return false;
    }

    /**
     * Delete retina-ready images
     *
     * If a user deletes an image from the Media Library,
     * trash all the extra retina-ready images that were created too.
     */
    public function delete_retina_image( $attachment_id ) {
        $meta = wp_get_attachment_metadata( $attachment_id );
        if (is_array($meta)) {
            $upload_dir = wp_upload_dir();
            $path = pathinfo( $meta['file'] );
            foreach ( $meta as $key => $value ) {
                if ( 'sizes' === $key ) {
                    foreach ( $value as $sizes => $size ) {
                        $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                        $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
                        if ( file_exists( $retina_filename ) )
                            unlink( $retina_filename );
                    }
                }
            }
        }
    }
}

endif;