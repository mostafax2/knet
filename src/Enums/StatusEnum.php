<?php
namespace Mostafax\Knet\Enums;

enum StatusEnum : int
{
    case INTI = 0;
    case SUCCSESS = 1;
    case CANCEL = 2;
    case PENDING = 3;
    case NOTCOMPLETE = 4;
    case ERROR = 5;

    public function label():string
    {
        return $this->getLabels()[$this->value];
    }

    public function getLabels():array
    {
        return [
            self::INTI->value => __('init'),
            self::SUCCSESS->value => __('success'),
            self::CANCEL->value => __('cancel'),
            self::PENDING->value => __('pending'),
            self::NOTCOMPLETE->value => __('not_complete'),
            self::ERROR->value => __('error')
        ];
    }

}