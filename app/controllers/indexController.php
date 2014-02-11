<?php
class indexController extends Controller
{

    public function indexAction()
    {
        $this->view->generate('index_index_view.phtml', 'layout.phtml');
    }
}