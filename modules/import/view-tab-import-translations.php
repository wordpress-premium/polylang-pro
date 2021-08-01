<?php
/**
 * Displays the import translations form
 *
 * @package Polylang-Pro
 * @since 2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly.
};

$url = admin_url( 'admin.php?page=mlang_strings&noheader=true' );
?>
<div class="form-wrap">
	<form id="import-translation" method="POST" enctype="multipart/form-data" action="<?php echo esc_url( $url ); ?>">
		<div class="form-field">
			<?php wp_nonce_field( PLL_Import_Action::ACTION_NAME, PLL_Import_Action::NONCE_NAME ); ?>
			<input type="hidden" name="pll_action" value="import-translations" />
			<input type="file" name="importFileToUpload" id="importFileToUpload">
		</div>
		<p class="submit">
			<button class="button button-primary" type="submit" name="importFileToUpload" value="submit"> <?php echo esc_html__( 'Upload', 'polylang-pro' ); ?> </button>
		</p>
	</form>
</div>
