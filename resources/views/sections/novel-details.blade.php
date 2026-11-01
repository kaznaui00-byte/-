@extends('Layout.app')

@section('content')

<div dir="rtl" style="background:#faf9f6; min-height:100vh; padding:40px 20px; color:#29252c;">
    <div style="max-width:1000px; margin:auto;">

        <a href="{{ route('novels.index') }}"
           style="display:inline-block; margin-bottom:25px; color:#70518b; text-decoration:none;">
            ← العودة إلى الروايات
        </a>

        {{-- غلاف الرواية ومعلوماتها --}}
        <div style="display:grid; grid-template-columns:minmax(0, 1fr) 220px; gap:30px; align-items:start; background:white; padding:25px; border-radius:20px; border:1px solid #eee9ef;">

            <div>
                <span style="color:#806a91; font-size:13px; font-weight:bold;">
                    {{ $novel->genre }}
                </span>

                <h1 style="font-size:32px; font-weight:800; margin:12px 0;">
                    {{ $novel->title }}
                </h1>

                <p style="color:#777; margin-bottom:15px;">
                    الكاتب: {{ $novel->user->nickname ?: $novel->user->name }}
                </p>

                <p style="line-height:2; color:#625d66;">
                    {{ $novel->description ?: 'لا توجد نبذة عن هذه الرواية.' }}
                </p>

                <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:20px;">
                    <span style="background:#f1edf5; padding:8px 13px; border-radius:20px; font-size:13px;">
                        {{ $novel->length_type === 'short' ? 'رواية قصيرة' : 'رواية طويلة' }}
                    </span>

                    <span style="background:#f1edf5; padding:8px 13px; border-radius:20px; font-size:13px;">
                        {{ $novel->status === 'completed' ? 'مكتملة' : 'مستمرة' }}
                    </span>

                    <span style="background:#f1edf5; padding:8px 13px; border-radius:20px; font-size:13px;">
                        {{ $novel->chapters->count() }} فصل
                    </span>
                </div>
            </div>

            <div>
                @if ($novel->cover_image_path)
                    <img
                        src="{{ asset('storage/' . $novel->cover_image_path) }}"
                        alt="غلاف {{ $novel->title }}"
                        style="width:100%; height:280px; object-fit:cover; border-radius:14px;"
                    >
                @else
                    <div style="height:280px; background:#eee8f5; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#806a91;">
                        <svg width="65" height="65" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v17H6.5A2.5 2.5 0 0 0 4 22V5.5Z"/>
                            <path d="M4 6v16m4-14h8" stroke-linecap="round"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- الفصول --}}
        <div style="margin-top:40px;">
            <h2 style="font-size:25px; font-weight:800; margin-bottom:20px;">
                فصول الرواية
            </h2>

            @forelse ($novel->chapters as $chapter)

                <details style="background:white; border:1px solid #eee9ef; border-radius:14px; margin-bottom:12px; overflow:hidden;">

                    <summary style="padding:18px; cursor:pointer; font-weight:bold; display:flex; justify-content:space-between; gap:10px;">
                        <span>
                            الفصل {{ $chapter->chapter_number }}:
                            {{ $chapter->title }}
                        </span>
                        <span style="color:#806a91;">＋</span>
                    </summary>

                    <div style="padding:20px; border-top:1px solid #eee9ef; line-height:2.2; white-space:pre-line; color:#514b53;">
                        {{ $chapter->content }}
                    </div>

                </details>

            @empty

                <div style="background:white; border:1px solid #eee9ef; border-radius:16px; padding:40px 20px; text-align:center;">
                    <h3 style="font-weight:bold; margin-bottom:10px;">
                        لم تتم إضافة فصول بعد
                    </h3>
                    <p style="color:#888;">
                        ستظهر فصول الرواية هنا عند نشرها.
                    </p>
                </div>

            @endforelse
        </div>

        {{-- حذف الرواية لصاحبها فقط --}}
        @auth
            @if ($novel->user_id === auth()->id())
                <form
                    action="{{ route('novels.destroy', $novel) }}"
                    method="POST"
                    onsubmit="return confirm('هل أنت متأكدة من حذف الرواية وفصولها؟')"
                    style="margin-top:35px;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        style="background:#9f3434; color:white; border:0; border-radius:10px; padding:12px 22px; cursor:pointer;">
                        حذف الرواية
                    </button>
                </form>
            @endif
        @endauth

    </div>
</div>

@endsection