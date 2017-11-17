<?php

namespace Installer\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
   /**
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
         try {
             return parent::beforeRender($event);
         } finally {
             $this->viewBuilder()->setTheme(null);
         }
    }
}
