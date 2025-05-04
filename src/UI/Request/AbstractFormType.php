<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFormType extends AbstractType implements RequestInterface
{
    protected const string INVALID = 'invalid';
    protected const string COUNT_MIN = 'countMin';
    protected const string NOT_UNIQUE = 'notUnique';
    protected const string NOT_BLANK = 'notBlank';
    protected const string NOT_NULL = 'notNull';
    protected const string STRING = 'string';
    protected const string URL = 'url';
    protected const string INTEGER = 'integer';
    protected const string ARRAY = 'array';
    protected const string GREATER_THAN = 'greaterThan';
    protected const string GREATER_THAN_EQUAL = 'greaterThanEqual';
    protected const string MAX_LENGTH = 'maxLength';
    protected const string MIN_LENGTH = 'minLength';

    #[Ignore]
    protected string $parent;

    #[Ignore]
    protected string $blockPrefix;

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => static::class,
        ]);
    }
}
