<?php
/**
 * @package Polylang-Pro
 */

/**
 * Define a Bulk_Translate option
 *
 * Should be registered using the pll_bulk_action_options
 *
 * @see PLL_Bulk_Translate
 *
 * @since 2.7
 */
abstract class PLL_Bulk_Translate_Option {
	/**
	 * A reference to the current PLL_Model
	 *
	 * @since 2.7
	 *
	 * @var PLL_Model
	 */
	protected $model;

	/**
	 * The name by which the option is referred to in forms
	 *
	 * @since 2.7
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * A short sentence to explicit what this option does
	 *
	 * @since 2.7
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Determines the order in which the options should be displayed.
	 *
	 * Lower priority options are displayed before higher priority options.
	 *
	 * @since 2.7
	 *
	 * @var int
	 */
	protected $priority;

	/**
	 * Once the action executed, its results are stored in this array
	 *
	 * @since 2.7
	 *
	 * @var array
	 */
	protected $results = array();

	/**
	 * Every notices raised during bulk action execution will be stored here
	 *
	 * @since 2.7
	 *
	 * @var array {
	 *     PLL_Bulk_Translate::ERROR   array
	 *     PLL_Bulk_Trasnlate::WARNING array
	 *     PLL_Bulk_Translate::UPDATED array
	 * }
	 */
	protected $notices = array(
		PLL_Bulk_Translate::ERROR   => array(),
		PLL_Bulk_Translate::WARNING => array(),
		PLL_Bulk_Translate::UPDATED => array(),
	);

	/**
	 * Constructor
	 *
	 * @since 2.7
	 *
	 * @param array     $args {
	 *     string $name        The name of the option.
	 *     string $description A short sentence too describe what this option does. Please use i18n functions.
	 *     int    $priority    Determines the order of displaying th options. Default 10.
	 * }.
	 * @param PLL_Model $model An instance to the current instance of PLL_Model.
	 */
	public function __construct( $args, $model ) {
		$this->name = $args['name'];
		$this->description = $args['description'];
		$this->priority = array_key_exists( 'priority', $args ) ? $args['priority'] : 10;

		$this->model = $model;
	}

	/**
	 * Getter
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}


	/**
	 * Getter
	 *
	 * @since 2.7
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Getter.
	 *
	 * @since 2.7
	 *
	 * @return int
	 */
	public function get_priority() {
		return $this->priority;
	}

	/**
	 * Checks whether the option should be selectable by the user.
	 *
	 * @since 2.7
	 *
	 * @return bool
	 */
	abstract public function is_available();

	/**
	 * Decides whether or not an object should be translated.
	 *
	 * @since 2.7
	 *
	 * @param int    $id   Identify a post, media, term...
	 * @param string $lang A language locale.
	 * @return bool|int
	 */
	public function filter( $id, $lang ) {
		return ! $this->model->post->get_translation( $id, $lang );
	}

	/**
	 * Triggers the correct functions for creating a translation of the selected content in a selected language.
	 *
	 * Has to be overridden.
	 *
	 * @since 2.7
	 *
	 * @param int    $object_id Identifies the post, term, media, etc. to be translated.
	 * @param string $lang      A language locale.
	 * @return void
	 */
	abstract public function translate( $object_id, $lang );

	/**
	 * The actual effect of the bulk translate action
	 *
	 * @since 2.7
	 *
	 * @param int[]    $object_ids An array of the id of the WordPress objects to translate.
	 * @param string[] $languages  An array of the locales of the languages in which to translate.
	 *
	 * @return array {
	 *     array PLL_Bulk_Translate::UPDATED Info notices to be displayed to the user.
	 *     array PLL_Bulk_Translate::WARNING Warning notices to be displayed to the user.
	 * }
	 */
	public function do_bulk_action( $object_ids, $languages ) {
		$done = 0;
		$missed = 0;

		if ( ! empty( $object_ids ) ) {
			foreach ( $object_ids as $object_id ) {
				if ( $this->model->post->get_language( $object_id ) !== false ) {
					foreach ( $languages as $lang ) {
						if ( $this->filter( $object_id, $lang ) ) {
							$this->translate( $object_id, $lang );
							$done ++;
						} else {
							$missed ++;
						}
					}
				}
			}
		}

		if ( 0 < $done ) {
			$this->notices[ PLL_Bulk_Translate::UPDATED ] = array(
				sprintf(
					/* translators: %d is a number of posts */
					_n( '%d translation created.', '%d translations created.', $done, 'polylang-pro' ),
					$done
				),
			);
		}

		if ( 0 < $missed ) {
			$this->notices[ PLL_Bulk_Translate::WARNING ] = array(
				sprintf(
					/* translators: %d is a number of posts */
					_n( 'To avoid overwriting content, %d translation was not created.', 'To avoid overwriting content, %d translations were not created.', $missed, 'polylang-pro' ),
					$missed
				),
			);
		}

		return array_merge( $this->results, $this->notices );
	}
}
