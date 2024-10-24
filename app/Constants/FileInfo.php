<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      =>'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/logoIcon',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      =>'assets/images/user/profile',
            'size'      =>'350x300',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];
        $data['clinic'] = [
            'path'      =>'assets/admin/images/clinic',
            'size'      =>'400x400',
        ];
        $data['hospital'] = [
            'path'      =>'assets/admin/images/hospital',
            'size'      =>'400x400',
        ];
        $data['listing'] = [
            'path'      =>'assets/admin/images/listing',
            'size'      =>'400x400',
        ];
        $data['pets'] = [
            'path'      =>'assets/images/pets',
            'size'      =>'400x400',
        ];
        $data['petsdisease'] = [
            'path'      =>'assets/images/petsdisease',
            'size'      =>'400x400',
        ];
        $data['department'] = [
            'path'      =>'assets/images/department',
            'size'      =>'65x65',
        ];
        $data['groups'] = [
            'path'      =>'assets/images/groups',
            'size'      =>'65x65',
        ];
        $data['pages'] = [
            'path'      =>'assets/images/pages',
            'size'      =>'65x65',
        ];
        $data['blogs'] = [
            'path'      =>'assets/images/blogs',
            'size'      =>'65x65',
        ];
        $data['news'] = [
            'path'      =>'assets/images/news',
            'size'      =>'65x65',
        ];

        $data['doctorProfile'] = [
            'path'      =>'assets/images/doctor',
            'size'      =>'300x240',
        ];
        $data['assistantProfile'] = [
            'path'      =>'assets/images/assistant',
            'size'      =>'400x400',
        ];
        $data['staffProfile'] = [
            'path'      =>'assets/images/staff',
            'size'      =>'400x400',
        ];
        $data['maintenance'] = [
            'path'      =>'assets/images/maintenance',
            'size'      =>'700x400',
        ];

        return $data;
	}

}
