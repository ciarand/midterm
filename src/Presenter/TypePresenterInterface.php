<?php namespace Ciarand\Midterm\Presenter;

interface TypePresenterInterface
{
    public function present(PresenterInterface $parent, $object);
}
