<?php

namespace App\Presenters;

use App;
use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    protected function createComponentLogin()
    {
        return new App\Components\LoginControl( $this->getUser() );
    }

}
