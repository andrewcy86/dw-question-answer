<?php
/**
 * The template for displaying single answers
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<?php if ( dwqa_current_user_can( 'post_question' ) ) : ?>
	<?php do_action( 'dwqa_before_question_submit_form' ); ?>
	<form method="post" class="dwqa-content-edit-form" enctype="multipart/form-data">
		<p class="dwqa-search">
			<label for="question_title"><?php _e( 'Title', 'dwqa' ) ?></label>
			<?php $title = isset( $_POST['question-title'] ) ? sanitize_title( $_POST['question-title'] ) : ''; ?>
			<input type="text" data-nonce="<?php echo wp_create_nonce( '_dwqa_filter_nonce' ) ?>" id="question-title" name="question-title" value="<?php echo $title ?>" tabindex="1">
		</p>
		<?php $content = isset( $_POST['question-content'] ) ? sanitize_text_field( $_POST['question-content'] ) : ''; ?>
		<p><?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content' ) ) ?></p>
		<?php global $dwqa_general_settings; ?>
		<?php if ( isset( $dwqa_general_settings['enable-private-question'] ) && $dwqa_general_settings['enable-private-question'] ) : ?>
		<p>
			<label for="question-status"><?php _e( 'Status', 'dwqa' ) ?></label>
			<select class="dwqa-select" id="question-status" name="question-status">
				<optgroup label="<?php _e( 'Who can see this?', 'dwqa' ) ?>">
					<option value="publish"><?php _e( 'Public', 'dwqa' ) ?></option>
					<option value="private"><?php _e( 'Only Me &amp; Admin', 'dwqa' ) ?></option>
				</optgroup>
			</select>
		</p>
		<?php endif; ?>
		<p>
			<label for="question-category"><?php _e( 'Category', 'dwqa' ) ?></label>
			<?php
				wp_dropdown_categories( array(
					'name'          => 'question-category',
					'id'            => 'question-category',
					'taxonomy'      => 'dwqa-question_category',
					'show_option_none' => __( 'Select question category', 'dwqa' ),
					'hide_empty'    => 0,
					'quicktags'     => array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ),
					'selected'      => isset( $_POST['question-category'] ) ? sanitize_text_field( $_POST['question-category'] ) : false,
				) );
			?>
		</p>

		<?php if ( dwqa_current_user_can( 'post_question' ) && !is_user_logged_in() ) : ?>
				<input type="hidden" class="" name="_dwqa_anonymous_email" value="anonymous@epa.gov" >
				<input type="hidden" class="" name="_dwqa_anonymous_name" value="anonymous" >
		<?php endif; ?>
		<?php wp_nonce_field( '_dwqa_submit_question' ) ?>
		<?php dwqa_load_template( 'captcha', 'form' ); ?>
		<?php do_action('dwqa_before_question_submit_button'); ?>
		<input type="submit" name="dwqa-question-submit" value="<?php _e( 'Submit', 'dwqa' ) ?>" >
	</form>
	<?php do_action( 'dwqa_after_question_submit_form' ); ?>
<?php else : ?>
	<div class="alert"><?php _e( 'You do not have permission to submit a question','dwqa' ) ?></div>
<?php endif; ?>
