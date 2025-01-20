<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#"><span class="brand-logo">
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    <h2 class="brand-text">{{ config('app.name', 'LMS') }}</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ \Request::is('dashboard') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/tax') || \Request::is('backend/tax/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('tax.index') }}">
                    <i data-feather="hash"></i>
                    <span class="menu-title text-truncate" data-i18n="Taxes">Taxes</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/topic') || \Request::is('backend/topic/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('topic.index') }}">
                    <i data-feather="filter"></i>
                    <span class="menu-title text-truncate" data-i18n="Topics">Topics</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/channel') || \Request::is('backend/channel/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('channel.index') }}">
                    <i data-feather="filter"></i>
                    <span class="menu-title text-truncate" data-i18n="Spaces">Spaces</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/course-type/*') ? 'active' : '' }}  nav-item">
                <a class="d-flex align-items-center" href="{{ route('course-type.index') }}">
                    <i data-feather="video"></i>
                    <span class="menu-title text-truncate" data-i18n="Courses">Course Type</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/course') || \Request::is('backend/course/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('course.index') }}">
                    <i data-feather="video"></i>
                    <span class="menu-title text-truncate" data-i18n="Courses">Courses</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/question') || \Request::is('backend/question/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('question.index') }}">
                    <i data-feather="help-circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Questions">Questions</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/comment') || \Request::is('backend/comment/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('comment.index') }}">
                    <i data-feather="help-circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Reported Comments">Reported Comments</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/discount') || \Request::is('backend/discount/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('discount.index') }}">
                    <i data-feather="filter"></i>
                    <span class="menu-title text-truncate" data-i18n="Discounts">Discounts</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/order') || \Request::is('backend/order/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('order.index') }}">
                    <i data-feather="printer"></i>
                    <span class="menu-title text-truncate" data-i18n="Orders">Orders</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/invoice') || \Request::is('backend/invoice/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('invoice.index') }}">
                    <i data-feather="printer"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoices">Invoices</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/menu') || \Request::is('backend/menu/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('menu.index') }}">
                    <i data-feather="upload"></i>
                    <span class="menu-title text-truncate" data-i18n="Menu">Menu</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/footer') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('footer.edit') }}">
                    <i data-feather="download"></i>
                    <span class="menu-title text-truncate" data-i18n="Footer">Footer</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/section-view') || \Request::is('backend/section-view/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('section-view.index') }}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Section Views">Section Views</span>
                </a>
            </li>  

            <li class="{{ \Request::is('backend/collection') || \Request::is('backend/collection/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('collection.index') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Collections">Collections</span>
                </a>
            </li> 

            <li class="{{ \Request::is('backend/page') || \Request::is('backend/page/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('page.index') }}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Pages</span>
                </a>
            </li> 
            
            <li class="{{ \Request::is('backend/banner') || \Request::is('backend/banner/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('banner.index') }}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Banners">Banners</span>
                </a>
            </li> 

            <li class="{{ \Request::is('backend/enquiry') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('enquiry.index') }}">
                    <i data-feather="help-circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Enquiries">Enquiries</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/flagged-replies') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('flagged.replies.index') }}">
                    <i data-feather="flag"></i>
                    <span class="menu-title text-truncate" data-i18n="Flagged Replies">Flagged Questions/Replies</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/user') || \Request::is('backend/user/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('user.index') }}">
                    <i data-feather="users"></i>
                    <span class="menu-title text-truncate" data-i18n="Users">Users</span>
                </a>
            </li>

            <li class="{{ \Request::is('backend/newsletter') || \Request::is('backend/newsletter/*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('newsletter') }}">
                    <i data-feather="users"></i>
                    <span class="menu-title text-truncate" data-i18n="Newsletter">Newsletter</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i data-feather="power"></i>
                    <span class="menu-title text-truncate" data-i18n="Logout">Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->