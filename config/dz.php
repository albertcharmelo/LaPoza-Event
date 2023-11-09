<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Lezato Laravel'),


    'public' => [
        'favicon' => 'media/img/logo/favicon.ico',
        'fonts' => [
            'google' => [
                'families' => [
                    'Poppins:300,400,500,600,700',
                ]
            ]
        ],
		'global' => [
			'css' => [
				'vendor/jquery-nice-select/css/nice-select.css',
				'css/style.css',
			],
			'js' => [
				'top'=>[
					'vendor/global/global.min.js',
					'vendor/jquery-nice-select/js/jquery.nice-select.min.js',	
				],
				'bottom'=>[
					'js/custom.min.js',
					'js/deznav-init.js',
				],
			],
		],
		'pagelevel' => [
			'css' => [
				'LezatoadminController_dashboard' => [
							'vendor/chartist/css/chartist.min.css',
				],
				'LezatoadminController_dashboard_2' => [
							'vendor/chartist/css/chartist.min.css',
				],
				'LezatoadminController_order_page_list' => [
							'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'LezatoadminController_order_details_page' => [
							'vendor/chartist/css/chartist.min.css',
							'vendor/owl-carousel/owl.carousel.css',
				],
				'LezatoadminController_customer_page_list' => [
							'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'LezatoadminController_analytics' => [
							'vendor/chartist/css/chartist.min.css',
							'vendor/owl-carousel/owl.carousel.css',
				],
				'LezatoadminController_review' => [
				],
				'LezatoadminController_app_profile' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'LezatoadminController_post_details' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'LezatoadminController_app_calender' => [
							'vendor/fullcalendar/css/main.min.css',
				],
				'LezatoadminController_chart_chartist' => [
							'vendor/chartist/css/chartist.min.css',
				],
				'LezatoadminController_chart_chartjs' => [
				],
				'LezatoadminController_chart_flot' => [
				],
				'LezatoadminController_chart_morris' => [
				],
				'LezatoadminController_chart_peity' => [
				],
				'LezatoadminController_chart_sparkline' => [
				],
				'LezatoadminController_ecom_checkout' => [
				],
				'LezatoadminController_ecom_customers' => [
				],
				'LezatoadminController_ecom_invoice' => [
					'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
				],
				'LezatoadminController_ecom_product_detail' => [
							'vendor/star-rating/star-rating-svg.css',
				],
				'LezatoadminController_ecom_product_grid' => [
				],
				'LezatoadminController_ecom_product_list' => [
							'vendor/star-rating/star-rating-svg.css',
				],
				'LezatoadminController_ecom_product_order' => [
				],
				'LezatoadminController_email_compose' => [
							'vendor/dropzone/dist/dropzone.css',
				],
				'LezatoadminController_email_inbox' => [
				],
				'LezatoadminController_email_read' => [
				],
				'LezatoadminController_form_ckeditor' => [
				],
				'LezatoadminController_form_element' => [
				],
				'LezatoadminController_form_pickers' => [
							'vendor/bootstrap-daterangepicker/daterangepicker.css',
							'vendor/clockpicker/css/bootstrap-clockpicker.min.css',
							'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
							'vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
							'vendor/pickadate/themes/default.css',
							'vendor/pickadate/themes/default.date.css',
							'https://fonts.googleapis.com/icon?family=Material+Icons',
				],
				'LezatoadminController_form_validation' => [
				],
				'LezatoadminController_form_wizard' => [
							'vendor/jquery-smartwizard/dist/css/smart_wizard.min.css',
				],
				'LezatoadminController_map_jqvmap' => [
							'vendor/jqvmap/css/jqvmap.min.css',
				],
				'LezatoadminController_login' => [
							'vendor/sweetalert2/dist/sweetalert2.min.css',
				],
				'LezatoadminController_table_bootstrap_basic' => [
				],
				'LezatoadminController_table_datatable_basic' => [
							'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'LezatoadminController_uc_lightgallery' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'LezatoadminController_uc_nestable' => [
							'vendor/nestable2/css/jquery.nestable.min.css',
				],
				'LezatoadminController_uc_noui_slider' => [
							'vendor/nouislider/nouislider.min.css',
				],
				'LezatoadminController_uc_select2' => [
							'vendor/select2/css/select2.min.css',
				],
				'LezatoadminController_uc_sweetalert' => [
							'vendor/sweetalert2/dist/sweetalert2.min.css',
				],
				'LezatoadminController_uc_toastr' => [
							'vendor/toastr/css/toastr.min.css',
				],
				'LezatoadminController_ui_accordion' => [
				],
				'LezatoadminController_ui_alert' => [
				],
				'LezatoadminController_ui_badge' => [
				],
				'LezatoadminController_ui_button' => [
				],
				'LezatoadminController_ui_button_group' => [
				],
				'LezatoadminController_ui_card' => [
				],
				'LezatoadminController_ui_carousel' => [
				],
				'LezatoadminController_ui_dropdown' => [
				],
				'LezatoadminController_ui_grid' => [
				],
				'LezatoadminController_ui_list_group' => [
				],
				'LezatoadminController_ui_modal' => [
				],
				'LezatoadminController_ui_pagination' => [
				],
				'LezatoadminController_ui_popover' => [
				],
				'LezatoadminController_ui_progressbar' => [
				],
				'LezatoadminController_ui_tab' => [
				],
				'LezatoadminController_ui_typography' => [
				],
				'LezatoadminController_widget_basic' => [
							'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
							'vendor/chartist/css/chartist.min.css',
				],
				'LezatoadminController_page_error_400' => [
					'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
				],
				'LezatoadminController_demo_modules_index' => [
				],
				'LezatoadminController_demo_modules_add' => [
				],
			],
			'js' => [
				'LezatoadminController_dashboard' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/peity/jquery.peity.min.js',
							'js/dashboard/dashboard-1.js',
				],
				'LezatoadminController_dashboard_2' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/peity/jquery.peity.min.js',
							'js/dashboard/dashboard-1.js',
				],
				 'LezatoadminController_order_page_list' => [
				 			'vendor/datatables/js/jquery.dataTables.min.js',
				 			'js/plugins-init/datatables.init.js',
				],
				'LezatoadminController_order_details_page' => [
							'vendor/chart.js/Chart.bundle.min.js',
				 			'vendor/apexchart/apexchart.js',
							'vendor/owl-carousel/owl.carousel.js',
							'vendor/peity/jquery.peity.min.js',
							'js/dashboard/order-detail-page.js',
				],
				'LezatoadminController_customer_page_list' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/datatables/js/jquery.dataTables.min.js',
							'js/plugins-init/datatables.init.js',
				],
				'LezatoadminController_analytics' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/owl-carousel/owl.carousel.js',
							'vendor/peity/jquery.peity.min.js',
							'js/dashboard/analytics.js',
				],
				'LezatoadminController_review' => [
							'vendor/chart.js/Chart.bundle.min.js',
				],
				'LezatoadminController_app_calender' => [
							'vendor/moment/moment.min.js',
							'vendor/fullcalendar/js/main.min.js',
							'js/plugins-init/fullcalendar-init.js',
				],
				'LezatoadminController_app_profile' => [
							'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'LezatoadminController_post_details' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'LezatoadminController_chart_chartist' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/chartist/js/chartist.min.js',
							'vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js',
							'js/plugins-init/chartist-init.js',
				],
				'LezatoadminController_chart_chartjs' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'js/plugins-init/chartjs-init.js',
				],
				'LezatoadminController_chart_flot' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/flot/jquery.flot.js',
							'vendor/flot/jquery.flot.pie.js',
							'vendor/flot/jquery.flot.resize.js',
							'vendor/flot-spline/jquery.flot.spline.min.js',
							'js/plugins-init/flot-init.js',
				],
				'LezatoadminController_chart_morris' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/raphael/raphael.min.js',
							'vendor/morris/morris.min.js',
							'js/plugins-init/morris-init.js',
				],
				'LezatoadminController_chart_peity' => [
						    'vendor/chart.js/Chart.bundle.min.js',
							'vendor/peity/jquery.peity.min.js',
							'js/plugins-init/piety-init.js',
				],
				'LezatoadminController_chart_sparkline' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/jquery-sparkline/jquery.sparkline.min.js',
							'js/plugins-init/sparkline-init.js',
							'vendor/svganimation/vivus.min.js',
							'vendor/svganimation/svg.animation.js',
				],
				'LezatoadminController_ecom_checkout' => [
				],
				'LezatoadminController_ecom_customers' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/highlightjs/highlight.pack.min.js',
				],
				'LezatoadminController_ecom_invoice' => [
				],
				'LezatoadminController_ecom_product_detail' => [
							'vendor/star-rating/jquery.star-rating-svg.js',
                ],
				'LezatoadminController_ecom_product_grid' => [
				],
				'LezatoadminController_ecom_product_list' => [
							'vendor/star-rating/jquery.star-rating-svg.js',
				],
				'LezatoadminController_ecom_product_order' => [
				],
				'LezatoadminController_email_compose' => [
							'vendor/dropzone/dist/dropzone.js',
				],
				'LezatoadminController_email_inbox' => [
				],
				'LezatoadminController_email_read' => [
				],
				'LezatoadminController_form_ckeditor' => [
							'vendor/ckeditor/ckeditor.js',
				],
				'LezatoadminController_form_element' => [
				],
				'LezatoadminController_form_pickers' => [
							'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/moment/moment.min.js',
							'vendor/bootstrap-daterangepicker/daterangepicker.js',
							'vendor/clockpicker/js/bootstrap-clockpicker.min.js',
							'vendor/jquery-asColor/jquery-asColor.min.js',
							'vendor/jquery-asGradient/jquery-asGradient.min.js',
							'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
							'vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js',
							'vendor/pickadate/picker.js',
							'vendor/pickadate/picker.time.js',
							'vendor/pickadate/picker.date.js',
							'js/plugins-init/bs-daterange-picker-init.js',
							'js/plugins-init/clock-picker-init.js',
							'js/plugins-init/jquery-asColorPicker.init.js',
							'js/plugins-init/material-date-picker-init.js',
							'js/plugins-init/pickadate-init.js',
				],
				'LezatoadminController_form_validation' => [
				],
				'LezatoadminController_form_wizard' => [
							'vendor/jquery-steps/build/jquery.steps.min.js',
							'vendor/jquery-validation/jquery.validate.min.js',
							'js/plugins-init/jquery.validate-init.js',
							'vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js',
				],
				'LezatoadminController_map_jqvmap' => [
							'vendor/jqvmap/js/jquery.vmap.min.js',
							'vendor/jqvmap/js/jquery.vmap.world.js',
							'vendor/jqvmap/js/jquery.vmap.usa.js',
							'js/plugins-init/jqvmap-init.js',
				],
				'LezatoadminController_page_lock_screen' => [
							'vendor/dlabnav/dlabnav.min.js',
				],
				'LezatoadminController_table_bootstrap_basic' => [
				],
				'LezatoadminController_table_datatable_basic' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/datatables/js/jquery.dataTables.min.js',
							'js/plugins-init/datatables.init.js',
				],
				'LezatoadminController_uc_lightgallery' => [
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'LezatoadminController_uc_nestable' => [
							'vendor/nestable2/js/jquery.nestable.min.js',
							'js/plugins-init/nestable-init.js',
				],
				'LezatoadminController_uc_noui_slider' => [
							'vendor/nouislider/nouislider.min.js',
							'vendor/wnumb/wNumb.js',
							'js/plugins-init/nouislider-init.js',
				],
				'LezatoadminController_uc_select2' => [
							'vendor/select2/js/select2.full.min.js',
							'js/plugins-init/select2-init.js',
				],
				'LezatoadminController_uc_sweetalert' => [
							'vendor/sweetalert2/dist/sweetalert2.min.js',
							'js/plugins-init/sweetalert.init.js',
				],
				'LezatoadminController_uc_toastr' => [
							'vendor/toastr/js/toastr.min.js',
							'js/plugins-init/toastr-init.js',
				],
				'LezatoadminController_ui_accordion' => [
				],
				'LezatoadminController_ui_alert' => [
				],
				'LezatoadminController_ui_badge' => [
				],
				'LezatoadminController_ui_button' => [
				],
				'LezatoadminController_ui_button_group' => [
				],
				'LezatoadminController_ui_card' => [
				],
				'LezatoadminController_ui_carousel' => [
				],
				'LezatoadminController_ui_dropdown' => [
				],
				'LezatoadminController_ui_grid' => [
				],
				'LezatoadminController_ui_list_group' => [
				],
				'LezatoadminController_ui_modal' => [
				],
				'LezatoadminController_ui_pagination' => [
				],
				'LezatoadminController_ui_popover' => [
				],
				'LezatoadminController_ui_progressbar' => [
				],
				'LezatoadminController_ui_tab' => [
				],
				'LezatoadminController_ui_typography' => [
				],
				'LezatoadminController_widget_basic' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/chartist/js/chartist.min.js',
							'vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js',
							'vendor/flot/jquery.flot.js',
							'vendor/flot/jquery.flot.pie.js',
							'vendor/flot/jquery.flot.resize.js',
							'vendor/flot-spline/jquery.flot.spline.min.js',
							'vendor/jquery-sparkline/jquery.sparkline.min.js',
							'js/plugins-init/sparkline-init.js',
							'vendor/peity/jquery.peity.min.js',
							'js/plugins-init/piety-init.js',
							'js/plugins-init/widgets-script-init.js',
				],
				'LezatoadminController_demo_modules_add' => [
				],
					
			]
		],
	]
];
