<div class="profileMenu">
    <ul class="list-unstyled">
        <li class="{{ (Request::is('about-us')) ? 'active' : '' }}"><a href="#">Tentang Kami</a></li>
        <li class="{{ (Request::is('contact-us')) ? 'active' : '' }}"><a href="#">Hubungi Kami</a></li>
        <li class="{{ (Request::is('terms-and-conditions')) ? 'active' : '' }}"><a href="{{ url('terms-and-conditions') }}">Syarat dan Ketentuan</a></li>
        <li class="{{ (Request::is('privacy-policy')) ? 'active' : '' }}"><a href="{{ url('privacy-policy') }}">Kebijakan Privasi</a></li>
    </ul>
</div>