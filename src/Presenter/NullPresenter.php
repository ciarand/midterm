<?php namespace Ciarand\Midterm\Presenter;

class NullPresenter extends AbstractPresenter
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function present(PresenterInterface $parent, $item)
    {
        return "NULL";
    }
}
