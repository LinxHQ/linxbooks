<?php

class WPCF7_ContactFormTemplate {

	public static function get_default( $prop = 'form' ) {
		if ( 'form' == $prop ) {
			$template = self::form();
		} elseif ( 'mail' == $prop ) {
			$template = self::mail();
		} elseif ( 'mail_2' == $prop ) {
			$template = self::mail_2();
		} elseif ( 'messages' == $prop ) {
			$template = self::messages();
		} else {
			$template = null;
		}

		return apply_filters( 'wpcf7_default_template', $template, $prop );
	}

	public static function form() {
		$template =
			'<p>' . __( 'Your Name', 'contact-form-7' )
			. ' ' . __( '(required)', 'contact-form-7' ) . '<br />' . "\n"
			. '    [text* your-name] </p>' . "\n\n"
			. '<p>' . __( 'Your Email', 'contact-form-7' )
			. ' ' . __( '(required)', 'contact-form-7' ) . '<br />' . "\n"
			. '    [email* your-email] </p>' . "\n\n"
			. '<p>' . __( 'Subject', 'contact-form-7' ) . '<br />' . "\n"
			. '    [text your-subject] </p>' . "\n\n"
			. '<p>' . __( 'Your Message', 'contact-form-7' ) . '<br />' . "\n"
			. '    [textarea your-message] </p>' . "\n\n"
			. '<p>[submit "' . __( 'Send', 'contact-form-7' ) . '"]</p>';

		return $template;
	}

	public static function mail() {
		$template = array(
			'subject' => '[your-subject]',
			'sender' => sprintf( '[your-name] <%s>', self::from_email() ),
			'body' =>
				sprintf( __( 'From: %s', 'contact-form-7' ),
					'[your-name] <[your-email]>' ) . "\n"
				. sprintf( __( 'Subject: %s', 'contact-form-7' ),
					'[your-subject]' ) . "\n\n"
				. __( 'Message Body:', 'contact-form-7' )
					. "\n" . '[your-message]' . "\n\n"
				. '--' . "\n"
				. sprintf( __( 'This e-mail was sent from a contact form on %1$s (%2$s)',
					'contact-form-7' ), get_bloginfo( 'name' ), get_bloginfo( 'url' ) ),
			'recipient' => get_option( 'admin_email' ),
			'additional_headers' => 'Reply-To: [your-email]',
			'attachments' => '',
			'use_html' => 0,
			'exclude_blank' => 0 );

		return $template;
	}

	public static function mail_2() {
		$template = array(
			'active' => false,
			'subject' => '[your-subject]',
			'sender' => sprintf( '%s <%s>',
				get_bloginfo( 'name' ), self::from_email() ),
			'body' =>
				__( 'Message Body:', 'contact-form-7' )
					. "\n" . '[your-message]' . "\n\n"
				. '--' . "\n"
				. sprintf( __( 'This e-mail was sent from a contact form on %1$s (%2$s)',
					'contact-form-7' ), get_bloginfo( 'name' ), get_bloginfo( 'url' ) ),
			'recipient' => '[your-email]',
			'additional_headers' => sprintf( 'Reply-To: %s',
				get_option( 'admin_email' ) ),
			'attachments' => '',
			'use_html' => 0,
			'exclude_blank' => 0 );

		return $template;
	}

	public static function from_email() {
		$admin_email = get_option( 'admin_email' );
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );

		if ( wpcf7_is_localhost() ) {
			return $admin_email;
		}

		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}

		if ( strpbrk( $admin_email, '@' ) == '@' . $sitename ) {
			return $admin_email;
		}

		return 'wordpress@' . $sitename;
	}

	public static function messages() {
		$messages = array();

		foreach ( wpcf7_messages() as $key => $arr ) {
			$messages[$key] = $arr['default'];
		}

		return $messages;
	}
}

function wpcf7_messages() {
	$messages = array(
		'mail_sent_ok' => array(
			'description'
				=> __( "Sender's message was sent successfully", 'contact-form-7' ),
			'default'
				=> __( 'Your message was sent successfully. Thanks.', 'contact-form-7' )
		),

		'mail_sent_ng' => array(
			'description'
				=> __( "Sender's message was failed to send", 'contact-form-7' ),
			'default'
				=> __( 'Failed to send your message. Please try later or contact the administrator by another method.', 'contact-form-7' )
		),

		'validation_error' => array(
			'description'
				=> __( "Validation errors occurred", 'contact-form-7' ),
			'default'
				=> __( 'Validation errors occurred. Please confirm the fields and submit it again.', 'contact-form-7' )
		),

		'spam' => array(
			'description'
				=> __( "Submission was referred to as spam", 'contact-form-7' ),
			'default'
				=> __( 'Failed to send your message. Please try later or contact the administrator by another method.', 'contact-form-7' )
		),

		'accept_terms' => array(
			'description'
				=> __( "There are terms that the sender must accept", 'contact-form-7' ),
			'default'
				=> __( 'Please accept the terms to proceed.', 'contact-form-7' )
		),

		'invalid_required' => array(
			'description'
				=> __( "There is a field that the sender must fill in", 'contact-form-7' ),
			'default'
				=> __( 'Please fill in the required field.', 'contact-form-7' )
		),

		'invalid_too_long' => array(
			'description'
				=> __( "There is a field that the user input is longer than the maximum allowed length", 'contact-form-7' ),
			'default'
				=> __( 'This input is too long.', 'contact-form-7' )
		),

		'invalid_too_short' => array(
			'description'
				=> __( "There is a field that the user input is shorter than the minimum allowed length", 'contact-form-7' ),
			'default'
				=> __( 'This input is too short.', 'contact-form-7' )
		)
	);

	return apply_filters( 'wpcf7_messages', $messages );
}
