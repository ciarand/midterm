<?php namespace Ciarand\Midterm\Presenter;

class ObjectPresenter extends AbstractPresenter
{
    public function present($item)
    {
        // Stolen directly from Psy
        $format = '\\<%s #%s>';
        return sprintf($format, get_class($item), spl_object_hash($item));
    }
}
