<?php
/**
 * Copyright 2018 Twohill & Co. Ltd
 */

namespace Twohill\PhpStormGraphQL;


use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\GraphQL\Auth\AuthenticatorInterface;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\ValidationException;

class PhpStormDevAuthenticator implements AuthenticatorInterface
{

    use Configurable;
    /**
     * @config
     */
    private static $allowed_ips = [];

    /**
     * @config
     */
    private static $allowed_useragent;

    /**
     * @config
     */
    private static $allowed_environment;

    /**
     * @param HTTPRequest $request
     * @return Member
     * @throws ValidationException
     */
    public function authenticate(HTTPRequest $request)
    {
        /** @var Group $adminGroup */
        $adminGroup = Permission::get_groups_by_permission('ADMIN')->first();
        if (!$adminGroup) {
            throw new ValidationException('No admin group found');
        }

        /** @var Member $member */
        $member = $adminGroup->Members()->first();

        if (!$member) {
            throw new ValidationException('No admin to impersonate');
        }

        return $member;
    }

    public function isApplicable(HTTPRequest $request)
    {
        return (
            in_array($request->getIP(), $this->config()->allowed_ips) &&
            $request->getHeader('user-agent') == $this->config()->allowed_useragent &&
            Director::get_environment_type() == $this->config()->allowed_environment
        );
    }
}