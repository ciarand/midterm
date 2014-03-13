<?php namespace Ciarand\Midterm\Presenter;

class BooleanPresenter extends AbstractPresenter
{
    public function present(PresenterInterface $parent, $item)
    {
        return $item ? "TRUE" : "FALSE";
    }
}
