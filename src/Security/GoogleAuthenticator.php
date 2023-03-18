<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class GoogleAuthenticator extends SocialAuthenticator
{
   private $clientRegistry;
   private $entityManager;
   private $router;
   private $sluger;

   public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router, SluggerInterface $sluger)
   {
      $this->clientRegistry = $clientRegistry;
      $this->entityManager = $entityManager;
      $this->router = $router;
      $this->sluger = $sluger;
   }

   /**
    * Called when authentication is needed, but it's not sent.
    * This redirects to the 'login'.
    */
   public function start(Request $request, AuthenticationException $authException = null): Response
   {
      return new RedirectResponse(
         $this->router->generate('app_login'), // might be the site, where users choose their oauth provider
         Response::HTTP_TEMPORARY_REDIRECT
      );
   }

   public function supports(Request $request): ?bool
   {
      // continue ONLY if the current ROUTE matches the check ROUTE
      return 'connect_google_check' === $request->attributes->get('_route');
   }

   public function getCredentials(Request $request)
   {
      // this method is only called if supports() returns true

      // For Symfony lower than 3.4 the supports method need to be called manually here:
      // if (!$this->supports($request)) {
      //     return null;
      // }

      return $this->fetchAccessToken($this->getGoogleClient());
   }

   public function getUser($credentials, UserProviderInterface $userProvider, UserPasswordHasherInterface $userPasswordHasher)
   {
      /** @var GoogleUser $googleUser */
      $googleUser = $this->getGoogleClient()
         ->fetchUserFromToken($credentials);

      $email = $googleUser->getEmail();

      //dd($googleUser->getAvatar());

      // 1) have they logged in with Google before? Easy!
      $existingUser = $this->entityManager->getRepository(User::class)
         ->findOneBy(['googleId' => $googleUser->getId()]);dd($existingUser);
      dd($existingUser);
      $nameUrl = strtolower($this->sluger->slug($existingUser->getName()));

      if ($existingUser) {

         $existingUser->setEmail($googleUser->getEmail())
            ->setNom($googleUser->getName())
            ->setPrenom($googleUser->getFirstName())
            ->setNameUrl($nameUrl)
            ->setReseauAvatar($googleUser->getAvatar())
            ->setCompte('Client')
            ->setRoles(['ROLE_CLIENT'])
            ->setGoogleId($googleUser->getId())
            ->setPassword(
               $userPasswordHasher->hashPassword(
                  $existingUser,
                  'azerty'
               )
            );
         $this->entityManager->flush();

         return $existingUser;
      }

      // 2) do we have a matching user by email?
      $user = $this->entityManager->getRepository(User::class)
         ->findOneBy(['email' => $email]);

      // 3) Maybe you just want to "register" them by creating
      // a User object
      if (!$user) {

         $user = new User();
         $user->setEmail($googleUser->getEmail())
            ->setNom($googleUser->getName())
            ->setPrenom($googleUser->getFirstName())
            ->setNameUrl($nameUrl)
            ->setReseauAvatar($googleUser->getAvatar())
            ->setCompte('Client')
            ->setRoles(['ROLE_CLIENT'])
            ->setGoogleId($googleUser->getId())
            ->setPassword(
               $userPasswordHasher->hashPassword(
                  $existingUser,
                  'azerty'
               )
            );
         $this->entityManager->persist($user);
         $this->entityManager->flush();
      }

      return $user;
   }

   public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
   {
      // change "app_homepage" to some route in your app
      $targetUrl = $this->router->generate('accueil');

      return new RedirectResponse($targetUrl);

      // or, on success, let the request continue to be handled by the controller
      //return null;
   }

   public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
   {
      $message = strtr($exception->getMessageKey(), $exception->getMessageData());

      return new Response($message, Response::HTTP_FORBIDDEN);
   }

   /**
    * @return GoogleClient
    */
   private function getGoogleClient()
   {
      // "google_main" is the key used in config/packages/knpu_oauth2_client.yaml
      return $this->clientRegistry->getClient('google');
   }
}
