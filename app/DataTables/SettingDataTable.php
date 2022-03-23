<?php

namespace App\DataTables;

use App\Models\Setting;

/**
 * Class SettingDataTable
 */
class SettingDataTable
{
    /**
     * @return Setting
     */
    public function get()
    {
        /** @var Setting $query */
        $query = Setting::query()->select('settings.*');

        return $query;
    }
}
