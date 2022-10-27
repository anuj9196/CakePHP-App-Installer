<?php
declare(strict_types=1);

namespace CakePHPAppInstaller\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function beforeRender(EventInterface $event)
    {
        try {
            return parent::beforeRender($event);
        } finally {
            $this->viewBuilder()->setTheme(null);
        }
    }
}
