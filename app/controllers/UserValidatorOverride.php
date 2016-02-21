<?php

use \Zizaco\Confide\UserValidator as ConfideUserValidator;
use \Zizaco\Confide\ConfideUserInterface as ConfideUserInterface;
use \Zizaco\Confide\UserValidatorInterface as UserValidatorInterface;


class UserValidatorOverride extends ConfideUserValidator implements UserValidatorInterface
{
    /**
     * Confide repository instance.
     *
     * @var \Zizaco\Confide\RepositoryInterface
     */
    public $repo;

    /**
     * Validation rules for this Validator.
     *
     * @var array
     */
    public $rules = [
        'create' => [
            'username' => 'required|alpha_dash',
            'email'    => 'required|email',
            'password' => 'required|min:4',
            'degree'   => 'required|min:4',
        ],
        'update' => [
            'username' => 'required|alpha_dash',
            'email'    => 'required|email',
            'password' => 'required|min:4',
            'degree'   => 'required|min:4',
        ]
    ];

    /**
     * Validates if the given user is unique. If there is another
     * user with the same credentials but a different id, this
     * method will return false.
     *
     * @param \Zizaco\Confide\UserValidatorInterface $user
     *
     * @return boolean True if user is unique.
     */
    public function validateIsUnique(ConfideUserInterface $user)
    {
        $identity = [
            'email'    => $user->email,
            'username' => $user->username,
        ];

        foreach ($identity as $attribute => $value) {

            $similar = $this->repo->getUserByIdentity([$attribute => $value]);

            if (!$similar || $similar->getKey() == $user->getKey()) {
                unset($identity[$attribute]);
            } else {
                if ( $attribute === 'email' )
                {
                    $message = 'The email provided has already been used. Try using a different email.';
                }
                else if ( $attribute === 'username' )
                {
                    $message = 'The username provided has already been used. Try using a different username.';
                }
                else
                {
                    $message = 'confide::confide.alerts.duplicated_credentials';
                }
                $this->attachErrorMsg(
                    $user,
                    $message,
                    $attribute
                );
            }

        }

        if (!$identity) {
            return true;
        }

        return false;
    }
}
