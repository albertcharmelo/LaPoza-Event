<!--**********************************
    Sidebar start
***********************************-->
<div class="deznav" style="background: #0f0e16ea !important">
    <div class="deznav-scroll" style="background: #0f0e16ea !important">
        <ul class="metismenu" id="menu">
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Panel</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/'); !!}">Eventos</a></li>
                    <li><a href="{!! url('/invitaciones/index'); !!}">Invitaciones</a></li>

                    {{-- <li><a href="{!! url('/index-2'); !!}">Dashboard Dark</a></li>
                    <li><a href="{!! url('/order-page-list'); !!}">Orders</a></li>
                    <li><a href="{!! url('/order-details-page'); !!}">Order Details</a></li>
                    <li><a href="{!! url('/customer-page-list'); !!}">Customers</a></li>
                    <li><a href="{!! url('/analytics'); !!}">Analytics</a></li>
                    <li><a href="{!! url('/review'); !!}">Review</a></li> --}}
                </ul>
            </li>
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-050-info"></i>
                    <span class="nav-text">Apps</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/app-profile'); !!}">Profile</a></li>
                    <li><a href="{!! url('/post-details'); !!}">Post Details</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/email-compose'); !!}">Compose</a></li>
                            <li><a href="{!! url('/email-inbox'); !!}">Inbox</a></li>
                            <li><a href="{!! url('/email-read'); !!}">Read</a></li>
                        </ul>
                    </li>
                    <li><a href="{!! url('/app-calender'); !!}">Calendar</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Shop</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/ecom-product-grid'); !!}">Product Grid</a></li>
                            <li><a href="{!! url('/ecom-product-list'); !!}">Product List</a></li>
                            <li><a href="{!! url('/ecom-product-detail'); !!}">Product Details</a></li>
                            <li><a href="{!! url('/ecom-product-order'); !!}">Order</a></li>
                            <li><a href="{!! url('/ecom-checkout'); !!}">Checkout</a></li>
                            <li><a href="{!! url('/ecom-invoice'); !!}">Invoice</a></li>
                            <li><a href="{!! url('/ecom-customers'); !!}">Customers</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-041-graph"></i>
                    <span class="nav-text">Charts</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/chart-flot'); !!}">Flot</a></li>
                    <li><a href="{!! url('/chart-morris'); !!}">Morris</a></li>
                    <li><a href="{!! url('/chart-chartjs'); !!}">Chartjs</a></li>
                    <li><a href="{!! url('/chart-chartist'); !!}">Chartist</a></li>
                    <li><a href="{!! url('/chart-sparkline'); !!}">Sparkline</a></li>
                    <li><a href="{!! url('/chart-peity'); !!}">Peity</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-086-star"></i>
                    <span class="nav-text">Bootstrap</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/ui-accordion'); !!}">Accordion</a></li>
                    <li><a href="{!! url('/ui-alert'); !!}">Alert</a></li>
                    <li><a href="{!! url('/ui-badge'); !!}">Badge</a></li>
                    <li><a href="{!! url('/ui-button'); !!}">Button</a></li>
                    <li><a href="{!! url('/ui-modal'); !!}">Modal</a></li>
                    <li><a href="{!! url('/ui-button-group'); !!}">Button Group</a></li>
                    <li><a href="{!! url('/ui-list-group'); !!}">List Group</a></li>
                    <li><a href="{!! url('/ui-card'); !!}">Cards</a></li>
                    <li><a href="{!! url('/ui-carousel'); !!}">Carousel</a></li>
                    <li><a href="{!! url('/ui-dropdown'); !!}">Dropdown</a></li>
                    <li><a href="{!! url('/ui-popover'); !!}">Popover</a></li>
                    <li><a href="{!! url('/ui-progressbar'); !!}">Progressbar</a></li>
                    <li><a href="{!! url('/ui-tab'); !!}">Tab</a></li>
                    <li><a href="{!! url('/ui-typography'); !!}">Typography</a></li>
                    <li><a href="{!! url('/ui-pagination'); !!}">Pagination</a></li>
                    <li><a href="{!! url('/ui-grid'); !!}">Grid</a></li>

                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Plugins</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/uc-select2'); !!}">Select 2</a></li>
                    <li><a href="{!! url('/uc-nestable'); !!}">Nestedable</a></li>
                    <li><a href="{!! url('/uc-noui-slider'); !!}">Noui Slider</a></li>
                    <li><a href="{!! url('/uc-sweetalert'); !!}">Sweet Alert</a></li>
                    <li><a href="{!! url('/uc-toastr'); !!}">Toastr</a></li>
                    <li><a href="{!! url('/map-jqvmap'); !!}">Jqv Map</a></li>
                    <li><a href="{!! url('/uc-lightgallery'); !!}">Light Gallery</a></li>
                </ul>
            </li>
            <li><a href="{!! url('/widget-basic'); !!}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Widget</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-072-printer"></i>
                    <span class="nav-text">Forms</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/form-element'); !!}">Form Elements</a></li>
                    <li><a href="{!! url('/form-wizard'); !!}">Wizard</a></li>
                    <li><a href="{!! url('/form-ckeditor'); !!}">CkEditor</a></li>
                    <li><a href="{!! url('/form-pickers'); !!}">Pickers</a></li>
                    <li><a href="{!! url('/form-validation'); !!}">Form Validate</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-043-menu"></i>
                    <span class="nav-text">Table</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/table-bootstrap-basic'); !!}">Bootstrap</a></li>
                    <li><a href="{!! url('/table-datatable-basic'); !!}">Datatable</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/page-login'); !!}">Login</a></li>
                    <li><a href="{!! url('/page-register'); !!}">Register</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/page-error-400'); !!}">Error 400</a></li>
                            <li><a href="{!! url('/page-error-403'); !!}">Error 403</a></li>
                            <li><a href="{!! url('/page-error-404'); !!}">Error 404</a></li>
                            <li><a href="{!! url('/page-error-500'); !!}">Error 500</a></li>
                            <li><a href="{!! url('/page-error-503'); !!}">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="{!! url('/page-lock-screen'); !!}">Lock Screen</a></li>
                    <li><a href="{!! url('/empty-page'); !!}">Empty Page</a></li>
                </ul>
            </li> --}}
        </ul>
        {{-- <div class="plus-box">
            <img src="{{ asset('images/plus.png') }}" alt="">
            <h5 class="fs-18 font-w700">Add Menus</h5>
            <p class="fs-14 font-w400">Manage your food <br>and beverages menus<i class="fas fa-arrow-right ms-3"></i>
            </p>
        </div>
        <div class="copyright">
            <p><strong>Lezato Restaurant Admin</strong> © 2023 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
        </div> --}}
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->