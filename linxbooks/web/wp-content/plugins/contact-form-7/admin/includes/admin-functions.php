<?php

function wpcf7_current_action() {
	if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
		return $_REQUEST['action'];

	if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
		return $_REQUEST['action2'];

	return false;
}

function wpcf7_admin_has_edit_cap() {
	return current_user_can( 'wpcf7_edit_contact_forms' );
}

function wpcf7_add_tag_generator( $name, $title, $elm_id, $callback, $options = array() ) {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	return $tag_generator->add( $name, $title, $callback, $options );
}

function wpcf7_save_contact_form( $post_id = -1 ) {
	if ( -1 != $post_id ) {
		$contact_form = wpcf7_contact_form( $post_id );
	}

	if ( empty( $contact_form ) ) {
		$contact_form = WPCF7_ContactForm::get_template();
	}

	if ( isset( $_POST['post_title'] ) ) {
		$contact_form->set_title( $_POST['post_title'] );
	}

	if ( isset( $_POST['wpcf7-locale'] ) ) {
		$locale = trim( $_POST['wpcf7-locale'] );

		if ( wpcf7_is_valid_locale( $locale ) ) {
			$contact_form->locale = $locale;
		}
	}

	$properties = $contact_form->get_properties();

	if ( isset( $_POST['wpcf7-form'] ) ) {
		$properties['form'] = trim( $_POST['wpcf7-form'] );
	}

	$mail = $properties['mail'];

	if ( isset( $_POST['wpcf7-mail-subject'] ) ) {
		$mail['subject'] = trim( $_POST['wpcf7-mail-subject'] );
	}

	if ( isset( $_POST['wpcf7-mail-sender'] ) ) {
		$mail['sender'] = trim( $_POST['wpcf7-mail-sender'] );
	}

	if ( isset( $_POST['wpcf7-mail-body'] ) ) {
		$mail['body'] = trim( $_POST['wpcf7-mail-body'] );
	}

	if ( isset( $_POST['wpcf7-mail-recipient'] ) ) {
		$mail['recipient'] = trim( $_POST['wpcf7-mail-recipient'] );
	}

	if ( isset( $_POST['wpcf7-mail-additional-headers'] ) ) {
		$mail['additional_headers'] = trim( $_POST['wpcf7-mail-additional-headers'] );
	}

	if ( isset( $_POST['wpcf7-mail-attachments'] ) ) {
		$mail['attachments'] = trim( $_POST['wpcf7-mail-attachments'] );
	}

	$mail['use_html'] = ! empty( $_POST['wpcf7-mail-use-html'] );
	$mail['exclude_blank'] = ! empty( $_POST['wpcf7-mail-exclude-blank'] );

	$properties['mail'] = $mail;

	$mail_2 = $properties['mail_2'];

	$mail_2['active'] = ! empty( $_POST['wpcf7-mail-2-active'] );

	if ( isset( $_POST['wpcf7-mail-2-subject'] ) ) {
		$mail_2['subject'] = trim( $_POST['wpcf7-mail-2-subject'] );
	}

	if ( isset( $_POST['wpcf7-mail-2-sender'] ) ) {
		$mail_2['sender'] = trim( $_POST['wpcf7-mail-2-sender'] );
	}

	if ( isset( $_POST['wpcf7-mail-2-body'] ) ) {
		$mail_2['body'] = trim( $_POST['wpcf7-mail-2-body'] );
	}

	if ( isset( $_POST['wpcf7-mail-2-recipient'] ) ) {
		$mail_2['recipient'] = trim( $_POST['wpcf7-mail-2-recipient'] );
	}

	if ( isset( $_POST['wpcf7-mail-2-additional-headers'] ) ) {
		$mail_2['additional_headers'] = trim(
			$_POST['wpcf7-mail-2-additional-headers'] );
	}

	if ( isset( $_POST['wpcf7-mail-2-attachments'] ) ) {
		$mail_2['attachments'] = trim( $_POST['wpcf7-mail-2-attachments'] );
	}

	$mail_2['use_html'] = ! empty( $_POST['wpcf7-mail-2-use-html'] );
	$mail_2['exclude_blank'] = ! empty( $_POST['wpcf7-mail-2-exclude-blank'] );

	$properties['mail_2'] = $mail_2;

	foreach ( wpcf7_messages() as $key => $arr ) {
		$field_name = 'wpcf7-message-' . strtr( $key, '_', '-' );

		if ( isset( $_POST[$field_name] ) ) {
			$properties['messages'][$key] = trim( $_POST[$field_name] );
		}
	}

	if ( isset( $_POST['wpcf7-additional-settings'] ) ) {
		$properties['additional_settings'] = trim(
			$_POST['wpcf7-additional-settings'] );
	}

	$contact_form->set_properties( $properties );

	do_action( 'wpcf7_save_contact_form', $contact_form );

	return $contact_form->save();
}
