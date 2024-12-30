<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
</head>


<body class="container">
  <header class="header">
    <span class="icon">
      <i class="fa-solid fa-square-poll-horizontal horizontal"></i></span>

    <h1 class="header-ttl">Rese</h1>
</header>

<main class="show-main">
  {{-- 左側：店舗情報 --}}
  <div class="show-shop-info">
    <div class="shop-name-group">
    <a href="{{ route('shops.index') }}" class="back-to-shops">
      <i class="fa-solid fa-angle-left"></i>
    </a>

            <h2 class="shop-name">{{ $shop->name }}</h2>

    </div>
            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="show-shop-image">

            <p class="shop-tags">#{{ $shop->area->area_name }} #{{ $shop->genre->genre_name }}</p>

            <p class="shop-descrition">{{ $shop->description }}</p>
    </div>


{{-- 右側の予約フォーム --}}
    <div class="reservation-form">
        <h2>予約</h2>
            <form action="{{ route('reservations.confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                {{-- 日付入力 --}}
                <div class="show-form-group">
                    <label for="date">日付:</label>
                    <input type="date" name="date" id="date" required style="width: 200px;" value="{{ session('confirmationData.date', old('data', '')) }}">
                </div>

                {{-- 時間選択 --}}
                <div class="show-form-group">
                    <label for="time">時間:</label>
                      <select name="time" id="time" required>
                        @for ($hour = 10; $hour <= 22; $hour++)
                          <option value="{{ sprintf('%02d:00', $hour) }}"
                          {{ (session('confirmationData.time') == sprintf('%02d:00', $hour)) ? 'selected' : '' }}>
                        {{ sprintf('%02d:00', $hour) }}
                          </option>

                          <option value="{{ sprintf('%02d:30', $hour) }}"
                          {{ (session('confirmationData.time') == sprintf('%02d:30', $hour)) ? 'selected' : '' }}>
                        {{ sprintf('%02d:30', $hour) }}
                          </option>
                        @endfor
                      </select>
                </div>

                {{-- 人数選択 --}}
                <div class="show-form-group">
                    <label for="number">人数:</label>
                    <select name="number" id="number" required>
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}"
                              {{ (session('confirmationData.number', old('number')) == $i) ? 'selected' : '' }}>
                              {{ $i }}人
                            </option>
                        @endfor
                    </select>
                </div>

          <div class="confirm-button-group">
            {{-- 確認するボタン --}}
            <button type="submit" class="show-confirm-button">
            確認する
            </button>
            </form>

            {{-- 選びなおすボタン --}}
                <a href="{{ route('reservations.reset', ['shop' => $shop->id]) }}" class="select-again-button">
                    選びなおす
                </a>
          </div>


        <!-- 確認情報の表示 -->
      @if (session('confirmationData'))
            @php
                $confirmationData = session('confirmationData');
            @endphp

        {{-- 確認情報の表示 --}}
        <div class="confirmation-data">
          <p>店舗名: {{ $confirmationData['shop_name'] }}</p>
          <p>日付: {{ \Carbon\Carbon::parse($confirmationData['date'])->format('Y年m月d日') }}</p>
          <p>時間: {{ $confirmationData['time'] }}</p>
          <p>人数: {{ $confirmationData['number'] }}</p>
        </div>

      <!-- 予約確定ボタン -->
      <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <input type="hidden" name="date" value="{{ $confirmationData['date'] }}">
        <input type="hidden" name="time" value="{{ $confirmationData['time'] }}">
        <input type="hidden" name="number" value="{{ $confirmationData['number'] }}">
        <button type="submit" class="reserve-button">予約する</button>
      </form>
@else
    <!-- 確認情報がない場合、予約ボタンは無効 -->
    <button type="button" class="reserve-button" disabled>予約する</button>
@endif


    </div>
</main>

</body>

</html>
