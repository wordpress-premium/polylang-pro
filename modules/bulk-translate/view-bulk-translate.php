<?php
/**
 * Outputs the bulk translate form
 *
 * @package Polylang-Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly
};

?>
<form method="get"><table style="display: none"><tbody id="pll-bulk-translate">
	<tr id="pll-translate" class="inline-edit-row">
		<td>
			<div class="inline-edit-wrapper">
				<span class="inline-edit-legend"><?php esc_html_e( 'Bulk translate', 'polylang-pro' ); ?></span>
				<div class="pll-bulk-translate-fields-wrapper">
					<fieldset>
						<div class="inline-edit-col">
						<span class="title"><?php esc_html_e( 'Target languages', 'polylang-pro' ); ?></span>
						<?php
						foreach ( $this->model->get_languages_list() as $language ) {
							printf(
								'<label><span class="option"><input name="pll-translate-lang[]" type="checkbox" value="%1$s" /></span><span class="pll-translation-flag">%3$s</span>%2$s</label>',
								esc_attr( $language->slug ),
								esc_html( $language->name ),
								$language->flag // phpcs:ignore WordPress.Security.EscapeOutput
							);
						}
						?>
						</div>
					</fieldset>
					<fieldset>
						<div class="inline-edit-col">
							<span class="title"><?php esc_html_e( 'Action', 'polylang-pro' ); ?></span>
							<?php
							$option_nb = 0;
							if ( isset( $bulk_translate_options ) ) {
								foreach ( $bulk_translate_options as $bulk_translate_option ) {
									?>
									<label>
										<span class="option"><input name="translate" type="radio" value="<?php echo esc_attr( $bulk_translate_option->get_name() ); ?>"<?php checked( 0, $option_nb ); ?>/></span>
										<span class="description"><?php echo esc_html( $bulk_translate_option->get_description() ); ?></span>
									</label>
									<?php
									$option_nb++;
								}
							}
							?>
						</div>
					</fieldset>
				</div>
				<p class="submit bulk-translate-save">
					<?php wp_nonce_field( 'pll_translate', '_pll_translate_nonce' ); ?>
					<button type="button" class="button button-secondary cancel"><?php esc_html_e( 'Cancel', 'polylang-pro' ); ?></button>
					<?php submit_button( __( 'Submit', 'polylang-pro' ), 'primary', '', false ); ?>
				</p>
			</div>
		</td>
	</tr>
</tbody></table></form>
