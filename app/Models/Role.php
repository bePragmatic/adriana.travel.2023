<?php

/**
 * Role Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Role
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use DB;

class Role extends EntrustRole
{
	// Get permission_id in lists type
    public static function permission_role($id)
    {
        return DB::table('permission_role')->where('role_id', $id)->pluck('permission_id')->all();
    }

    // Get role_user data by using given id
    public static function role_user($id)
    {
        return DB::table('role_user')->where('user_id', $id)->first();
    }
}
