<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;

/**
 * Chain of constraints
 */
class ChainConstraint implements Constraint {

    /**
     * Nested constraints
     * @var array
     */
    protected $constraints;

    /**
     * Constructs a new generic constraint
     * @return null
     */
    public function __construct() {
        $this->constraints = array();
    }

    /**
     * Adds a nested constraint
     * @param Constraint $constraint Constraint
     * @return null
     */
    public function addConstraint(Constraint $constraint) {
        $this->constraints[] = $constraint;
    }

    /**
     * Constrains the provided instance
     * @param array|object $isntance Instance to be validated
     * @param \ride\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated instance
     * @throws \ride\library\validation\exception\ValidationException when the
     * instance could not be validated and no exception is provided
     */
    public function constrain($instance, ValidationException $exception = null) {
        if ($exception) {
            $throwException = false;
        } else {
            $throwException = true;

            $exception = new ValidationException();
        }

        foreach ($this->constraints as $constraint) {
            $instance = $constraint->constrain($instance, $exception);
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $instance;
    }

}
