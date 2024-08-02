<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{route('forntdashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                @if(auth()->user()->user_type == 'Admin')
                    <a class="nav-link" href="{{route('account.create')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Add Account
                    </a>
                @else
                    <a class="nav-link" href="{{route('fundtransfer')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Fund Transfer
                    </a>
                @endif               
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{auth()->user()->first_name}} {{auth()->user()->last_name}}
        </div>
    </nav>
</div>