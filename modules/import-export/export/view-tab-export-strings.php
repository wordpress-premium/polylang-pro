<?php
/**
 * Displays the strings translations export form
 *
 * @package Polylang-Pro
 * @since 2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

$url = admin_url( 'admin.php?page=mlang_strings&translate=export' );
$languages = $this->model->get_languages_list();
$default_language = $this->model->get_default_language();
$strings = PLL_Admin_Strings::get_strings();
$groups = array_unique( wp_list_pluck( $strings, 'context' ) );
$file_format_factory = new PLL_File_Format_Factory();
$supported_extensions = wp_list_pluck( $file_format_factory->get_supported_formats(), 'extension' );
?>
<div class="form-wrap">
	<form id="export-string-translation" method="post" action="<?php echo esc_url( $url ); ?>">
		<div class="form-field">
			<fieldset>
				<?php wp_nonce_field( PLL_Export_Strings_Translations::ACTION_NAME, PLL_Export_Strings_Translations::NONCE_NAME ); ?>
				<input type="hidden" name="export" value="string-translation" />
				<legend class="pll-legend"><?php esc_html_e( 'Target languages', 'polylang-pro' ); ?></legend>
				<?php
				foreach ( $languages as $language ) {
					if ( $default_language !== $language ) {
						printf(
							'<label><input name="target-lang[]" type="checkbox" value="%1$s" /><span class="pll-translation-flag">%3$s</span>%2$s</label>',
							esc_attr( $language->slug ),
							esc_html( $language->name ),
							$language->flag // phpcs:ignore WordPress.Security.EscapeOutput
						);
					}
				}
				?>
			</fieldset>
		</div>
		<div class="form-field">
			<label for="select-groups"><?php esc_html_e( 'Filter group', 'polylang-pro' ); ?></label>
			<select name="group" id="select-groups">
				<option selected value="-1">
					<?php esc_html_e( 'Export all groups', 'polylang-pro' ); ?>
				</option>
				<?php
				foreach ( $groups as $group ) {
					?>
					<option value="<?php echo esc_attr( $group ); ?>">
						<?php echo esc_html( $group ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-field">
			<fieldset>
				<legend class="pll-legend"><?php esc_html_e( 'Export file format', 'polylang-pro' ); ?></legend>
				<?php foreach ( $supported_extensions as $index => $extension ) : ?>
					<label>
						<input name="filetype" type="radio" value="<?php echo esc_attr( $extension ); ?>" <?php checked( $index, 0 ); ?>/>
						<?php echo esc_attr( strtoupper( $extension ) ); ?>
					</label>
				<?php endforeach; ?>
			</fieldset>
		</div>
		<p class="submit">
			<button type="submit" name="action" class="button button-primary" value="download"><?php echo esc_html__( 'Download', 'polylang-pro' ); ?></button>
		</p>
	</form>
</div>
