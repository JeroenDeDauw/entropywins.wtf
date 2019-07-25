<?php

declare( strict_types = 1 );

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController {

	public function showPage( Request $request, Swift_Mailer $mailer ): Response {
		if ( $this->isFormSubmission( $request ) ) {
			$this->sendMails( $request, $mailer );
		}

		return $this->render(
			'pages/contact.html.twig'
		);
	}

	private function isFormSubmission( Request $request ): bool {
		return $request->isMethod( 'POST' )
			&& $request->request->has( 'name' )
			&& $request->request->has( 'email' )
			&& $request->request->has( 'phone' )
			&& $request->request->has( 'message' );
	}

	private function sendMails( Request $request, Swift_Mailer $mailer ) {
		$mailer->send( $this->newContactMessage( $request ) );
	}

	private function newContactMessage( Request $request ): Swift_Message {
		$message = new Swift_Message(
			'Contact form email: ' . substr( htmlspecialchars( $request->request->get( 'name' ) ), 0, 100 )
		);

		$message->setFrom( 'server@entropywins.wtf' );
		$message->setTo( 'jeroendedauw@gmail.com' );

		$message->setContentType( 'text/html' );

		$message->setBody(
			$this->renderView(
				'emails/contact.html.twig',
				$this->templateParametersFromRequest( $request )
			)
		);

		return $message;
	}

	private function templateParametersFromRequest( Request $request ): array {
		return [
			'name' => $request->request->get( 'name' ),
			'email' => $request->request->get( 'email' ),
			'phone' => $request->request->get( 'phone' ),
			'message' => $request->request->get( 'message' ),
		];
	}

}