<?php

namespace App\Components;

use Nette;
use Nette\Application\UI\Form;

class LoginControl extends Nette\Application\UI\Control
{

    private $getUser;

    public function __construct( $getUser )
    {
        $this->getUser = $getUser;
    }    
        
    
    public function render()
    {
        $this->template->setFile( __DIR__ . '/loginControl.latte' );
        $this->template->render();
    }
    
    public function handleLogout()
    {
        /*
        $this->getUser->logout();
        $this->flashMessage( 'Odhlasen' );
        $this->redirect( 'this' );*/
    }
    
    protected function createComponentLoginForm()
    {
        $form = new Form;
        $form->addText( 'email', 'Email:' )
                ->addRule( Form::EMAIL, 'Zadejte email' )
                ->setRequired( 'Email' );

        $form->addPassword( 'password', 'Heslo:' )
                ->setRequired( 'Zadejte heslo' );

        $form->addSubmit( 'send', 'Login' );

        $form->onSuccess[] = $this->signInFormSucceeded;
        return $form;
    }

    public function signInFormSucceeded( $form )
    {
        $values = $form->getValues();

        try
        {
            $this->presenter->getUser()->login( $values->email, $values->password );
        }
        catch ( Nette\Security\AuthenticationException $e )
        {
            $form->addError( $e->getMessage(), "error" );
            return;
        }

        //$this->redirect( "this" );
    }

}
