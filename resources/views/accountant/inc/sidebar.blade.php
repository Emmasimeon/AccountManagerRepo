
<div class="app-sidebar sidebar sidebar-shadow bg-primary sidebar-text-light">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Dashboards</li>
                                <li>
                                    <a href="/dashboard" class="mm-active">
                                        <i class="metismenu-icon pe-7s-server"></i>
                                        Dashboard
                                    </a>
                                </li>

                                <!--Start - Student Operation Menu Start Here -->
                                <li class="app-sidebar__heading">STUDENTS</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-users"></i>
                                        Students
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                    @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Cashiers' || Auth::user()->user_category == 'Super Admin')
                                        <li>
                                            <a href="/New_Student">
                                                <i class="metismenu-icon"></i>
                                                Add New Student
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Select_Class">
                                                <i class="metismenu-icon">
                                                </i>View Students
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Setup_Student_Payment">
                                                <i class="metismenu-icon">
                                                </i>Setup Student Payment
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/Select_Class">
                                                <i class="metismenu-icon">
                                                </i>View Students
                                            </a>
                                        </li>
                                    @endif
                                    </ul>
                                </li>
                                <!--End - Student Operation Menu -->

                                <!--Start - Cash & Bank Operation Menu Start Here -->
                                <li class="app-sidebar__heading">CASH & BANK</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-cash"></i>
                                        Cash & Bank
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                    @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Super Admin')
                                        <li>
                                            <a href="/Cash/Remittances">
                                                <i class="metismenu-icon"></i>
                                                Cash Remittances
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Cash/Rem/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Remittances History
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Cash/Banking">
                                                <i class="metismenu-icon">
                                                </i>Cash Banking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Cash/Bank/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Banking History
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Cash/Withdrawal">
                                                <i class="metismenu-icon">
                                                </i>Cash Withdrawal
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Cash/With/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Withdrawal History
                                            </a>
                                        </li>
                                    @elseif (Auth::user()->user_category == 'Cashiers' || Auth::user()->user_category == 'Secretary')
                                        <li>
                                            <a href="/Cash/Remittances">
                                                <i class="metismenu-icon"></i>
                                                Cash Remittances
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="/Cash/Banking">
                                                <i class="metismenu-icon">
                                                </i>Cash Banking
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="/Cash/Withdrawal">
                                                <i class="metismenu-icon">
                                                </i>Cash Withdrawal
                                            </a>
                                        </li>
                                    @elseif (Auth::user()->user_category == 'Director')
                                        
                                        <li>
                                            <a href="/Cash/Rem/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Remittances History
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="/Cash/Bank/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Banking History
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="/Cash/With/History">
                                                <i class="metismenu-icon">
                                                </i>Cash Withdrawal History
                                            </a>
                                        </li>
                                    @endif
                                        
                                        
                                    </ul>
                                </li>
                                <!--End - Cash & Bank Operation Menu -->

                                <!--Start - Payout & Vouchers Operation Menu Start Here -->
                                <li class="app-sidebar__heading">PAYOUT & VOUCHERS</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-note2"></i>
                                        Payments & Vouchers
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                    @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Super Admin')
                                        <li>
                                            <a href="/New/Payment/Record">
                                                <i class="metismenu-icon"></i>
                                                Record Payment
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Generate/Payment/Vouchers">
                                                <i class="metismenu-icon">
                                                </i>Generate Payment Vouchers
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/Generate/Payment/History">
                                                <i class="metismenu-icon">
                                                </i>View Payment History
                                            </a>
                                        </li>
                                    @elseif (Auth::user()->user_category == 'Cashiers' || Auth::user()->user_category == 'Secretary')
                                        <li>
                                            <a href="/New/Payment/Record">
                                                <i class="metismenu-icon"></i>
                                                Record Payment
                                            </a>
                                        </li>
                                    @elseif (Auth::user()->user_category == 'Director')
                                        <li>
                                            <a href="/Generate/Payment/History">
                                                <i class="metismenu-icon">
                                                </i>View Payment History
                                            </a>
                                        </li>
                                    @endif
                                        
                                    </ul>
                                </li>
                                <!--End - Payout & Vouchers Operation Menu -->

                                <!--Start - Storekeeping Operation Menu Start Here -->
                                <li class="app-sidebar__heading">STOREKEEPING</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-home"></i>
                                        Storekeeping
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="elements-buttons-standard.html">
                                                <i class="metismenu-icon"></i>
                                                Coming Soon!
                                            </a>
                                        </li>  
                                    </ul>
                                </li>
                                <!--End - Storekeeping Operation Menu -->

                                <!--Start - Inventory Operation Menu Start Here -->
                                <li class="app-sidebar__heading">INVENTORY</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-diskette"></i>
                                        Inventory
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="elements-buttons-standard.html">
                                                <i class="metismenu-icon"></i>
                                                Coming Soon!
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--End - Inventory Operation Menu -->

                                <!--Start - Users Operation Menu Start Here -->
                                @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Super Admin')
                                     <li class="app-sidebar__heading">USERS</li>
                                    <li>
                                        <a href="#">
                                            <i class="metismenu-icon pe-7s-user"></i>
                                            Users
                                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="/register">
                                                    <i class="metismenu-icon"></i>
                                                    Add New User
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/User/Disable">
                                                    <i class="metismenu-icon">
                                                    </i>Disable User
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/User/Enable">
                                                    <i class="metismenu-icon">
                                                    </i>Enable User
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li></li>
                                @endif
                               
                                <!--End - Users Operation Menu -->
                            </ul>
                        </div>
                    </div>
                </div> 