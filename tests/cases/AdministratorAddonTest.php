<?php

use WPMVC\Addons\PHPUnit\TestCase;
use WPMVC\Addons\Administrator\AdministratorAddon;

/**
 * Test addon class.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.11
 */
class AdministratorAddonTest extends TestCase
{
    /**
     * Tear down.
     * @since 1.0.11
     */
    public function tearDown(): void
    {
        wpmvc_addon_phpunit_reset();
    }
    /**
     * Test init.
     * @since 1.0.11
     * @group addon
     */
    public function testInit()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new AdministratorAddon($bridge);
        // Run
        $addon->init();
        // Assert
        $this->assertAddedFilter( 'administrator_models' );
        $this->assertAddedFilter( 'administrator_no_value_fields' );
        $this->assertAddedFilter( 'administrator_bool_fields' );
    }
    /**
     * Test init.
     * @since 1.0.11
     * @group addon
     */
    public function testOnAdmin()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new AdministratorAddon($bridge);
        // Run
        $addon->on_admin();
        // Assert
        $this->assertAddedAction( 'admin_enqueue_scripts' );
        $this->assertAddedAction( 'admin_menu' );
        $this->assertAddedFilter( 'administrator_controls' );
        $this->assertAddedFilter( 'administrator_control_tr' );
        $this->assertAddedFilter( 'administrator_control_section' );
    }
    /**
     * Test init.
     * @since 1.0.11
     * @group addon
     */
    public function testSettingsInit()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new AdministratorAddon($bridge);
        // Run
        $addon->settings_init();
        // Assert
        $this->assertAppliedFilters( 'administrator_models' );
    }
    /**
     * Test init.
     * @since 1.0.11
     * @group addon
     */
    public function testRegisterControls()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new AdministratorAddon($bridge);
        // Run
        $controls = $addon->register_controls();
        // Assert
        $this->assertNotEmpty( $controls );
        $this->assertCount( 14, $controls );
    }
    /**
     * Test init.
     * @since 1.0.11
     * @group addon
     */
    public function testAdminEnqueue()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new AdministratorAddon($bridge);
        // Run
        $addon->admin_enqueue();
        // Assert
        $this->assertHasCalledWP( 'get_locale' );
        $this->assertHasRegisterStyle( 'font-awesome' );
    }
}