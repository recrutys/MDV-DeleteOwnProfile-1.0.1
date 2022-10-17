<?php

namespace MDV\DeleteOwnProfile\XF\Pub\Controller;

use XF;
use XF\App;
use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{
    public function actionMdvDeleteProfile()
    {
        if (!XF::visitor()->hasPermission('general', 'mdv_ptdop_deleteAccount'))
        {
            return $this->noPermission();
        }

        if (!XF::visitor()->is_admin)
        {
            XF::visitor()->setOption('allow_self_delete', true);
        }

        if ($this->isPost())
        {
            $deleteUser = $this->service('XF:User\Delete', XF::visitor());

            if (!$deleteUser->delete($errors))
            {
                return $this->error($errors);
            }

            return $this->redirect($this->buildLink('index'));
        }
        return $this->view('', 'mdv_ptdop_confirm');
    }
}