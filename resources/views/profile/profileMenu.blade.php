<div class="profileMenu">
    <ul class="list-unstyled">
        <li class="{{ (Request::is('profile')) ? 'active' : '' }}"><a href="{{ url('profile') }}">Profil</a></li>
        <li class="{{ (Request::is('profile/address')) ? 'active' : '' }}"><a href="{{ url('profile/address') }}">Alamat</a></li>
        <li class="{{ (Request::is('profile/order/*')) ? 'active' : '' }}"><a href="{{ url('profile/order') }}">Pesanan</a></li>
        <!-- <li><a href="{{ url('profile/review') }}">Ulasan</a></li> -->
    </ul>
</div>