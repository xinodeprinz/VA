<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"> Dashboard </a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('momo*') ? 'active' : '' }}" data-bs-toggle="dropdown"
        href="#">
        Payment
    </a>
    <div class="dropdown-menu">
        <a href="{{ route('momo', ['type' => 'deposit']) }}" class="dropdown-item">Deposit</a>
        <a href="{{ route('momo', ['type' => 'withdrawal']) }}" class="dropdown-item">Withdraw</a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('video') ? 'active' : '' }}" href="{{ route('video') }}">Videos</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}"
        href="{{ route('transactions') }}">Transactions</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('referrals') ? 'active' : '' }}"
        href="{{ route('referrals') }}">Referrals</a>
</li>
