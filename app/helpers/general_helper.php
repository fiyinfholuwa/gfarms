<?php 

use App\Models\KycLevel;
use App\Models\User;



if (!function_exists('has_paid_onboarding')) {
    function has_paid_onboarding($user_id) {
        $info = User::where('id', $user_id)->first();
        if(!$info){
            return false;
        }
        if($info->has_paid_onboarding ==='no'){
            return false;
        }
        return true;
    }
}
if (!function_exists('has_done_kyc')) {
    function has_done_kyc($user_id) {
        $info = User::where('id', $user_id)->first();
        if(!$info){
            return false;
        }
        if($info->has_done_kyc ==='no'){
            return false;
        }
        return true;
    }
}

// app/Helpers/CustomHelper.php

// app/Helpers/CustomHelper.php
if (!function_exists('kyc_levels')) {
    function kyc_levels() {
        return KycLevel::all()->mapWithKeys(function ($level) {
            return [
                $level->key => [
                    'title' => $level->title,
                    'description' => $level->description,
                    'endpoint' => route('kyc.process', ['level' => $level->key]),
                ]
            ];
        })->toArray();
    }
}

?>