<?php

namespace Opera\SampleSite\Controller;


use Opera\Component\Http\JsonResponse;
use Opera\Component\Http\ParameterBag;
use Opera\Component\Http\Response;
use Opera\Component\Mail\MailException;
use Opera\Component\Mail\MailMessage;
use Opera\Component\WebApplication\Message;
use Opera\SampleSite\MyController;

class DefaultController extends MyController
{

    public function indexGet(string $username = null) : Response
    {
        if ($username !== null) {
            return new JsonResponse([
                'username' => $username,
            ]);
        }

        return $this->render();
    }

    public function contactGet() : Response
    {
        return $this->render();
    }

    public function contactPost() : Response
    {
        $post = $this->getRequest()->getPost();

        // Server side validation doesn't need to be user friendly, that's the task of the front-end
        if (!$this->validateForm($post)) {
            $this->addMessage(Message::TYPE_DANGER, 'Form is not valid');
            return $this->redirect('contact');
        }

        $body = $this->renderView('/mail/contact', [
            'name' => $post->getString('name'),
            'email' => $post->getString('email'),
            'subject' => $post->getString('subject'),
            'message' => $post->getString('message'),
        ]);


        $mail = $this->getContainer()->getMailer();
        $message = (new MailMessage())
            ->setFrom('opera@localhost.local', 'The Opera Sample Site')
            ->setTo('opera@localhost.local', 'The Opera Sample Site')
            ->setSubject('A new contact form has been submitted')
            ->setBody($body);

        try{
            $mail->send($message);

            // Also send a copy to the poster
            $message->setTo($post->getString('email'), $post->getString('name'));
            $mail->send($message);

            $this->addMessage(Message::TYPE_SUCCESS, 'Mail send, we will be in touch shortly');
            return $this->redirect();
        }catch (MailException $e){
            $this->addMessage(Message::TYPE_DANGER, 'Sorry mate, but your message couldn\'t be send');
        }

        return $this->redirectUrl('contact');
    }

    /**
     *
     * TODO: We really need a validation component :)
     *
     * @param ParameterBag $post
     * @return bool
     */
    private function validateForm(ParameterBag $post) : bool
    {
        $name = $post->getString('name');
        $email = $post->getString('email');
        $subject = $post->getString('subject');
        $message = $post->getString('message');

        return $name !== null && $email !== null && $subject !== null && $message !== null &&
            filter_var($email, FILTER_SANITIZE_EMAIL) !== false;
    }

}