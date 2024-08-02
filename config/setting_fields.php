<?php

return [
    'app' => [
        'title' => 'General',
        'desc' => 'All the general settings for application.',
        'icon' => 'fa fa-cog',
        'elements' => [
            [
                'name' => 'app_name',
                'label' => 'Home title',
                'type' => 'text',
                'data' => 'string',
                'rules' => '',
                'value' => 'Venture New Zealand'
            ],
            [
                'name' => 'home_description',
                'label' => 'Home description',
                'type' => 'textarea',
                'data' => 'string',
                'rules' => '',
                'value' => 'Venture New Zealand is a Laravel Theme built on the Laravel 5.8 framework. With this theme, you can create your own City Travel Guide website with Points of Interest group by Categories (Sight, Restaurant, Drink, Shopping, Hotel, Fitness, Beaty, Activities...)' // default value if you want
            ],
            [
                'name' => 'logo', // unique name for field
                'label' => 'Logo Black', // you know what label it is
                'type' => 'file', // input fields type
                'data' => 'image', // data type, string, int, boolean, image
                'rules' => 'mimes:jpeg,jpg,png,gif|max:1000000000', // validation rule of laravel
            ],
            [
                'name' => 'logo_white',
                'label' => 'Logo White',
                'type' => 'file',
                'data' => 'image',
                'rules' => 'mimes:jpeg,jpg,png,gif|max:1000000000',
            ],
            [
                'name' => 'home_page_video_link',
                'label' => 'Home Page video',
                'type' => 'file',
                'data' => 'video',
                'rules' => 'mimes:mp4|max:8000000000',
            ],

        ]
    ],
    'subscription_prices_operator' => [
        'title' => 'Operator Subscription',
        'desc' => 'Stripe price id for operator',
        'icon' => 'fa fa-credit-card',
        'elements' => [
            [
                'name' => 'subscription_stripe_price_id_operator',
                'type' => 'text',
                'label' => 'Operator Stripe Price ID',
                'rules' => '',
                'value' => ''
            ],
            [
                'name' => 'operator_trial_days',
                'type' => 'text',
                'label' => 'Operator Free Trial Days',
                'rules' => '',
                'value' => ''
            ],
            [
                'name' => 'operator_trial_date',
                'type' => 'text',
                'label' => 'Operator Free Trial Date (Format: Y-m-d, example: 2022-06-01)',
                'rules' => 'date_format:Y-m-d',
                'value' => ''
            ],
        ]
    ],
    // 'subscription_prices_operator' => [
    //     'title' => 'Operator Subscription',
    //     'desc' => 'Subscription price and validity for operator',
    //     'icon' => 'fa fa-credit-card',
    //     'elements' => [
    //         [
    //             'name' => 'subscription_plan_name_operator',
    //             'type' => 'text',
    //             'label' => 'Operator Plan Name',
    //             'rules' => '',
    //             'value' => ''
    //         ],
    //         [
    //             'name' => 'subscription_price_operator',
    //             'type' => 'text',
    //             'label' => 'Operator Membership Price ($)',
    //             'rules' => '',
    //             'value' => ''
    //         ],
    //         [
    //             'name' => 'subscription_days_operator',
    //             'type' => 'text',
    //             'label' => 'Validity (Days)',
    //             'rules' => '',
    //             'value' => '30'
    //         ]
    //     ]
    // ],
    'subscription_prices_user' => [
        'title' => 'User Subscription',
        'desc' => 'Subscription price and validity for user',
        'icon' => 'fa fa-credit-card',
        'elements' => [
            [
                'name' => 'subscription_plan_name_user',
                'type' => 'text',
                'label' => 'User Plan Name',
                'rules' => '',
                'value' => ''
            ],
            [
                'name' => 'subscription_price_user',
                'type' => 'text',
                'label' => 'User Membership Price ($)',
                'rules' => '',
                'value' => '49'
            ],
            [
                'name' => 'subscription_days_user',
                'type' => 'text',
                'label' => 'Validity (Days)',
                'rules' => '',
                'value' => '30'
            ]
        ]
    ],
    'qr_code_scan_reward' => [
        'title' => 'Reward Points',
        'desc' => 'How many points user get when they scan any places QR code?',
        'icon' => 'fa fa-plus-circle',
        'elements' => [
            [
                'name' => 'reward_points',
                'type' => 'text',
                'label' => 'Reward Points',
                'rules' => '',
                'value' => ''
            ]
        ]
    ],
    'admin_commission_on_booking' => [
        'title' => 'Transaction fee %',
        'desc' => 'How much Admin Percentage(%) Transaction fee on Booking Order',
        'icon' => 'fa fa-plus-circle',
        'elements' => [
            [
                'name' => 'booking_commission_percentage',
                'type' => 'text',
                'label' => 'Transaction fee %',
                'rules' => '',
                'value' => ''
            ]
        ]
    ],
    'email' => [
        'title' => 'Email Settings',
        'desc' => 'Email received booking',
        'icon' => 'fa fa-envelope-o',
        'elements' => [
            [
                'name' => 'email_system',
                'type' => 'email',
                'label' => 'Email',
                'rules' => 'email',
            ]
        ]
    ],
    'contactus' => [
        'title' => 'Contact Us',
        'desc' => 'Email and Phone for contact us',
        'icon' => 'fa fa-envelope-o',
        'elements' => [
            [
                'name' => 'contactus_email',
                'type' => 'email',
                'label' => 'Email',
                'rules' => 'email',
            ],
            [
                'name' => 'contactus_phone',
                'type' => 'text',
                'label' => 'Phone',
                'rules' => '',
            ],
            [
                'name' => 'contactus_technical_email',
                'type' => 'email',
                'label' => 'Technical support email',
                'rules' => 'email',
            ]
        ]
    ],
    'mail_driver' => [
        'title' => 'SMTP Settings',
        'desc' => '',
        'icon' => 'fa fa-envelope-o',
        'elements' => [
            [
                'name' => 'mail_driver',
                'type' => 'text',
                'label' => 'Mail driver',
                'rules' => '',
                'value' => 'smtp'
            ],
            [
                'name' => 'mail_host',
                'type' => 'text',
                'label' => 'Mail host',
                'rules' => '',
                'value' => 'smtp.googlemail.com'
            ],
            [
                'name' => 'mail_port',
                'type' => 'text',
                'label' => 'Mail port',
                'rules' => '',
                'value' => '465'
            ],
            [
                'name' => 'mail_username',
                'type' => 'text',
                'label' => 'Mail username',
                'rules' => '',
            ],
            [
                'name' => 'mail_password',
                'type' => 'text',
                'label' => 'Mail password',
                'rules' => '',
            ],
            [
                'name' => 'mail_encryption',
                'type' => 'text',
                'label' => 'Mail encryption',
                'rules' => '',
                'value' => 'ssl'
            ],
            [
                'name' => 'mail_from_address',
                'type' => 'text',
                'label' => 'Mail from address',
                'rules' => '',
                'value' => 'hello@uxper.co'
            ],
            [
                'name' => 'mail_from_name',
                'type' => 'text',
                'label' => 'Mail from name',
                'rules' => '',
                'value' => 'uxper'
            ],

        ]
    ],

    'ads' => [
        'title' => 'Ads Settings',
        'desc' => '',
        'icon' => 'fa fa-external-link-square',
        'elements' => [
            [
                'name' => 'ads_sidebar_banner_image', // unique name for field
                'label' => 'Banner ads image', // you know what label it is
                'type' => 'file', // input fields type
                'data' => 'image', // data type, string, int, boolean, image
                'rules' => 'mimes:jpeg,jpg,png,gif|max:10000', // validation rule of laravel
            ],
            [
                'name' => 'ads_sidebar_banner_link', // unique name for field
                'label' => 'Banner ads link', // you know what label it is
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean, image
                'rules' => '', // validation rule of laravel
            ]
        ]
    ],

    'social_auth_facebook' => [
        'title' => 'Social login setting',
        'desc' => '',
        'icon' => 'fa fa-envelope-o',
        'elements' => [
            [
                'name' => 'facebook_app_id',
                'type' => 'text',
                'label' => 'Facebook App ID',
                'rules' => '',
            ],
            [
                'name' => 'facebook_app_secret',
                'type' => 'text',
                'label' => 'Facebook App Secret',
                'rules' => '',
            ],

            [
                'name' => 'google_app_id',
                'type' => 'text',
                'label' => 'Google App ID',
                'rules' => '',
            ],
            [
                'name' => 'google_app_secret',
                'type' => 'text',
                'label' => 'Google App Secret',
                'rules' => '',
            ],

        ]
    ],

    'homepage' => [
        'title' => 'Homepage Settings',
        'desc' => '',
        'icon' => 'fa fa-external-link-square',
        'elements' => [
            [
                'name' => 'home_banner', // unique name for field
                'label' => 'Home banner', // you know what label it is
                'type' => 'file', // input fields type
                'data' => 'image', // data type, string, int, boolean, image
                'rules' => 'mimes:jpeg,jpg,png,gif|max:10000', // validation rule of laravel
            ],
            [
                'name' => 'home_banner_app', // unique name for field
                'label' => 'Home banner app', // you know what label it is
                'type' => 'file', // input fields type
                'data' => 'image', // data type, string, int, boolean, image
                'rules' => 'mimes:jpeg,jpg,png,gif|max:10000', // validation rule of laravel
            ]
        ]
    ],

    'google' => [
        'title' => 'Map settings',
        'desc' => '',
        'icon' => 'fa fa-external-link-square',
        'elements' => [
            [
                'name' => 'goolge_map_api_key',
                'label' => 'Google Map API Key',
                'type' => 'text',
                'data' => 'string',
                'rules' => '',
            ],
            [
                'name' => 'mapbox_access_token',
                'label' => 'Mapbox Access Token',
                'type' => 'text',
                'data' => 'string',
                'rules' => '',
            ],
            [
                'name' => 'map_service',
                'label' => 'Map service',
                'type' => 'select',
                'data' => 'string',
                'rules' => '',
                'options' => [
                    'google_map' => 'Goolge Map',
                    'mapbox' => 'Mapbox (mapbox.com)',
                ]
            ]
        ]
    ],

    'Theme' => [
        'title' => 'Theme settings',
        'desc' => '',
        'icon' => 'fa fa-external-link-square',
        'elements' => [
            [
                'name' => 'style_rtl', // unique name for field
                'label' => 'RTL', // you know what label it is
                'type' => 'select', // input fields type
                'data' => 'string', // data type, string, int, boolean, image
                'rules' => '', // validation rule of laravel
                'options' => [
                    '0' => 'Disable',
                    '1' => 'Enable'
                ]
            ],

            [
                'name' => 'template',
                'label' => 'Template',
                'type' => 'select',
                'data' => 'string',
                'rules' => '',
                'options' => [
                    '01' => 'Template 01 (City guide)',
                    '02' => 'Template 02 (Business listing)',
                    '03' => 'Template 03 (Restaurant)'
                ]
            ],

        ]
    ],

    'social_media_link' => [
        'title' => 'Social Media Links',
        'desc' => '',
        'icon' => 'fa fa-link',
        'elements' => [
            [
                'name' => 'facebook_url',
                'type' => 'text',
                'label' => 'Facebook URL',
                'rules' => '',
            ],
            [
                'name' => 'instagram_url',
                'type' => 'text',
                'label' => 'Instagram URL',
                'rules' => '',
            ],

            [
                'name' => 'youtube_url',
                'type' => 'text',
                'label' => 'YouTube URL',
                'rules' => '',
            ]
        ]
    ],

    'facebook_conversion_api' => [
        'title' => 'Facebook Conversion Api',
        'desc' => '',
        'icon' => 'fa fa-cogs',
        'elements' => [
            [
                'name' => 'ConversionAPIToken',
                'type' => 'textarea',
                'label' => 'Conversion API Token',
                'rules' => '',
            ],
            [
                'name' => 'ConversionPixelId',
                'type' => 'text',
                'label' => 'Conversion Pixel Id',
                'rules' => '',
            ]
        ]
    ],
];
