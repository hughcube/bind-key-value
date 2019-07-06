<?php

namespace HughCube;

use Closure;

trait BindKeyValueTrait
{
    private $__________values = [];

    /**
     * 获取属性对应的值
     *
     * @param string $key 属性名
     * @param mixed $value 获取属性值的回调
     * @param string $changeReference 属性有无改变的参照值
     * @param bool $strict 是否严格判断参照
     * @return mixed
     */
    public function getOrSetKeyBoundValue($key, $value, $changeReference = null, $strict = false)
    {
        if (
            !isset($this->__________values[$key])
            || (!$strict && $this->__________values[$key][0] != $changeReference)
            || ($strict && $this->__________values[$key][0] !== $changeReference)
        ){
            if ($value instanceof Closure){
                $value = $value();
            }

            $this->__________values[$key] = [$changeReference, $value];
        }

        return $this->__________values[$key][1];
    }
}
