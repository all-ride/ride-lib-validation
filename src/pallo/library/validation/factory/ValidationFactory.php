<?php

namespace pallo\library\validation\factory;

/**
 * Factory for filters and validators
 */
interface ValidationFactory {

    /**
     * Creates a filter
     * @param string $name Machine name of the filter
     * @param array $options Options to construct the filter
     * @return pallo\library\validation\filter\Filter
     */
    public function createFilter($name, array $options);

    /**
     * Creates a validator
     * @param string $name Machine name of the validator
     * @param array $options Options to construct the validator
     * @return pallo\library\validation\validator\Validator
     */
    public function createValidator($name, array $options);

}