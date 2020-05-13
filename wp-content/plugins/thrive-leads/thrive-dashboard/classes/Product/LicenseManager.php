<?php

/**
 * Created by PhpStorm.
 * User: Danut
 * Date: 12/9/2015
 * Time: 5:40 PM
 */
class TVE_Dash_Product_LicenseManager {
    const LICENSE_OPTION_NAME = 'thrive_license';
    const TCB_TAG = 'tcb';
    const TL_TAG = 'tl';
    const TCW_TAG = 'tcw';
    const ALL_TAG = 'all';
    const TU_TAG = 'tu';
    const THO_TAG = 'tho';
    const TVO_TAG = 'tvo';
    const TQB_TAG = 'tqb';
    const TCM_TAG = 'tcm';
    const TVA_TAG = 'tva';

    const TAG_FOCUS = 'focusblog';
    const TAG_LUXE = 'luxe';
    const TAG_IGNITION = 'ignition';
    const TAG_MINUS = 'minus';
    const TAG_SQUARED = 'squared';
    const TAG_VOICE = 'voice';
    const TAG_PERFORMAG = 'performag';
    const TAG_PRESSIVE = 'pressive';
    const TAG_STORIED = 'storied';
    const TAG_RISE = 'rise';

    protected $secret_key = '@#$()%*%$^&*(#@$%@#$%93827456MASDFJIK3245';

    protected static $instance;

    protected $license_data;
    protected $accepted_tags = array();

    protected function __construct() {
        $this->license_data = get_option( self::LICENSE_OPTION_NAME, array() );
        $reflection         = new ReflectionClass( $this );

        $constants = $reflection->getConstants();

        $this->accepted_tags = array();

        foreach ( $constants as $name => $value ) {
            if ( strpos( $name, 'TAG' ) !== false ) {
                $this->accepted_tags [] = $value;
            }
        }
    }

    public static function getInstance() {
        if ( empty( self::$instance ) ) {
            self::$instance = new TVE_Dash_Product_LicenseManager();
        }

        return self::$instance;
    }

    /**
     * Checks license options
     *
     * @param string|TVE_Dash_Product_Abstract $item
     *
     * @return bool
     */
    public function itemActivated( $item ) {
        return true;
    }

    public function checkLicense( $email, $key, $tag = false ) {
        $response = array();
        $response['success'] = 1;
        $response['products'] = [self::ALL_TAG];
        return $response;
    }

    protected function calc_hash( $data ) {
        return md5( $this->secret_key . serialize( $data ) . $this->secret_key );
    }

    public function activateProducts( &$response ) {
        update_option( self::LICENSE_OPTION_NAME, array( self::ALL_TAG ) );
        return $response;
    }
}