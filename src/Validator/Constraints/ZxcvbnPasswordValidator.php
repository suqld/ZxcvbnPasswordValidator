<?php

namespace Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;
use ZxcvbnPhp\Zxcvbn;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;

/**
 * Password strength Validation.
 * More info: https://blogs.dropbox.com/tech/2012/04/zxcvbn-realistic-password-strength-estimation/
 */
class ZxcvbnPasswordValidator extends ConstraintValidator
{

    private $translator;

    public function __construct(TranslatorInterface $translator = null)
    {
        // If translator is missing create a new translator.
        // With the 'en' locale and 'validators' domain.
        if (null === $translator) {
            $translator = new Translator('en');
            $translator->addLoader('xlf', new XliffFileLoader());
            $translator->addResource(
                'xlf',
                dirname(dirname(__DIR__)).'/Resources/translations/validators.en.xlf',
                'en',
                'validators'
            );
        }

        $this->translator = $translator;
    }

    public function validate($password, Constraint $constraint)
    {
        if (null === $password || '' === $password) {
            return;
        }

        if (!is_scalar($password) && !(is_object($password) && method_exists($password, '__toString'))) {
            throw new UnexpectedTypeException($password, 'string');
        }

        $zxcvbn = new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($password);

        if ($strength['score'] < $constraint->minScore) {
            $parameters = [
                '{{ min_score }}' => $constraint->minScore,
                '{{ current_score }}' => $strength['score'],
            ];

            $this->context->buildViolation($this->translator->trans($constraint->message, $parameters, 'validators'))
                ->setParameters($parameters)
                ->addViolation();
        }
    }
}