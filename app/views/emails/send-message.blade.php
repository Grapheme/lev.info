<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Сообщение от {{ $name }}
            @if ($email)
                &lt;{{ $email }}&gt;
            @endif
            @if ($phone)
                ({{ $phone }})
            @endif
        </p>
        <p>
			{{ Helper::nl2br($content) }}
		</p>
	</div>
</body>
</html>