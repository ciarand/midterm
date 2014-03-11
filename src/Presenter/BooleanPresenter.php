<?php namespace Ciarand\Midterm\Presenter;

class BooleanPresenter extends AbstractPresenter
{
    public function present($item)
    {
        return $item ? "TRUE" : "FALSE";
    }
}
