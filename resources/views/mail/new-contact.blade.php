<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo contacto — 99web</title>
<style>
    body { margin: 0; padding: 0; background: #f4f4f5; font-family: Inter, -apple-system, sans-serif; color: #18181b; }
    .wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
    .header { background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%); padding: 28px 32px; }
    .header h1 { margin: 0; font-size: 20px; font-weight: 700; color: #fff; }
    .header p { margin: 4px 0 0; font-size: 13px; color: rgba(255,255,255,.7); }
    .body { padding: 28px 32px; }
    .field { margin-bottom: 18px; }
    .field label { display: block; font-size: 11px; font-weight: 600; color: #71717a; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 4px; }
    .field p { margin: 0; font-size: 15px; color: #18181b; word-break: break-word; }
    .field .message { background: #f9f9fb; border-left: 3px solid #7C3AED; padding: 12px 14px; border-radius: 0 6px 6px 0; font-size: 14px; line-height: 1.6; color: #3f3f46; white-space: pre-wrap; }
    .divider { border: none; border-top: 1px solid #e4e4e7; margin: 20px 0; }
    .meta { font-size: 12px; color: #a1a1aa; }
    .footer { background: #fafafa; border-top: 1px solid #e4e4e7; padding: 16px 32px; text-align: center; }
    .footer p { margin: 0; font-size: 12px; color: #a1a1aa; }
    .badge { display: inline-block; background: #ede9fe; color: #6D28D9; border-radius: 4px; padding: 2px 8px; font-size: 11px; font-weight: 600; }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <h1>Novo contacto recebido</h1>
        <p>Via formulário do site 99web</p>
    </div>

    <div class="body">

        <div class="field">
            <label>Nome</label>
            <p>{{ $contact->name }}</p>
        </div>

        <div class="field">
            <label>Email</label>
            <p><a href="mailto:{{ $contact->email }}" style="color:#7C3AED;">{{ $contact->email }}</a></p>
        </div>

        @if($contact->phone)
        <div class="field">
            <label>Telefone</label>
            <p><a href="tel:{{ $contact->phone }}" style="color:#7C3AED;">{{ $contact->phone }}</a></p>
        </div>
        @endif

        @if($contact->company)
        <div class="field">
            <label>Empresa</label>
            <p>{{ $contact->company }}</p>
        </div>
        @endif

        @if($contact->website_url)
        <div class="field">
            <label>Website atual</label>
            <p><a href="{{ $contact->website_url }}" target="_blank" style="color:#7C3AED;">{{ $contact->website_url }}</a></p>
        </div>
        @endif

        <hr class="divider">

        <div class="field">
            <label>Mensagem</label>
            <div class="message">{{ $contact->message }}</div>
        </div>

        <hr class="divider">

        <p class="meta">
            Origem: <span class="badge">{{ $contact->source ?? 'website' }}</span>
            &nbsp;·&nbsp;
            Recebido em {{ $contact->created_at->format('d/m/Y \à\s H:i') }}
        </p>

    </div>

    <div class="footer">
        <p>99web · <a href="https://99web.pt" style="color:#7C3AED;">99web.pt</a> · geral@99web.pt</p>
    </div>

</div>
</body>
</html>
