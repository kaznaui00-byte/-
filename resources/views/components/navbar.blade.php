@auth
    <a href="{{ url('/profile') }}" class="quoteit-account">
        حسابي
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="quoteit-logout">
            خروج
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="quoteit-account">
        دخول
    </a>

    <a href="{{ route('signup') }}" class="quoteit-account">
        إنشاء حساب
    </a>
@endauth