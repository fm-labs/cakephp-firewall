<?php

namespace Firewall\Controller\Admin;


class ShieldonController extends AppController
{
    /**
     * Entrypoint to Shieldon panel.
     *
     * @return void
     */
    public function index()
    {
        try {
            $panel = new \Shieldon\Firewall\Panel();
            $panel->csrf([
                '_csrfToken' => $this->request->getParam('_csrfToken')
            ]);
            $panel->entry();
            exit;
        } catch (\Exception $ex) {
            $this->Flash->error(__('Failed to initialize Shieldon panel: {0}', $ex->getMessage()));
        }
    }
}
