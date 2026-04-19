<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая заявка</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h2 style="margin-bottom: 12px;">Новая заявка с сайта</h2>

    <p><strong>Имя:</strong> {{ $contact->name }}</p>
    <p><strong>Телефон:</strong> {{ $contact->phone }}</p>
    <p><strong>Email:</strong> {{ $contact->email ?: 'не указан' }}</p>
    <p><strong>Дата:</strong> {{ $contact->created_at?->format('d.m.Y H:i') }}</p>

    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e5e7eb;">

    <p style="color: #6b7280; font-size: 12px;">Это автоматическое уведомление от формы заявки на сайте.</p>
</body>
</html>
