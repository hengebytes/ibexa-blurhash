<?php

namespace HengeBytes\IbexaBlurhashBundle\FieldType\Image;

use HengeBytes\IbexaBlurhashBundle\Service\BlurhashGeneratorService;
use Ibexa\Contracts\Core\FieldType\Value as SPIValue;
use Ibexa\Contracts\Core\Persistence\Content\FieldValue;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;
use Ibexa\Core\Base\Exceptions\InvalidArgumentType;
use Ibexa\Core\FieldType\Image\Type;
use Ibexa\Core\FieldType\Image\Value as ImageValue;

class TypeDecorator extends Type
{
    public function __construct(
        private readonly Type $type,
        private readonly BlurhashGeneratorService $blurhashGenerator
    ) {
        parent::__construct([]); // we extend type to keep the same interface
    }

    protected static function checkValueType($value): void
    {
        if (!$value instanceof ImageValue) {
            throw new InvalidArgumentType('$value', ImageValue::class, $value);
        }
    }

    protected function createValueFromInput($inputValue)
    {
        $inputValue = $this->type->createValueFromInput($inputValue);

        if (isset($inputValue->inputUri)) {
            $inputValue->additionalData['blurhash'] = $this->blurhashGenerator->encode($inputValue->inputUri);
        }

        return $inputValue;
    }

    public function validate(FieldDefinition $fieldDefinition, SPIValue $fieldValue): array
    {
        return $this->type->validate($fieldDefinition, $fieldValue);
    }

    public function valuesEqual(SPIValue $value1, SPIValue $value2): bool
    {
        return $this->type->valuesEqual($value1, $value2);
    }

    public function getFieldTypeIdentifier()
    {
        return $this->type->getFieldTypeIdentifier();
    }

    public function getName(SPIValue $value, FieldDefinition $fieldDefinition, string $languageCode): string
    {
        return $this->type->getName($value, $fieldDefinition, $languageCode);
    }

    public function getEmptyValue()
    {
        return $this->type->getEmptyValue();
    }

    public function validateValidatorConfiguration($validatorConfiguration)
    {
        return $this->type->validateValidatorConfiguration($validatorConfiguration);
    }

    public function fromHash($hash)
    {
        return $this->type->fromHash($hash);
    }

    public function toHash(SPIValue $value)
    {
        return $this->type->toHash($value);
    }

    public function toPersistenceValue(SPIValue $value)
    {
        return $this->type->toPersistenceValue($value);
    }

    public function fromPersistenceValue(FieldValue $fieldValue)
    {
        return $this->type->fromPersistenceValue($fieldValue);
    }
}
