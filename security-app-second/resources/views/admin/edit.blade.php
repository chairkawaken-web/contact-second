<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせの編集</title>
    <style>
        body {
            margin: 0;
            padding: 32px 20px;
            background: #f5f7fb;
            color: #1f2937;
            font-family: sans-serif;
        }

        main {
            max-width: 640px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }

        input,
        textarea {
            box-sizing: border-box;
            width: 100%;
            margin-top: 6px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font: inherit;
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        .error {
            color: #b91c1c;
        }

        .actions {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-top: 24px;
        }

        button {
            padding: 10px 18px;
            border: 0;
            border-radius: 4px;
            background: #166534;
            color: white;
            font: inherit;
            cursor: pointer;
        }

        a {
            color: #1d4ed8;
        }
    </style>
</head>
<body>
    <main>
        <h1>お問い合わせの編集</h1>

        <form method="POST" action="{{ route('admin.messages.update', $contactMessage) }}">
            @csrf
            @method('PUT')

            <label for="name">名前</label>
            <input id="name" name="name" type="text" value="{{ old('name', $contactMessage->name) }}" required>
            @error('name') <p class="error">{{ $message }}</p> @enderror

            <label for="email">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email', $contactMessage->email) }}" required>
            @error('email') <p class="error">{{ $message }}</p> @enderror

            <label for="message">メッセージ</label>
            <textarea id="message" name="message" required>{{ old('message', $contactMessage->message) }}</textarea>
            @error('message') <p class="error">{{ $message }}</p> @enderror

            <div class="actions">
                <button type="submit">変更を保存</button>
                <a href="{{ route('admin.index') }}">管理画面へ戻る</a>
            </div>
        </form>
    </main>
</body>
</html>