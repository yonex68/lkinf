<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class MailerService {

	public function __construct(private MailerInterface $mailer){

	}

	public function sendMailBecomeSaller($from, $to, $subjet, $template, $user, $message){

		$email = (new TemplatedEmail())
			->from($from)
			->to($to)
			->subject($subjet)
			->htmlTemplate($template)
			->context([
				'user' => $user,
				'useremail'  =>  $from,
				'message'   =>  $message
			])
		;

		return $this->mailer->send($email);
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