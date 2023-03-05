<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"> Dashboard </a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('momo*') ? 'active' : '' }}" data-bs-toggle="dropdown"
        href="#">
        {{ __('main.Payment') }}
    </a>
    <div class="dropdown-menu text-capitalize">
        <a href="{{ route('momo', ['type' => 'deposit']) }}" class="dropdown-item">{{ __('main.deposit') }}</a>
        <a href="{{ route('momo', ['type' => 'withdrawal']) }}" class="dropdown-item">{{ __('main.withdraw') }}</a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('video') ? 'active' : '' }}"
        href="{{ route('video') }}">{{ __('main.Videos') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}"
        href="{{ route('transactions') }}">{{ __('main.Transactions') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link text-capitalize {{ request()->routeIs('referrals') ? 'active' : '' }}"
        href="{{ route('referrals') }}">{{ __('main.referrals') }}</a>
</li>
