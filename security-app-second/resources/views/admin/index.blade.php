<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .label {
            font-size: 14px;
            color: #6b7280;
        }

        .value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 8px;
        }

        .panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
        }

        .empty {
            padding: 40px 20px;
            text-align: center;
            color: #6b7280;
        }

        .notice {
            padding: 12px 16px;
            margin-bottom: 20px;
            background: #ecfdf5;
            color: #166534;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .actions form {
            margin: 0;
        }

        .delete-button {
            padding: 0;
            border: 0;
            background: none;
            color: #b91c1c;
            font: inherit;
            cursor: pointer;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>管理者画面</h1>
            <a href="/contact">お問い合わせフォームへ</a>
        </div>

        @if (session('status'))
            <p class="notice">{{ session('status') }}</p>
        @endif

        <div class="cards">
            <div class="card">
                <div class="label">総件数</div>
                <div class="value">{{ $total }}</div>
            </div>
            <div class="card">
                <div class="label">本日</div>
                <div class="value">{{ $today }}</div>
            </div>
            <div class="card">
                <div class="label">最新更新</div>
                <div class="value">{{ $messages->first() ? $messages->first()->created_at->format('n/j') : '-' }}</div>
            </div>
        </div>

        <div class="panel">
            <table>
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>メッセージ</th>
                        <th>送信日時</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ Str::limit($message->message, 80) }}</td>
                            <td>{{ $message->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.messages.edit', $message) }}">編集</a>
                                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('このお問い合わせを削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-button" type="submit">削除</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">お問い合わせはまだありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>