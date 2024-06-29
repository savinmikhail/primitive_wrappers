<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str;

use JsonSerializable;
use Stringable;
// Traits
use Mikhail\PrimitiveWrappers\Str\Traits\{
    BasicStringOperationsTrait,
    CaseConversionTrait,
    HtmlTrait,
    JsonOperationsTrait,
    MiscellaneousTrait,
    StringManipulationTrait,
    ValidationTrait
};
// Interfaces
use Mikhail\PrimitiveWrappers\Str\Interfaces\{
    CaseConversionInterface,
    HtmlInterface,
    JsonOperationsInterface,
    MiscellaneousInterface,
    StringManipulationInterface,
    ValidationInterface
};

/**
 * anything in ASCII works as in UTF-8, so we use mb_ functions everywhere
 * @phan-file-suppress PhanRedefinedInheritedInterface
 */
class Str implements
    JsonSerializable,
    JsonOperationsInterface,
    StringManipulationInterface,
    CaseConversionInterface,
    ValidationInterface,
    HtmlInterface,
    MiscellaneousInterface
{
    use BasicStringOperationsTrait;
    use JsonOperationsTrait;
    use StringManipulationTrait;
    use CaseConversionTrait;
    use ValidationTrait;
    use HtmlTrait;
    use MiscellaneousTrait;

    /**
     * @readonly
     */
    protected string $str;

    public function __construct(string $str)
    {
        $this->str = $str;
    }
}
