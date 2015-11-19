<?php

namespace CSI_UKSW\Laravel\CAS;

use phpCAS;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Session;


class CASAuthentication
{

    private $config;
    private $auth;
    private $cas_user = null;

    /**
     * Init CASAuthentication
     *
     * @param $config
     * @param AuthManager $auth
     */
    public function __construct($config, AuthManager $auth)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->initialize();
    }

    /**
     * Initialize phpCAS
     */
    private function initialize()
    {
        // set session name
        session_name($this->config['cas_session_name']);

        // set debug
        $this->setDebug();

        // configure CAS client
        phpCAS::client(
            $this->config['cas_saml'] ? SAML_VERSION_1_1 : CAS_VERSION_2_0,
            $this->config['cas_hostname'],
            intval($this->config['cas_port']),
            $this->config['cas_uri'],
            false
        );

        // configure certificate
        $this->configureCertificate();

        // handle logout requests
        phpCAS::handleLogoutRequests(false);

        // set login and logout URL's
        phpCAS::setServerLoginURL($this->config['cas_login_uri']);
        phpCAS::setServerLogoutURL($this->config['cas_logout_uri']);

    }

    /**
     * Set phpCAS Debug
     */
    private function setDebug()
    {
        $debug = $this->config['cas_debug'];

        if ($debug) {
            $file_path = (gettype($debug)) ? $debug : '';
            phpCAS::setDebug($file_path);
        }
    }

    /**
     * SSL Validation
     */
    private function configureCertificate()
    {
        if ($this->config['cas_validation'] == 'self') {
            phpCAS::setCasServerCert($this->config['cas_cert']);
        } else {
            if ($this->config['cas_validation'] == 'ca') {
                phpCAS::setCasServerCACert($this->config['cas_cert']);
            }
            phpCAS::setNoCasServerValidation();
        }
    }

    /**
     * Set currently logged in user and create session
     */
    private function setUser()
    {
        $this->cas_user = phpCAS::getUser();
        Session::put('cas_user', $this->cas_user);
    }

    /**
     * Authenticate user
     *
     * @return bool
     */
    public function authenticate()
    {
        if (phpCAS::forceAuthentication()) {
            // retrieve authenticated credentials
            $this->setUser();

            return true;
        }

        return false;
    }

    /**
     * Checks to see is user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if (phpCAS::isAuthenticated()) {
            $this->setUser();

            return true;
        }

        return false;
    }

    /**
     * Returns information about the currently logged in user.
     *
     * @return string|null
     */
    public function getUser()
    {
        return $this->cas_user;
    }

    /**
     * Get currently logged in user attributes
     *
     * @return array|null
     */
    public function getAttributes()
    {
        return phpCAS::getAttributes();
    }

    /**
     * Get specific attribute
     *
     * @param $attribute_name string
     * @return string|null
     */
    public function getAttribute($attribute_name)
    {
        return isset($this->getAttributes()[$attribute_name]) ? $this->getAttributes()[$attribute_name] : null;
    }

    /**
     * Get version of phpCAS
     * @return string
     */
    public function getVersion()
    {
        return phpCAS::getVersion();
    }

    /**
     * This method is used to logout from CAS
     *
     * @param array ['url' => 'http://...'] || ['service' => ...]
     *
     * @return none
     */
    public function logout($params = [])
    {
        if (!phpCAS::isAuthenticated()) {
            $this->initialize();
        }

        if ($this->auth->check()) {
            $this->auth->logout();
        }

        Session::flush();
        phpCAS::logout($params);
    }

    /**
     * Check if user is in specific group
     *
     * @param $group_name
     * @return bool|int (0,1)
     */
    public function isInGroup($group_name)
    {
        if ($this->config['cas_saml']) {
            $groups = $this->getAttributes()[$this->config['cas_saml_attr_groups']];

            if (empty($groups)) {
                return false;
            }

            if (!is_string($groups)) {
                $groups = implode(",", $groups);
            }

            return preg_match("/" . trim($group_name) . "/i", $groups);
        }

        return false;
    }

}