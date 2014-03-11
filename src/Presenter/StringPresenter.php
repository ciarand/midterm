<?php namespace Ciarand\Midterm\Presenter;

class StringPresenter extends AbstractPresenter
{
    public function present($item)
    {
        return '"' . addslashes($item) . '"';
    }
}
