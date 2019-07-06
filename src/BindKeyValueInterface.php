<?php

namespace HughCube;

interface BindKeyValueInterface
{
    /**
     * 获取属性对应的值
     *
     * @param mixed $key 属性名
     * @param mixed $value 获取属性值的回调
     * @param mixed $changeReference 属性有无改变的参照值
     * @param bool $strict 是否严格判断参照
     * @return mixed
     */
    public function getOrSetKeyBoundValue($name, $value, $referenceKey, $strict = false);
}
