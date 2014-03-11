<?php namespace Ciarand\Midterm\Presenter;

class ArrayPresenter extends AbstractPresenter
{
    public function present($array)
    {
        return "[" . implode(", ", $array) . "]";
    }
}
