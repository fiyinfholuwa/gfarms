<?php 

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
        return [
            'low' => [
                'title' => 'Low Level Account',
                'description' => '
                    <p>Designed for students, unemployed individuals, or low-income earners. Requires minimal documents (only ID).</p>
                    <p><strong>Credit Limit:</strong> ₦10,000 – ₦50,000</p>
                    <p><strong>Repayment Period:</strong> 30 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 equal weekly installments</li>
                        <li>Semi-Weekly: 2 installments every week (8 total within 30 days)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (2 total)</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>
                ',
                'endpoint' => route('kyc.process', ['level' => 'low']),
            ],
            'medium' => [
                'title' => 'Medium Level Account',
                'description' => '
                    <p>For civil servants, teachers, and small business owners with moderate income. Requires ID and proof of address.</p>
                    <p><strong>Credit Limit:</strong> ₦51,000 – ₦200,000</p>
                    <p><strong>Repayment Period:</strong> 30 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 equal weekly installments</li>
                        <li>Semi-Weekly: 2 installments every week (8 total within 30 days)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (2 total)</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>
                ',
                'endpoint' => route('kyc.process', ['level' => 'medium']),
            ],
            'high' => [
                'title' => 'High Level Account',
                'description' => '
                    <p>For senior civil servants, professionals, and mid-sized business owners. Requires ID, proof of address, and income verification.</p>
                    <p><strong>Credit Limit:</strong> ₦201,000 – ₦500,000+</p>
                    <p><strong>Repayment Period:</strong> 60 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 installments over 8 weeks (8 total)</li>
                        <li>Semi-Weekly: 2 installments every week for 2 months (8 total)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (4 total)</li>
                        <li>Monthly: 2 equal monthly payments</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>
                ',
                'endpoint' => route('kyc.process', ['level' => 'high']),
            ],
            'market_woman' => [
                'title' => 'Market Women/ Men Account',
                'description' => '
                    <p>Special verification for traders, food vendors, and small market business owners. Requires simplified documents.</p>
                    <p><strong>Credit Limit:</strong> Flexible (determined by admin based on business size & turnover)</p>
                    <p><strong>Repayment Period:</strong> Daily or weekly, based on user convenience</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Daily: Small, consistent amounts paid every day</li>
                        <li>Weekly: Full weekly installment once every 7 days</li>
                        <li>Semi-Flexible: Payments anytime, but full amount must be completed within 30 days</li>
                    </ul>
                ',
                'endpoint' => route('kyc.process', ['level' => 'market_woman']),
            ],
        ];
    }
}

?>