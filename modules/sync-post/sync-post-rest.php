<?php

/**
 * Manages the synchronization of posts across languages through the REST API
 *
 * @since 2.6
 */
class PLL_Sync_Post_REST {
	public $model, $sync_model;

	/**
	 * Constructor
	 *
	 * @since 2.6
	 *
	 * @param object $polylang Polylang object.
	 */
	public function __construct( &$polylang ) {
		$this->model = &$polylang->model;

		$this->sync_model = new PLL_Sync_Post_Model( $polylang );

		add_filter( 'pll_rest_translations_table', array( $this, 'translations_table' ), 10, 3 );
		add_action( 'rest_api_init', array( $this, 'init' ), 20 ); // After PLL_REST_API.
	}

	/**
	 * Register the 'pll_sync_post' REST field
	 *
	 * @since 2.6
	 */
	public function init() {
		foreach ( $this->model->get_translated_post_types() as $type ) {
			register_rest_field(
				$type,
				'pll_sync_post',
				array(
					'get_callback'    => array( $this, 'get_synchronizations' ),
					'update_callback' => array( $this, 'sync_posts' ),
					'schema'          => array(
						'pll_sync_post' => __( 'Synchronizations', 'polylang-pro' ),
						'type' => 'object',
					),
				)
			);

			add_action( "rest_after_insert_{$type}", array( $this, 'after_insert_post' ), 10, 2 );
		}
	}

	/**
	 * Returns the object synchronizations
	 *
	 * @since 2.4
	 *
	 * @param array $object Arry of post properties.
	 * @return array
	 */
	public function get_synchronizations( $object ) {
		return array_fill_keys( array_keys( $this->sync_model->get( $object['id'] ) ), true );
	}

	/**
	 * Update the post synchronization group
	 *
	 * @since 2.6
	 *
	 * @param array  $sync_post Array of synchronizations with language code as key and 'true' as value.
	 * @param object $object    The WP_Post object.
	 * @return bool
	 */
	public function sync_posts( $sync_post, $object ) {
		$post_id = (int) $object->ID;

		if ( empty( $sync_post ) ) {
			$this->sync_model->save_group( $post_id, array() );
		} else {
			$languages = array_keys( array_intersect( $sync_post, array( 'true' ) ) );

			foreach ( $languages as $k => $lang ) {
				if ( $this->sync_model->current_user_can_synchronize( $post_id, $lang ) ) {
					$tr_id = $this->sync_model->copy_post( $post_id, $lang, false ); // Don't save the group inside the loop.
					is_sticky( $post_id ) ? stick_post( $tr_id ) : unstick_post( $tr_id ); // copy_post() doesn't handle sticky posts
				} else {
					unset( $languages[ $k ] );
				}
			}

			$this->sync_model->save_group( $post_id, $languages );
		}

		return true;
	}

	/**
	 * Synchronize posts
	 *
	 * @since 2.6
	 *
	 * @param WP_Post $post Inserted or updated post object.
	 */
	public function after_insert_post( $post ) {
		foreach ( array_keys( $this->sync_model->get( $post->ID ) ) as $lang ) {
			if ( $this->sync_model->current_user_can_synchronize( $post->ID, $lang ) ) {
				$tr_id = $this->sync_model->copy_post( $post->ID, $lang, false );
				is_sticky( $post->ID ) ? stick_post( $tr_id ) : unstick_post( $tr_id ); // copy_post() doesn't handle sticky posts
			}
		}
	}

	/**
	 * Add information to the translations_table field
	 * to check if the user can synchronize the current post
	 *
	 * @since 2.6
	 *
	 * @param array  $datas    Translations table row datas.
	 * @param int    $post_id  Post to synchronize.
	 * @param object $language Language to synchronize.
	 * @return array
	 */
	public function translations_table( $datas, $post_id, $language ) {
		$datas[ $language->slug ]['can_synchronize'] = $this->sync_model->current_user_can_synchronize( $post_id, $language->slug );
		return $datas;
	}
}
