<?php namespace Ciarand\Midterm\Presenter;

class TraversablePresenter extends AbstractPresenter
{
    public function present(PresenterInterface $parent, $object)
    {
        if (is_array($object) && !$this->isAssociative($object)) {
            return $this->decorate($this->presentScalarArray($parent, $object));
        }

        return $this->decorate($this->presentHash($parent, $object));
    }

    protected function isAssociative(array $array)
    {
        return (bool) count(array_filter(array_keys($array), "is_string"));
    }

    protected function presentScalarArray($parent, array $array)
    {
        return array_map(function ($item) use ($parent) {
            return $parent->present($item);
        }, $array);
    }

    protected function presentHash($parent, $object)
    {
        $elems = array();

        foreach ($object as $key => $value) {
            $elems[] = sprintf(
                "%s => %s",
                $parent->present($key),
                $parent->present($value)
            );
        }

        return $elems;
    }

    protected function decorate(array $elements)
    {
        return "[" . implode(", ", $elements) . "]";
    }
}
