<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\UserCountry;

use Piwik\SettingsPiwik;
class Tasks extends \Piwik\Plugin\Tasks
{
    public function schedule()
    {
        // add the auto updater task if GeoIP admin is enabled
        if (UserCountry::isGeoLocationAdminEnabled() && SettingsPiwik::isInternetEnabled() === true) {
            /**
             * @todo remove legacy GeoIP Updater in any version released after 2018/5/1
             */
            if (time() < mktime(0, 0, 0, 5, 1, 2018)) {
                $this->scheduleTask(new GeoIPLegacyAutoUpdater());
            }
            $this->scheduleTask(new GeoIP2AutoUpdater());
        }
    }
}