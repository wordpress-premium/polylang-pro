<?php

/**
 * Outputs the bulk translate form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly
};

?>
<form method="get"><table style="display: none"><tbody id="pll-bulk-translate">
	<tr id="pll-translate" class="inline-edit-row">
		<td>
			<fieldset>
				<legend class="inline-edit-legend"><?php esc_html_e( 'Bulk translate', 'polylang-pro' ); ?></legend>
				<div class="inline-edit-col">
				<?php
				foreach ( $this->model->get_languages_list() as $language ) {
					printf(
						'<label><input name="pll-translate-lang[]" type="checkbox" value="%1$s" /><span class="pll-translation-flag">%3$s</span>%2$s</label>',
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
					<label><input name="translate" type="radio" value="copy" checked="checked" /><?php esc_html_e( 'Copy original items to selected languages', 'polylang-pro' ); ?></label>
					<?php if ( 'attachment' !== $post_type ) { ?>
					<label><input name="translate" type="radio" value="sync" /><?php esc_html_e( 'Synchronize original items with translation in selected languages', 'polylang-pro' ); ?></label>
					<?php } ?>
				</div>
			</fieldset>
			<p class="submit bulk-translate-save">
				<button type="button" class="button button-secondary cancel"><?php esc_html_e( 'Cancel', 'polylang-pro' ); ?></button>
				<?php submit_button( __( 'Submit', 'polylang-pro' ), 'primary', '', false ); ?>
			</p>
		</td>
	</tr>
</tbody></table></form>
