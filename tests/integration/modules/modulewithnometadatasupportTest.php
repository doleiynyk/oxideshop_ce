<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2014
 * @version   OXID eShop CE
 */

require_once realpath(dirname(__FILE__)) . '/basemoduleTestCase.php';

class Integration_Modules_ModuleWithNoMetadataSupportTest extends BaseModuleTestCase
{
    public function testModulesWithoutMetadataShouldBeAddToCleanup()
    {
        // modules to be activated during test preparation
        $aInstallModules = array(
            'extending_1_class', 'with_2_templates', 'with_2_files', 'with_2_settings',
            'extending_3_blocks', 'with_everything', 'with_events'
        );

        $oEnvironment = new Environment();
        $oEnvironment->prepare( $aInstallModules );

        //adding module without metadata
        $aModules = $this->getConfig()->getConfigParam('aModules');
        $aModules['oxClass'] = 'no_metadata/myClass';

        $this->getConfig()->setConfigParam('aModules', $aModules );

        $oModuleList = new oxModuleList();
        $aGarbage = $oModuleList->getDeletedExtensions();

        $this->assertSame(  array('no_metadata'), $aGarbage['modules_without_metadata'] );
    }

    public function testModulesWithoutMetadataShouldBeAddToCleanupAllModulesWithMetadata()
    {
        // modules to be activated during test preparation
        $aInstallModules = array(
            'extending_1_class', 'with_2_templates', 'with_2_files', 'with_2_settings',
            'extending_3_blocks', 'with_everything', 'with_events'
        );

        $oEnvironment = new Environment();
        $oEnvironment->prepare( $aInstallModules );

        $oModuleList = new oxModuleList();
        $aGarbage = $oModuleList->getDeletedExtensions();

        $this->assertSame(  array(), $aGarbage['modules_without_metadata'] );
    }

}