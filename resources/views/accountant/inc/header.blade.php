<!doctype html>
<html lang="en">

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Web Based Account Manager.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css">
<link href="{{asset('main.css')}}" rel="stylesheet">
<link href="{{asset('style.css')}}" rel="stylesheet">

</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow bg-primary header-text-light">
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
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link">
                                <i class="nav-link-icon fa fa-database"> </i>
                                Dashboard
                            </a>
                        </li>
                        @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Super Admin')
                            <li class="dropdown nav-item">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    <i class="nav-link-icon fa fa-cog"></i>
                                    Setup
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="/Personalization" class="nav-link">Personalization(Name, Logo)</a></li>
                                    <li class="nav-item"><a href="/New_Session" class="nav-link">School Session Manager</a></li>
                                    <li class="nav-item"><a href="/New_Class" class="nav-link">Class Setup</a></li>
                                    <li class="nav-item"><a href="/School/Fees/Setup" class="nav-link">School Fees Setup</a></li>
                                    <li class="nav-item"><a href="/New_Receipts" class="nav-link">Other Receipts Setup</a></li>
                                    <li class="nav-item"><a href="/New_Payment/Expenditure" class="nav-link">Payments/Expenditures Setup</a></li>
                                    <li class="nav-item"><a href="/New_Payment_Mode" class="nav-link">Payment Modes</a></li>
                                    <li class="nav-item"><a href="/New_Bank" class="nav-link">Banks</a></li>
                                    <li class="nav-item"><a href="/New_Term" class="nav-link">School Term Manager</a></li>   
                                </ul>
                            </li>
                        @else

                        @endif
                        

                        <li class="dropdown nav-item">
                              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="nav-link-icon fa fa-edit"></i>
                                Receipts
                              </a>
                              <ul class="dropdown-menu">
                                @if (Auth::user()->user_category == 'Super Admin')
                                    <a href="/School_Fees_1" class="nav-link">
                                        School Fees
                                    </a>
                                    <li class="nav-item"><a href="/Other/Fees" class="nav-link">Other Receipts</a></li>
                                    <li class="nav-item"><a href="/SchFee_Transaction" class="nav-link">Query School Fees Transaction</a></li>
                                    <li class="nav-item"><a href="/Other/Transaction" class="nav-link">Query Other Transactions</a></li>
                                    <li class="nav-item"><a href="/Error/Deduction" class="nav-link">Error Deduction</a></li>
                                @elseif (Auth::user()->user_category == 'Accountant')
                                    <a href="/School_Fees_1" class="nav-link">School Fees History</a>
                                    <li class="nav-item"><a href="/Other/Fees" class="nav-link">Other Receipts History</a></li>
                                    <li class="nav-item"><a href="/SchFee_Transaction" class="nav-link">Query School Fees Transaction</a></li>
                                    <li class="nav-item"><a href="/Other/Transaction" class="nav-link">Query Other Transactions</a></li>
                                    <li class="nav-item"><a href="/Error/Deduction" class="nav-link">Error Deduction</a></li>
                                @elseif (Auth::user()->user_category == 'Cashiers')
                                    <a href="/School_Fees_1" class="nav-link">School Fees</a>
                                    <li class="nav-item"><a href="/Other/Fees" class="nav-link">Other Receipts</a></li>
                                    <li class="nav-item"><a href="/SchFee_Transaction" class="nav-link">Query School Fees Transaction</a></li>
                                    <li class="nav-item"><a href="/Other/Transaction" class="nav-link">Query Other Transactions</a></li>
                                @else
                                    <li class="nav-item"><a href="/SchFee_Transaction" class="nav-link">Query School Fees Transaction</a></li>
                                    <li class="nav-item"><a href="/Other/Transaction" class="nav-link">Query Other Transactions</a></li>
                                @endif
                              </ul>
                        </li>

                        {{-- <li class="btn-group nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-clipboard"></i>
                                Reports
                            </a>
                        </li> --}}

                        <li class="dropdown nav-item">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="nav-link-icon fa fa-clipboard"></i>
                                Reports
                            </a>
                              <ul class="dropdown-menu">
                                  <li class="nav-item"><a href="/Cleared_Students" class="nav-link">SCHOOL FEES CLEARED STUDENT</a></li>
                                  <li class="nav-item"><a href="/Defaulting_Students" class="nav-link">SCHOOL FEES DEFAULTING STUDENT</a></li>
                                  <li class="nav-item"><a href="/Other/Cleared/Students" class="nav-link">OTHER PAYMENTS CLEARED STUDENT</a></li>
                                  <li class="nav-item"><a href="/Other/Defaulting/Students" class="nav-link">OTHER PAYMENTS DEFAULTING STUDENT</a></li>
                                  
                              </ul>
                        </li>
                        @if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Super Admin')
                            <li class="dropdown nav-item">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    <i class="nav-link-icon fa fa-chart-bar"></i>
                                    Accounting
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="/School/Fee/Total/Term" class="nav-link">TOTAL SCHOOL FEES RECEIPTS - (TERM)</a></li>
                                    <li class="nav-item"><a href="/School/Fee/Total/Session" class="nav-link">TOTAL SCHOOL FEES RECEIPTS - (SESSION)</a></li>
                                    <li class="nav-item"><a href="/Other/Fee/Total/Term" class="nav-link">TOTAL RECEIPTS - OTHERS / (TERM)</a></li>
                                    <li class="nav-item"><a href="/Other/Fee/Total/Session" class="nav-link">TOTAL RECEIPTS - OTHERS / (SESSION)</a></li>
                                    <li class="nav-item"><a href="/Payment/Modes" class="nav-link">PAYMENT MODE ANALYSIS</a></li>
                                    <li class="nav-item"><a href="/Pre/Term/Query" class="nav-link">PRE TERM PAYMENT ANALYSIS</a></li>
                                    <li class="nav-item"><a href="/Post/Term/Query" class="nav-link">POST TERM PAYMENT ANALYSIS</a></li>
                                    <li class="nav-item"><a href="/Error/Deductions/Term" class="nav-link">ERROR DEDUCTIONS - (TERM)</a></li>
                                    <li class="nav-item"><a href="/Error/Deductions/Session" class="nav-link">ERROR DEDUCTIONS - (SESSION)</a></li>
                                    <li class="nav-item"><a href="/Expenditures/Total/Term" class="nav-link">TOTAL EXPENDITURE - (TERM)</a></li>
                                    
                                </ul>
                            </li>
                        @else

                        @endif
                        

                    </ul>        
                </div>

                 @guest
                                            
                @else
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                <div class="widget-content-left  mr-3 header-user-info">
                                        <div class="widget-heading">
                                            {{ Auth::user()->name }} ( {{ Auth::user()->username }} )
                                        </div>
                                        <div class="widget-subheading">
                                            {{$Details[0]['school_name']}} ( {{ Auth::user()->user_category }} )
                                        </div>
                                    </div>

                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <img width="42" class="rounded-circle" src="{{asset('assets/images/avatars/1.jpg')}}" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                                <button type="button" class="dropdown-item"><a href="/Change/Password">Change Password</a></button>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>        
                    </div>
                @endguest
            </div>
        </div> 
<div class="app-main">     
