<?php

return [
    'Settings' => [
        'Firewall' => [
            'groups' => [
                'Firewall.General' => [
                    'label' => __d('admin', 'Firewall configuration'),
                ],
                'Firewall.Shieldon' => [
                    'label' => __d('admin', 'Shieldon settings'),
                ],
            ],
            'schema' => [
                // General
                'Firewall.enabled' => [
                    'group' => 'Firewall.General',
                    'type' => 'boolean',
                    'label' => __d('admin', 'Enable Firewall'),
                    'help' => __d('admin', 'Enable or disable all firewall features provided by this plugin'),
                    'default' => false,
                ],

                // Shieldon specific settings
            ],
        ]
    ]
];
