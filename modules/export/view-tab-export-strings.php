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
$default_language = $this->model->get_language( $this->options['default_lang'] );
$strings = PLL_Admin_Strings::get_strings();
$groups = array_unique( wp_list_pluck( $strings, 'context' ) );
?>
<form id="export-string-translation" method="post" action="<?php echo esc_url( $url ); ?>">
	<table>
		<tbody id="pll-bulk-translate">
			<tr id="pll-translate" class="inline-edit-row">
				<td>
					<fieldset>
						<?php wp_nonce_field( PLL_Export_Strings_Translation::ACTION_NAME, PLL_Export_Strings_Translation::NONCE_NAME ); ?>
						<input type="hidden" name="export" value="string-translation" />
						<span class="title"><?php esc_html_e( 'Target languages:', 'polylang-pro' ); ?></span>
						<div class="inline-edit-col">
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
						</div>
					</fieldset>
					<fieldset>
						<div class="inline-edit-col">
							<span class="title"><?php esc_html_e( 'Filter group:', 'polylang-pro' ); ?></span>
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
					</fieldset>
					<p class="submit">
						<button type="submit" name="action" class="button button-primary" value="download"><?php echo esc_html__( 'Download', 'polylang-pro' ); ?></button>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</form>
