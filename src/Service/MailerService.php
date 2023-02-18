<?php

namespace App\Service;

use App\Entity\Immobilier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class MailerService {

	public function __construct(private MailerInterface $mailer){

	}

	public function sendMail($from, $to, $subjet, $username, $message, $microservice){


		$email = (new TemplatedEmail())
			->from($from)
			->to($to)
			->subject($subjet)
			->htmlTemplate('mails/_default.html.twig')
			->context([
				'user' => $username,
				'useremail'  =>  $from,
				'message'   =>  $message,
				'microservice'   =>  $microservice
			])
		;

		return $this->mailer->send($email);
	}

}